<?php

namespace App\Services;

use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    /**
     * URL de la API de DolarApi.com para Venezuela
     */
    const API_URL = 'https://ve.dolarapi.com/v1/dolares';

    /**
     * Obtener tasas desde DolarApi.com (BCV oficial + paralelo)
     *
     * @return array|null ['oficial' => float, 'paralelo' => float, 'fecha' => string]
     */
    public function fetchFromApi(): ?array
    {
        try {
            $response = Http::timeout(10)->get(self::API_URL);

            if (!$response->successful()) {
                Log::warning('DolarApi: respuesta no exitosa', [
                    'status' => $response->status(),
                ]);
                return null;
            }

            $data = $response->json();

            $result = [
                'oficial' => null,
                'paralelo' => null,
                'fecha' => now()->toDateString(),
            ];

            foreach ($data as $item) {
                if ($item['fuente'] === 'oficial') {
                    $result['oficial'] = (float) $item['promedio'];
                    if (!empty($item['fechaActualizacion'])) {
                        $result['fecha'] = substr($item['fechaActualizacion'], 0, 10);
                    }
                } elseif ($item['fuente'] === 'paralelo') {
                    $result['paralelo'] = (float) $item['promedio'];
                }
            }

            Log::info('DolarApi: tasas obtenidas', $result);

            return $result;

        } catch (\Exception $e) {
            Log::error('DolarApi: error al consultar API', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
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
                'message' => 'No se pudo obtener la tasa desde DolarApi.com',
                'rate' => null,
            ];
        }

        $rate = $apiData[$source] ?? null;

        if (!$rate || $rate <= 0) {
            return [
                'success' => false,
                'message' => "No se encontró tasa '{$source}' en la respuesta de la API",
                'rate' => null,
            ];
        }

        // Buscar IDs de monedas USD y VES/VEF
        $usd = \DB::table('currencies')->where('code', 'USD')->first();
        $ves = \DB::table('currencies')->where('code', 'VES')
            ->orWhere('code', 'VEF')
            ->orWhere('code', 'Bs')
            ->first();

        if (!$usd || !$ves) {
            return [
                'success' => false,
                'message' => 'No se encontraron las monedas USD o VES/Bs en el sistema. Verifica la tabla currencies.',
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
                'notes' => "Actualizado automáticamente desde DolarApi.com ({$source})",
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
                'notes' => "Obtenido automáticamente desde DolarApi.com ({$source})",
            ]);
        }

        // Limpiar caché
        Cache::forget("exchange_rate_{$business_id}_{$usd->id}_{$ves->id}");

        return [
            'success' => true,
            'message' => "Tasa {$source} actualizada: 1 USD = {$rate} Bs (fecha: {$today})",
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
            ->where('is_active', 1)
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
        $usd = \DB::table('currencies')->where('code', 'USD')->first();
        $ves = \DB::table('currencies')->where('code', 'VES')
            ->orWhere('code', 'VEF')
            ->orWhere('code', 'Bs')
            ->first();

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
