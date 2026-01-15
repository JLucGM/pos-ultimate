<?php

namespace Modules\Consultorio\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Consultorio\Entities\Appointment;
use App\Contact;
use App\User;
use App\BusinessLocation;
use Yajra\DataTables\Facades\DataTables;
use DB;

class AppointmentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('consultorio.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $appointments = Appointment::where('business_id', $business_id)
                ->with(['contact', 'assignedTo', 'location'])
                ->select('appointments.*');

            return DataTables::of($appointments)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">';
                    $html .= '<button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">Acciones</button>';
                    $html .= '<ul class="dropdown-menu dropdown-menu-right" role="menu">';
                    
                    $html .= '<li><a href="' . action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$row->id]) . '"><i class="fa fa-eye"></i> Ver</a></li>';
                    
                    if ($row->status == 'reserved' && auth()->user()->can('consultorio.edit')) {
                        $html .= '<li><a href="' . action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'edit'], [$row->id]) . '"><i class="fa fa-edit"></i> Editar</a></li>';
                    }
                    
                    if (in_array($row->status, ['reserved', 'waiting']) && auth()->user()->can('consultorio.delete')) {
                        $html .= '<li><a href="#" class="cancel-appointment" data-href="' . action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'cancel'], [$row->id]) . '"><i class="fa fa-times"></i> Cancelar</a></li>';
                    }
                    
                    $html .= '</ul></div>';
                    return $html;
                })
                ->editColumn('contact.name', function ($row) {
                    return $row->contact ? $row->contact->name : '-';
                })
                ->editColumn('assignedTo.user_full_name', function ($row) {
                    return $row->assignedTo ? $row->assignedTo->user_full_name : '-';
                })
                ->editColumn('appointment_datetime', function ($row) {
                    return $row->appointment_datetime->format('d/m/Y H:i');
                })
                ->editColumn('status', function ($row) {
                    return $row->status_badge;
                })
                ->editColumn('estimated_amount', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' . $row->estimated_amount . '</span>';
                })
                ->rawColumns(['action', 'status', 'estimated_amount'])
                ->make(true);
        }

        return view('consultorio::appointments.index');
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
            ->pluck('user_full_name', 'id');
        
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

            $appointment = Appointment::create([
                'business_id' => $business_id,
                'location_id' => $request->location_id,
                'contact_id' => $request->contact_id,
                'assigned_to' => $request->assigned_to,
                'appointment_number' => Appointment::generateAppointmentNumber($business_id),
                'appointment_datetime' => $request->appointment_datetime,
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
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al crear la cita: ' . $e->getMessage()
            ];
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

        return view('consultorio::appointments.show', compact('appointment'));
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
            ->pluck('user_full_name', 'id');
        
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

            $appointment->update([
                'location_id' => $request->location_id,
                'contact_id' => $request->contact_id,
                'assigned_to' => $request->assigned_to,
                'appointment_datetime' => $request->appointment_datetime,
                'duration_minutes' => $request->duration_minutes ?? 30,
                'notes' => $request->notes,
                'service_description' => $request->service_description,
                'estimated_amount' => $request->estimated_amount ?? 0,
            ]);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Cita actualizada exitosamente'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al actualizar la cita'
            ];
        }

        return redirect()->action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index'])->with('status', $output);
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
            
            if ($appointment->changeStatus($new_status)) {
                $output = [
                    'success' => true,
                    'msg' => 'Estado actualizado exitosamente'
                ];
            } else {
                $output = [
                    'success' => false,
                    'msg' => 'No se puede cambiar al estado solicitado'
                ];
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al cambiar el estado'
            ];
        }

        return response()->json($output);
    }
}
