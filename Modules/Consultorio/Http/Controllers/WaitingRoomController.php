<?php

namespace Modules\Consultorio\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Consultorio\Entities\Appointment;

class WaitingRoomController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('consultorio.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        // Obtener citas del día actual que no estén canceladas o completadas
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();
        
        $appointments = Appointment::where('business_id', $business_id)
            ->whereBetween('appointment_datetime', [$today, $tomorrow])
            ->whereIn('status', ['reserved', 'waiting', 'in_service'])
            ->with(['contact', 'assignedTo', 'location'])
            ->orderBy('appointment_datetime')
            ->get();

        return view('consultorio::waiting_room.index', compact('appointments'));
    }

    public function refresh()
    {
        $business_id = request()->session()->get('user.business_id');
        
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();
        
        $appointments = Appointment::where('business_id', $business_id)
            ->whereBetween('appointment_datetime', [$today, $tomorrow])
            ->whereIn('status', ['reserved', 'waiting', 'in_service'])
            ->with(['contact', 'assignedTo'])
            ->orderBy('appointment_datetime')
            ->get();

        return view('consultorio::waiting_room.partials.appointments_list', compact('appointments'));
    }
}
