<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mfg_production_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->unsignedBigInteger('recipe_id');
            $table->string('ref_no')->unique();
            $table->decimal('quantity_to_produce', 22, 4);
            $table->decimal('quantity_produced', 22, 4)->default(0);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->datetime('production_date');
            $table->datetime('completion_date')->nullable();
            $table->decimal('total_cost', 22, 4)->default(0);
            $table->integer('transaction_id')->unsigned()->nullable()->comment('ID de transacción de stock');
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('business_locations')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('mfg_recipes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['business_id', 'status', 'production_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mfg_production_orders');
    }
};
