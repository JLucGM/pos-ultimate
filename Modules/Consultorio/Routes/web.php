<?php

use Illuminate\Support\Facades\Route;
use Modules\Consultorio\Http\Controllers\AppointmentController;
use Modules\Consultorio\Http\Controllers\WaitingRoomController;
use Modules\Consultorio\Http\Controllers\CalendarController;

Route::middleware(['web', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'])->prefix('consultorio')->group(function() {
    
    // Rutas de Citas
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('consultorio.appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('consultorio.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('consultorio.appointments.store');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('consultorio.appointments.show');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('consultorio.appointments.edit');
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('consultorio.appointments.update');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('consultorio.appointments.cancel');
    Route::post('/appointments/{id}/change-status', [AppointmentController::class, 'changeStatus'])->name('consultorio.appointments.changeStatus');
    
    // Sala de Espera
    Route::get('/waiting-room', [WaitingRoomController::class, 'index'])->name('consultorio.waiting_room.index');
    Route::get('/waiting-room/refresh', [WaitingRoomController::class, 'refresh'])->name('consultorio.waiting_room.refresh');
    
    // Calendario (para futuro)
    // Route::get('/calendar', [CalendarController::class, 'index'])->name('consultorio.calendar.index');
});
