<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'country',
        'currency',
        'code',
        'symbol',
        'thousand_separator',
        'decimal_separator'
    ];

    public function exchangeRatesFrom()
    {
        return $this->hasMany(ExchangeRate::class, 'from_currency_id');
    }

    public function exchangeRatesTo()
    {
        return $this->hasMany(ExchangeRate::class, 'to_currency_id');
    }
}
