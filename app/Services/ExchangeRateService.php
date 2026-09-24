<?php

namespace App\Services;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    /**
     * URLs de las APIs para Venezuela
     */
    const API_URL = 'https://ve.dolarapi.com/v1/dolares';
    const API_URL_OFICIAL = 'https://ve.dolarapi.com/v1/dolares/oficial';

    /**
     * Obtener tasas desde DolarApi.com (BCV oficial + paralelo) con fallback
     *
     * @return array|null ['oficial' => float, 'paralelo' => float, 'fecha' => string]
     */
    public function fetchFromApi(): ?array
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept' => 'application/json',
        ];

        // 1. Intentar endpoint general (todos los dólares)
        try {
            $response = Http::withoutVerifying()
                ->withHeaders($headers)
                ->timeout(12)
                ->get(self::API_URL);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && !empty($data)) {
                    $result = [
                        'oficial' => null,
                        'paralelo' => null,
                        'fecha' => now()->toDateString(),
                    ];

                    foreach ($data as $item) {
                        if (isset($item['fuente']) && $item['fuente'] === 'oficial') {
                            $result['oficial'] = (float) ($item['promedio'] ?? $item['precio'] ?? $item['monto'] ?? 0);
                            if (!empty($item['fechaActualizacion'])) {
                                $result['fecha'] = substr($item['fechaActualizacion'], 0, 10);
                            }
                        } elseif (isset($item['fuente']) && $item['fuente'] === 'paralelo') {
                            $result['paralelo'] = (float) ($item['promedio'] ?? $item['precio'] ?? $item['monto'] ?? 0);
                        }
                    }

                    if (!empty($result['oficial']) && $result['oficial'] > 0) {
                        Log::info('DolarApi (lista): tasa obtenida con éxito', $result);
                        return $result;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('DolarApi (lista) falló: ' . $e->getMessage());
        }

        // 2. Intentar endpoint directo de oficial
        try {
            $response = Http::withoutVerifying()
                ->withHeaders($headers)
                ->timeout(12)
                ->get(self::API_URL_OFICIAL);

            if ($response->successful()) {
                $item = $response->json();
                if (is_array($item)) {
                    $rate = (float) ($item['promedio'] ?? $item['precio'] ?? $item['monto'] ?? 0);
                    $fecha = !empty($item['fechaActualizacion']) ? substr($item['fechaActualizacion'], 0, 10) : now()->toDateString();
                    if ($rate > 0) {
                        $result = [
                            'oficial' => $rate,
                            'paralelo' => null,
                            'fecha' => $fecha,
                        ];
                        Log::info('DolarApi (oficial directo): tasa obtenida', $result);
                        return $result;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('DolarApi (oficial directo) falló: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Obtener la moneda de Venezuela (VES / Bs) de forma 100% segura e inequívoca
     */
    public static function getVenezuelaCurrency()
    {
        // 1. Buscar primero por país Venezuela o código VES
        $ves = \DB::table('currencies')
            ->where('country', 'like', '%Venezuela%')
            ->orWhere('code', 'VES')
            ->orWhere('code', 'VEF')
            ->first();

        if ($ves) {
            return $ves;
        }

        // 2. Si no, buscar por símbolo Bs o nombre Bolívares excluyendo Bolivia (BOB) explícitamente
        return \DB::table('currencies')
            ->where('code', '!=', 'BOB')
            ->where('country', 'not like', '%Bolivia%')
            ->where(function($q) {
                $q->where('currency', 'like', '%Bolivar%')
                  ->orWhere('currency', 'like', '%Bolívares%')
                  ->orWhere('symbol', 'Bs');
            })
            ->first();
    }

    /**
     * Obtener la moneda de USD de forma segura
     */
    public static function getUsdCurrency()
    {
        $usd = \DB::table('currencies')->whereIn(\DB::raw('UPPER(code)'), ['USD', 'US$'])->first();
        if ($usd) {
            return $usd;
        }

        return \DB::table('currencies')
            ->where('country', 'like', '%United States%')
            ->orWhere('country', 'like', '%America%')
            ->first();
    }

    /**
     * Actualizar la tasa de cambio en la base de datos para un negocio.
     * Usa la tasa BCV oficial por defecto.
     *
     * @param int $business_id
     * @param string $source 'oficial' o 'paralelo'
     * @param int|null $user_id Usuario que ejecuta la actualización
     * @return array ['success' => bool, 'message' => string, 'rate' => float|null]
     */
    public function updateRate(int $business_id, string $source = 'oficial', ?int $user_id = null): array
    {
        $apiData = $this->fetchFromApi();

        if (!$apiData) {
            return [
                'success' => false,
                'message' => 'No se pudo obtener la tasa desde el servicio del BCV (DolarApi). Verifique la conexión a internet.',
                'rate' => null,
            ];
        }

        $rate = $apiData[$source] ?? ($apiData['oficial'] ?? null);

        if (!$rate || $rate <= 0) {
            return [
                'success' => false,
                'message' => "No se encontró tasa '{$source}' en la respuesta de la API",
                'rate' => null,
            ];
        }

        // Asegurar que el business_id exista
        $businessExists = \DB::table('business')->where('id', $business_id)->exists();
        if (!$businessExists) {
            $business_id = \DB::table('business')->value('id') ?? 1;
        }

        // Buscar IDs de monedas USD y Venezuela (VES / Bs)
        $usd = self::getUsdCurrency();
        $ves = self::getVenezuelaCurrency();

        if (!$usd || !$ves) {
            return [
                'success' => false,
                'message' => 'No se encontraron las monedas USD o Bolívares (VES) en el catálogo de monedas. Verifique la tabla currencies.',
                'rate' => null,
            ];
        }

        $today = $apiData['fecha'] ?? now()->toDateString();

        // Verificar si ya existe una tasa para hoy
        $existing = ExchangeRate::where('business_id', $business_id)
            ->where('from_currency_id', $usd->id)
            ->where('to_currency_id', $ves->id)
            ->where('effective_date', $today)
            ->first();

        if ($existing) {
            $existing->update([
                'rate' => $rate,
                'notes' => "Actualizado automáticamente desde BCV/DolarApi ({$source})",
                'created_by' => $user_id,
            ]);
        } else {
            ExchangeRate::create([
                'business_id' => $business_id,
                'from_currency_id' => $usd->id,
                'to_currency_id' => $ves->id,
                'rate' => $rate,
                'effective_date' => $today,
                'created_by' => $user_id,
                'notes' => "Obtenido automáticamente desde BCV/DolarApi ({$source})",
            ]);
        }

        // Actualizar campo p_exchange_rate en la tabla business para compatibilidad nativa
        try {
            \DB::table('business')->where('id', $business_id)->update(['p_exchange_rate' => $rate]);
        } catch (\Throwable $e) {
            Log::warning("No se pudo actualizar p_exchange_rate para business {$business_id}: " . $e->getMessage());
        }

        // Limpiar caché en ambas direcciones
        Cache::forget("exchange_rate_{$business_id}_{$usd->id}_{$ves->id}");
        Cache::forget("exchange_rate_{$business_id}_{$ves->id}_{$usd->id}");

        $formatted_rate = number_format($rate, 4, ',', '.');

        return [
            'success' => true,
            'message' => "Tasa {$source} sincronizada con éxito: 1 USD = {$formatted_rate} Bs (fecha: {$today})",
            'rate' => $rate,
            'source' => $source,
            'date' => $today,
        ];
    }

    /**
     * Actualizar tasas para TODOS los negocios activos.
     *
     * @param string $source
     * @return array Resultados por negocio
     */
    public function updateAllBusinesses(string $source = 'oficial'): array
    {
        $businesses = \DB::table('business')
            ->where(function($query) {
                $query->where('is_active', 1)
                      ->orWhereNull('is_active');
            })
            ->pluck('id');

        $results = [];

        foreach ($businesses as $business_id) {
            $results[$business_id] = $this->updateRate($business_id, $source);
        }

        return $results;
    }

    /**
     * Obtener la tasa cacheada o desde la API.
     *
     * @param int $business_id
     * @return float|null
     */
    public function getCachedRate(int $business_id): ?float
    {
        $usd = self::getUsdCurrency();
        $ves = self::getVenezuelaCurrency();

        if (!$usd || !$ves) {
            return null;
        }

        return Cache::remember(
            "exchange_rate_{$business_id}_{$usd->id}_{$ves->id}",
            3600, // 1 hora
            function () use ($business_id, $usd, $ves) {
                return ExchangeRate::getRate($business_id, $usd->id, $ves->id);
            }
        );
    }
}
