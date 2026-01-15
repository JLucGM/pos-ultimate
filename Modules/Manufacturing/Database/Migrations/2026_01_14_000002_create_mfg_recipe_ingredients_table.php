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
        Schema::create('mfg_recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->integer('ingredient_product_id')->unsigned()->comment('Producto usado como ingrediente');
            $table->integer('variation_id')->unsigned()->nullable();
            $table->decimal('quantity', 22, 4)->comment('Cantidad necesaria');
            $table->integer('unit_id')->unsigned()->nullable();
            $table->decimal('cost_per_unit', 22, 4)->default(0);
            $table->decimal('total_cost', 22, 4)->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('recipe_id')->references('id')->on('mfg_recipes')->onDelete('cascade');
            $table->foreign('ingredient_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            
            $table->index(['recipe_id', 'ingredient_product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mfg_recipe_ingredients');
    }
};
