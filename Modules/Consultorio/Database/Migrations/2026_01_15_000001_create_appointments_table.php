<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('contact_id'); // Paciente/Cliente
            $table->unsignedInteger('assigned_to')->nullable(); // Doctor/Estilista
            $table->string('appointment_number')->unique();
            $table->dateTime('appointment_datetime');
            $table->integer('duration_minutes')->default(30);
            $table->enum('status', ['reserved', 'waiting', 'attending', 'completed', 'cancelled'])->default('reserved');
            $table->text('notes')->nullable();
            $table->text('service_description')->nullable();
            $table->decimal('estimated_amount', 22, 4)->default(0);
            $table->unsignedInteger('transaction_id')->nullable(); // Venta asociada
            $table->unsignedInteger('created_by');
            $table->timestamps();
            
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('business_locations')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
