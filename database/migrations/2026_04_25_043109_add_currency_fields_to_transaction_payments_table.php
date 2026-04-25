<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos de moneda a cada línea de pago para soportar
     * pagos mixtos (ej: parte en USD, parte en Bs).
     *
     * - payment_currency_id: moneda en la que se realizó este pago
     * - payment_exchange_rate: tasa usada para convertir a moneda base
     * - amount_in_base_currency: monto convertido a moneda base (USD)
     */
    public function up()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('payment_currency_id')->unsigned()->nullable()->after('amount');
            $table->decimal('payment_exchange_rate', 20, 6)->nullable()->after('payment_currency_id');
            $table->decimal('amount_in_base_currency', 22, 4)->nullable()->after('payment_exchange_rate');

            $table->foreign('payment_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->dropForeign(['payment_currency_id']);
            $table->dropColumn(['payment_currency_id', 'payment_exchange_rate', 'amount_in_base_currency']);
        });
    }
};
