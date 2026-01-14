<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Moneda en la que se realizó la transacción
            $table->integer('transaction_currency_id')->unsigned()->nullable()->after('business_id');
            $table->foreign('transaction_currency_id')->references('id')->on('currencies')->onDelete('set null');
            
            // Tasa de cambio usada (ya existe pero lo documentamos)
            // exchange_rate: 1 transaction_currency = ? base_currency
            // Si transaction_currency_id es NULL, se usa la moneda del negocio
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['transaction_currency_id']);
            $table->dropColumn('transaction_currency_id');
        });
    }
};
