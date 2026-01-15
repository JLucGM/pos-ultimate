<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mfg_recipes', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned();
            $table->integer('product_id')->unsigned()->comment('Producto final que se manufactura');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity_produced', 22, 4)->default(1)->comment('Cantidad que produce esta receta');
            $table->decimal('total_cost', 22, 4)->default(0)->comment('Costo total calculado');
            $table->integer('preparation_time_minutes')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['business_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mfg_recipes');
    }
};
