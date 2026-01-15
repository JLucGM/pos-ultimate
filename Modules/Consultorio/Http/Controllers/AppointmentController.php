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

        $business_id = request()->session()->get('user.business_id');

        // Para el calendario (AJAX)
        if (request()->ajax() && request()->has('start')) {
            $filters = [
                'start_date' => request()->start,
                'end_date' => request()->end,
                'location_id' => !empty(request()->location_id) ? request()->location_id : null,
                'business_id' => $business_id,
            ];

            $appointments = Appointment::where('business_id', $business_id)
                ->whereBetween('appointment_datetime', [$filters['start_date'], $filters['end_date']])
                ->with(['contact', 'assignedTo']);

            if ($filters['location_id']) {
                $appointments->where('location_id', $filters['location_id']);
            }

            $events = [];
            foreach ($appointments->get() as $appointment) {
                $color = '#f39c12'; // yellow - reserved
                if ($appointment->status == 'waiting') {
                    $color = '#f39c12'; // yellow
                } elseif ($appointment->status == 'in_service') {
                    $color = '#3c8dbc'; // blue
                } elseif ($appointment->status == 'completed') {
                    $color = '#00a65a'; // green
                } elseif ($appointment->status == 'cancelled') {
                    $color = '#dd4b39'; // red
                }

                $events[] = [
                    'id' => $appointment->id,
                    'title' => $appointment->contact->name ?? 'Sin nombre',
                    'start' => $appointment->appointment_datetime->toIso8601String(),
                    'end' => $appointment->appointment_datetime->addMinutes($appointment->duration_minutes)->toIso8601String(),
                    'color' => $color,
                    'customer_name' => $appointment->contact->name ?? 'Sin nombre',
                    'staff' => $appointment->assignedTo ? $appointment->assignedTo->first_name . ' ' . $appointment->assignedTo->last_name : 'No asignado',
                    'url' => action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$appointment->id]),
                ];
            }

            return response()->json($events);
        }

        // Para DataTable de citas de hoy
        if (request()->ajax() && request()->has('today')) {
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $appointments = Appointment::where('business_id', $business_id)
                ->whereDate('appointment_datetime', $today)
                ->whereIn('status', ['reserved', 'waiting', 'in_service'])
                ->with(['contact', 'assignedTo', 'location']);

            if (!empty(request()->location_id)) {
                $appointments->where('location_id', request()->location_id);
            }

            return DataTables::of($appointments)
                ->editColumn('contact', function ($row) {
                    return $row->contact ? $row->contact->name : '-';
                })
                ->editColumn('appointment_datetime', function ($row) {
                    return $row->appointment_datetime->format('H:i');
                })
                ->editColumn('assignedTo', function ($row) {
                    return $row->assignedTo ? $row->assignedTo->first_name . ' ' . $row->assignedTo->last_name : '-';
                })
                ->editColumn('location', function ($row) {
                    return $row->location ? $row->location->name : '-';
                })
                ->removeColumn('id')
                ->make(true);
        }

        $business_locations = BusinessLocation::forDropdown($business_id);
        $customers = Contact::customersDropdown($business_id, false);
        $staff = User::where('business_id', $business_id)
            ->select('id', 'first_name', 'last_name')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->first_name . ' ' . $user->last_name];
            });

        // Variables para el modal de creación de contactos
        $types = Contact::getContactTypes();
        $customer_groups = \App\CustomerGroup::forDropdown($business_id);

        return view('consultorio::appointments.index', compact('business_locations', 'customers', 'staff', 'types', 'customer_groups'));
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

        try {
            $business_id = request()->session()->get('user.business_id');
            
            $appointment = Appointment::where('business_id', $business_id)
                ->with(['contact', 'assignedTo', 'location', 'transaction', 'creator'])
                ->findOrFail($id);

            if (request()->ajax()) {
                $appointment_datetime = $this->commonUtil->format_date($appointment->appointment_datetime, true);
                
                $appointment_statuses = [
                    'reserved' => 'Reservada',
                    'waiting' => 'En Espera',
                    'in_service' => 'Atendiendo',
                    'completed' => 'Atendido',
                    'cancelled' => 'Cancelada',
                ];

                return view('consultorio::appointments.show_modal', compact('appointment', 'appointment_datetime', 'appointment_statuses'));
            }

            return view('consultorio::appointments.show', compact('appointment'));
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Error al cargar la cita: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('status', [
                'success' => false,
                'msg' => 'Error al cargar la cita'
            ]);
        }
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

            if (request()->ajax()) {
                return response()->json($output);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al actualizar la cita'
            ];

            if (request()->ajax()) {
                return response()->json($output);
            }
        }

        return redirect()->action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index'])->with('status', $output);
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
}
