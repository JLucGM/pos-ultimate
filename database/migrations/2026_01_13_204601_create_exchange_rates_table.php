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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned();
            $table->integer('from_currency_id')->unsigned();
            $table->integer('to_currency_id')->unsigned();
            $table->decimal('rate', 20, 6);
            $table->date('effective_date');
            $table->integer('created_by')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('from_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('to_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            
            // Índice para búsquedas rápidas con nombre corto
            $table->index(['business_id', 'from_currency_id', 'to_currency_id', 'effective_date'], 'exchange_rates_lookup_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
};
