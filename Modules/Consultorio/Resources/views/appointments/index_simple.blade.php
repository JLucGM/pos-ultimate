@extends('layouts.app')
@section('title', 'Citas')

@section('content')
<section class="content-header">
    <h1>Gestión de Citas</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Citas</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('consultorio.appointments.calendar') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-calendar"></i> Ver Calendario
                        </a>
                        <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'create']) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Nueva Cita
                        </a>
                        <a href="{{ action([\Modules\Consultorio\Http\Controllers\WaitingRoomController::class, 'index']) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-users"></i> Sala de Espera
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @php
                        $business_id = session('user.business_id');
                        $appointments = \Modules\Consultorio\Entities\Appointment::where('business_id', $business_id)
                            ->with(['contact', 'assignedTo', 'location'])
                            ->orderBy('appointment_datetime', 'desc')
                            ->paginate(20);
                    @endphp
                    
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Paciente/Cliente</th>
                                        <th>Fecha y Hora</th>
                                        <th>Asignado a</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $apt)
                                    <tr>
                                        <td>{{ $apt->appointment_number }}</td>
                                        <td>{{ $apt->contact ? $apt->contact->name : '-' }}</td>
                                        <td>{{ $apt->appointment_datetime->format('d/m/Y H:i') }}</td>
                                        <td>{{ $apt->assignedTo ? $apt->assignedTo->first_name . ' ' . $apt->assignedTo->last_name : '-' }}</td>
                                        <td>{!! $apt->status_badge !!}</td>
                                        <td>
                                            <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$apt->id]) }}" class="btn btn-info btn-xs">
                                                <i class="fa fa-eye"></i> Ver
                                            </a>
                                            @if($apt->status == 'reserved')
                                                <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'edit'], [$apt->id]) }}" class="btn btn-warning btn-xs">
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-center">
                            {{ $appointments->links() }}
                        </div>
                    @else
                        <p class="text-muted">No hay citas registradas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
