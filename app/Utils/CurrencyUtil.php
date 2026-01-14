<?php

namespace App\Utils;

use App\Models\Currency;
use App\Models\ExchangeRate;

class CurrencyUtil extends Util
{
    /**
     * Obtener la tasa de cambio entre dos monedas para una fecha específica
     * 
     * @param int $business_id
     * @param int $from_currency_id
     * @param int $to_currency_id
     * @param string|null $date
     * @return float|null
     */
    public function getExchangeRate($business_id, $from_currency_id, $to_currency_id, $date = null)
    {
        return ExchangeRate::getRate($business_id, $from_currency_id, $to_currency_id, $date);
    }

    /**
     * Convertir un monto de una moneda a otra
     * 
     * @param float $amount
     * @param int $business_id
     * @param int $from_currency_id
     * @param int $to_currency_id
     * @param string|null $date
     * @return float|null
     */
    public function convertAmount($amount, $business_id, $from_currency_id, $to_currency_id, $date = null)
    {
        return ExchangeRate::convert($amount, $business_id, $from_currency_id, $to_currency_id, $date);
    }

    /**
     * Obtener la moneda base del negocio
     * 
     * @param int $business_id
     * @return Currency|null
     */
    public function getBusinessCurrency($business_id)
    {
        $business = \App\Business::find($business_id);
        return $business ? $business->currency : null;
    }

    /**
     * Formatear un monto con el símbolo de la moneda
     * 
     * @param float $amount
     * @param int $currency_id
     * @param int $business_id
     * @return string
     */
    public function formatWithCurrency($amount, $currency_id, $business_id)
    {
        $currency = Currency::find($currency_id);
        
        if (!$currency) {
            return $this->num_f($amount, true, $business_id);
        }

        $formatted_amount = number_format(
            $amount,
            2,
            $currency->decimal_separator,
            $currency->thousand_separator
        );

        return $currency->symbol . ' ' . $formatted_amount;
    }

    /**
     * Obtener todas las monedas activas
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getActiveCurrencies()
    {
        return Currency::select('id', 'currency', 'code', 'symbol')
            ->orderBy('currency')
            ->get();
    }

    /**
     * Verificar si hay una tasa de cambio disponible
     * 
     * @param int $business_id
     * @param int $from_currency_id
     * @param int $to_currency_id
     * @param string|null $date
     * @return bool
     */
    public function hasExchangeRate($business_id, $from_currency_id, $to_currency_id, $date = null)
    {
        $rate = $this->getExchangeRate($business_id, $from_currency_id, $to_currency_id, $date);
        return $rate !== null;
    }

    /**
     * Convertir el total de una transacción a la moneda base del negocio
     * 
     * @param \App\Transaction $transaction
     * @return float
     */
    public function convertTransactionToBaseCurrency($transaction)
    {
        // Si no tiene moneda de transacción, ya está en moneda base
        if (empty($transaction->transaction_currency_id)) {
            return $transaction->final_total;
        }

        $business = $transaction->business;
        
        // Si la moneda de transacción es la misma que la del negocio
        if ($transaction->transaction_currency_id == $business->currency_id) {
            return $transaction->final_total;
        }

        // Usar la tasa de cambio almacenada en la transacción
        if (!empty($transaction->exchange_rate) && $transaction->exchange_rate > 0) {
            return $transaction->final_total * $transaction->exchange_rate;
        }

        // Si no hay tasa almacenada, buscar en el sistema
        $rate = $this->getExchangeRate(
            $transaction->business_id,
            $transaction->transaction_currency_id,
            $business->currency_id,
            $transaction->transaction_date
        );

        if ($rate) {
            return $transaction->final_total * $rate;
        }

        // Si no hay tasa disponible, retornar el monto original
        return $transaction->final_total;
    }

    /**
     * Obtener información de múltiples monedas para mostrar en el POS
     * 
     * @param int $business_id
     * @param array $currency_ids
     * @return array
     */
    public function getCurrenciesWithRates($business_id, $currency_ids = [])
    {
        $business = \App\Business::find($business_id);
        $base_currency_id = $business->currency_id;

        $currencies = Currency::whereIn('id', $currency_ids)->get();
        
        $result = [];
        foreach ($currencies as $currency) {
            $rate = $this->getExchangeRate($business_id, $currency->id, $base_currency_id);
            
            $result[] = [
                'id' => $currency->id,
                'currency' => $currency->currency,
                'code' => $currency->code,
                'symbol' => $currency->symbol,
                'rate_to_base' => $rate,
                'is_base' => $currency->id == $base_currency_id
            ];
        }

        return $result;
    }
}
