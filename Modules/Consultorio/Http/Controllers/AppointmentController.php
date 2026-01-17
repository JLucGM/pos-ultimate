<?php

namespace Modules\Consultorio\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Consultorio\Entities\Appointment;
use App\Contact;
use App\User;
use App\BusinessLocation;
use App\Utils\Util;
use Yajra\DataTables\Facades\DataTables;
use DB;

class AppointmentController extends Controller
{
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    public function index()
    {
        if (!auth()->user()->can('consultorio.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('consultorio::appointments.index_simple');
    }

    public function calendar()
    {
        if (!auth()->user()->can('consultorio.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('consultorio::appointments.calendar');
    }

    public function getCalendarEvents(Request $request)
    {
        if (!auth()->user()->can('consultorio.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $start = $request->start;
        $end = $request->end;
        
        $appointments = Appointment::where('business_id', $business_id)
            ->whereBetween('appointment_datetime', [$start, $end])
            ->with(['contact', 'assignedTo'])
            ->get();
        
        $events = [];
        
        foreach ($appointments as $appointment) {
            $color = '#3c8dbc'; // Azul por defecto
            
            switch ($appointment->status) {
                case 'reserved':
                    $color = '#0073b7'; // Azul
                    break;
                case 'waiting':
                    $color = '#f39c12'; // Naranja
                    break;
                case 'in_service':
                    $color = '#00c0ef'; // Azul claro
                    break;
                case 'completed':
                    $color = '#00a65a'; // Verde
                    break;
                case 'cancelled':
                    $color = '#dd4b39'; // Rojo
                    break;
            }
            
            $endTime = $appointment->appointment_datetime->copy()->addMinutes($appointment->duration_minutes);
            
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->contact ? $appointment->contact->name : 'Sin cliente',
                'start' => $appointment->appointment_datetime->toIso8601String(),
                'end' => $endTime->toIso8601String(),
                'color' => $color,
                'url' => action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$appointment->id]),
                'time' => $appointment->appointment_datetime->format('H:i'),
            ];
        }
        
        return response()->json($events);
    }

    public function create()
    {
        if (!auth()->user()->can('consultorio.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $contacts = Contact::where('business_id', $business_id)
            ->where('type', 'customer')
            ->pluck('name', 'id');
        
        $staff = User::where('business_id', $business_id)
            ->select('id', 'first_name', 'last_name')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->first_name . ' ' . $user->last_name];
            });
        
        $locations = BusinessLocation::where('business_id', $business_id)
            ->pluck('name', 'id');

        return view('consultorio::appointments.create', compact('contacts', 'staff', 'locations'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('consultorio.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');
            
            $request->validate([
                'contact_id' => 'required|exists:contacts,id',
                'appointment_datetime' => 'required|date',
                'location_id' => 'required|exists:business_locations,id',
            ]);

            DB::beginTransaction();

            $datetime = $this->commonUtil->uf_date($request->appointment_datetime, true);

            $appointment = Appointment::create([
                'business_id' => $business_id,
                'location_id' => $request->location_id,
                'contact_id' => $request->contact_id,
                'assigned_to' => $request->assigned_to,
                'appointment_number' => Appointment::generateAppointmentNumber($business_id),
                'appointment_datetime' => $datetime,
                'duration_minutes' => $request->duration_minutes ?? 30,
                'status' => 'reserved',
                'notes' => $request->notes,
                'service_description' => $request->service_description,
                'estimated_amount' => $request->estimated_amount ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Cita creada exitosamente'
            ];

            if (request()->ajax()) {
                return response()->json($output);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al crear la cita: ' . $e->getMessage()
            ];

            if (request()->ajax()) {
                return response()->json($output);
            }
        }

        return redirect()->action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index'])->with('status', $output);
    }

    public function show($id)
    {
        if (!auth()->user()->can('consultorio.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $appointment = Appointment::where('business_id', $business_id)
            ->with(['contact', 'assignedTo', 'location', 'transaction', 'creator'])
            ->findOrFail($id);

        return view('consultorio::appointments.show_simple', compact('appointment'));
    }

    public function edit($id)
    {
        if (!auth()->user()->can('consultorio.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $appointment = Appointment::where('business_id', $business_id)->findOrFail($id);
        
        if ($appointment->status != 'reserved') {
            return redirect()->back()->with('status', [
                'success' => false,
                'msg' => 'Solo se pueden editar citas en estado Reservada'
            ]);
        }
        
        $contacts = Contact::where('business_id', $business_id)
            ->where('type', 'customer')
            ->pluck('name', 'id');
        
        $staff = User::where('business_id', $business_id)
            ->select('id', 'first_name', 'last_name')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->first_name . ' ' . $user->last_name];
            });
        
        $locations = BusinessLocation::where('business_id', $business_id)
            ->pluck('name', 'id');

        return view('consultorio::appointments.edit', compact('appointment', 'contacts', 'staff', 'locations'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('consultorio.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');
            
            $appointment = Appointment::where('business_id', $business_id)->findOrFail($id);

            $request->validate([
                'contact_id' => 'required|exists:contacts,id',
                'appointment_datetime' => 'required|date',
                'location_id' => 'required|exists:business_locations,id',
            ]);

            DB::beginTransaction();

            $datetime = $this->commonUtil->uf_date($request->appointment_datetime, true);

            $appointment->update([
                'location_id' => $request->location_id,
                'contact_id' => $request->contact_id,
                'assigned_to' => $request->assigned_to,
                'appointment_datetime' => $datetime,
                'duration_minutes' => $request->duration_minutes ?? 30,
                'notes' => $request->notes,
                'service_description' => $request->service_description,
                'estimated_amount' => $request->estimated_amount ?? 0,
                'status' => $request->status ?? $appointment->status,
            ]);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Cita actualizada exitosamente'
            ];

            return redirect()->action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$id])->with('status', $output);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al actualizar la cita'
            ];

            return redirect()->back()->with('status', $output);
        }
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('consultorio.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            
            $appointment = Appointment::where('business_id', $business_id)->findOrFail($id);
            $appointment->delete();

            $output = [
                'success' => true,
                'msg' => 'Cita eliminada exitosamente'
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al eliminar la cita'
            ];
        }

        return response()->json($output);
    }

    public function cancel($id)
    {
        if (!auth()->user()->can('consultorio.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            
            $appointment = Appointment::where('business_id', $business_id)->findOrFail($id);
            $appointment->status = 'cancelled';
            $appointment->save();

            $output = [
                'success' => true,
                'msg' => 'Cita cancelada exitosamente'
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al cancelar la cita'
            ];
        }

        return response()->json($output);
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $business_id = request()->session()->get('user.business_id');
            
            $appointment = Appointment::where('business_id', $business_id)->findOrFail($id);
            
            $new_status = $request->status;
            
            // Actualizar el estado directamente sin validación de transiciones
            $appointment->status = $new_status;
            $appointment->save();
            
            $status_names = [
                'reserved' => 'Reservada',
                'waiting' => 'En Espera',
                'in_service' => 'Atendiendo',
                'completed' => 'Atendido',
                'cancelled' => 'Cancelada',
            ];
            
            $output = [
                'success' => true,
                'msg' => 'Estado cambiado a: ' . ($status_names[$new_status] ?? $new_status)
            ];
            
            // Si es una petición AJAX, devolver JSON
            if ($request->ajax()) {
                return response()->json($output);
            }
            
            // Si no es AJAX, redirigir de vuelta
            return redirect()->back()->with('status', $output);
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al cambiar el estado: ' . $e->getMessage()
            ];
            
            if ($request->ajax()) {
                return response()->json($output);
            }
            
            return redirect()->back()->with('status', $output);
        }
    }
}
