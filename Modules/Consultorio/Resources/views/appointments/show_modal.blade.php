<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Cita: {{ $appointment->appointment_number }}</h4>
</div>

{!! Form::open(['url' => action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'update'], [$appointment->id]), 'method' => 'put', 'id' => 'edit_appointment_form']) !!}

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <strong>Paciente/Cliente:</strong><br>
            {{ $appointment->contact->name ?? 'N/A' }}<br>
            @if($appointment->contact && $appointment->contact->mobile)
                <i class="fa fa-phone"></i> {{ $appointment->contact->mobile }}<br>
            @endif
        </div>
        <div class="col-md-6">
            <strong>Fecha y Hora:</strong><br>
            {{ $appointment_datetime }}<br>
            <strong>Duración:</strong> {{ $appointment->duration_minutes }} minutos
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <strong>Ubicación:</strong><br>
            {{ $appointment->location->name ?? 'N/A' }}
        </div>
        <div class="col-md-6">
            <strong>Asignado a:</strong><br>
            {{ $appointment->assignedTo ? $appointment->assignedTo->first_name . ' ' . $appointment->assignedTo->last_name : 'No asignado' }}
        </div>
    </div>

    @if($appointment->service_description)
    <hr>
    <div class="row">
        <div class="col-md-12">
            <strong>Tipo de Servicio:</strong><br>
            {{ $appointment->service_description }}
        </div>
    </div>
    @endif

    @if($appointment->notes)
    <hr>
    <div class="row">
        <div class="col-md-12">
            <strong>Notas:</strong><br>
            {{ $appointment->notes }}
        </div>
    </div>
    @endif

    <hr>

    <div class="row">
        <div class="col-md-6">
            <strong>Monto Estimado:</strong><br>
            <span class="display_currency" data-currency_symbol="true">{{ $appointment->estimated_amount }}</span>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('status', 'Estado:*') !!}
                {!! Form::select('status', $appointment_statuses, $appointment->status, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
    </div>

    @if($appointment->transaction_id)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <i class="fa fa-check"></i> Esta cita ya fue facturada
            </div>
        </div>
    </div>
    @endif
</div>

<div class="modal-footer">
    @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
        <button type="button" class="btn btn-danger pull-left" id="delete_appointment" data-href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'destroy'], [$appointment->id]) }}">
            <i class="fa fa-trash"></i> Eliminar
        </button>
    @endif
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
        <button type="submit" class="btn btn-primary">Actualizar</button>
    @endif
</div>

{!! Form::close() !!}
