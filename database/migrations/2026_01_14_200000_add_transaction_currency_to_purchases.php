<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionCurrencyToPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // El campo transaction_currency_id ya existe en transactions
        // Solo necesitamos asegurarnos de que se use correctamente en compras
        // Esta migración es un placeholder para documentar el cambio
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No hay cambios que revertir
    }
}
