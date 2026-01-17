@extends('layouts.app')
@section('title', 'Detalle de Cita')

@section('content')
<section class="content-header">
    <h1>Cita: {{ $appointment->appointment_number }}</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de la Cita</h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <th width="30%">Número:</th>
                            <td>{{ $appointment->appointment_number }}</td>
                        </tr>
                        <tr>
                            <th>Paciente/Cliente:</th>
                            <td>{{ $appointment->contact->name ?? 'N/A' }}</td>
                        </tr>
                        @if($appointment->contact && $appointment->contact->mobile)
                        <tr>
                            <th>Teléfono:</th>
                            <td><i class="fa fa-phone"></i> {{ $appointment->contact->mobile }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Fecha y Hora:</th>
                            <td>{{ $appointment->appointment_datetime->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Duración:</th>
                            <td>{{ $appointment->duration_minutes }} minutos</td>
                        </tr>
                        <tr>
                            <th>Ubicación:</th>
                            <td>{{ $appointment->location->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Asignado a:</th>
                            <td>{{ $appointment->assignedTo ? $appointment->assignedTo->first_name . ' ' . $appointment->assignedTo->last_name : 'No asignado' }}</td>
                        </tr>
                        @if($appointment->service_description)
                        <tr>
                            <th>Tipo de Servicio:</th>
                            <td>{{ $appointment->service_description }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Monto Estimado:</th>
                            <td><span class="display_currency" data-currency_symbol="true">{{ $appointment->estimated_amount }}</span></td>
                        </tr>
                        @if($appointment->notes)
                        <tr>
                            <th>Notas:</th>
                            <td>{{ $appointment->notes }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Cambiar Estado</h3>
                </div>
                <div class="box-body">
                    <form action="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'update'], [$appointment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label>Estado Actual:</label>
                            <p>{!! $appointment->status_badge !!}</p>
                        </div>
                        
                        <div class="form-group">
                            <label>Nuevo Estado:</label>
                            <select name="status" class="form-control" required>
                                <option value="reserved" {{ $appointment->status == 'reserved' ? 'selected' : '' }}>Reservada</option>
                                <option value="waiting" {{ $appointment->status == 'waiting' ? 'selected' : '' }}>En Espera</option>
                                <option value="in_service" {{ $appointment->status == 'in_service' ? 'selected' : '' }}>Atendiendo</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Atendido</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-save"></i> Actualizar Estado
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="box">
                <div class="box-body">
                    <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index']) }}" class="btn btn-default btn-block">
                        <i class="fa fa-arrow-left"></i> Volver a la Lista
                    </a>
                    
                    @if($appointment->status == 'reserved')
                        <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'edit'], [$appointment->id]) }}" class="btn btn-warning btn-block">
                            <i class="fa fa-edit"></i> Editar Cita
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
