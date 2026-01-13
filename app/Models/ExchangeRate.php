<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'business_id',
        'from_currency_id',
        'to_currency_id',
        'rate',
        'effective_date',
        'created_by',
        'notes'
    ];

    protected $casts = [
        'effective_date' => 'date',
        'rate' => 'decimal:6'
    ];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }

    public function fromCurrency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'from_currency_id');
    }

    public function toCurrency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'to_currency_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Obtener la tasa de cambio vigente para una fecha específica
     */
    public static function getRate($business_id, $from_currency_id, $to_currency_id, $date = null)
    {
        $date = $date ?? now()->toDateString();
        
        // Si son la misma moneda, la tasa es 1
        if ($from_currency_id == $to_currency_id) {
            return 1;
        }

        $rate = self::where('business_id', $business_id)
            ->where('from_currency_id', $from_currency_id)
            ->where('to_currency_id', $to_currency_id)
            ->where('effective_date', '<=', $date)
            ->orderBy('effective_date', 'desc')
            ->first();

        return $rate ? $rate->rate : null;
    }

    /**
     * Convertir un monto de una moneda a otra
     */
    public static function convert($amount, $business_id, $from_currency_id, $to_currency_id, $date = null)
    {
        $rate = self::getRate($business_id, $from_currency_id, $to_currency_id, $date);
        
        if ($rate === null) {
            return null; // No hay tasa disponible
        }

        return $amount * $rate;
    }
}
