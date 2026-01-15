@extends('layouts.app')
@section('title', 'Editar Cita')

@section('content')
<section class="content-header">
    <h1>Editar Cita: {{ $appointment->appointment_number }}</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'update'], [$appointment->id]), 'method' => 'put']) !!}
    
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('contact_id', 'Paciente/Cliente *') !!}
                    {!! Form::select('contact_id', $contacts, $appointment->contact_id, ['class' => 'form-control select2', 'required']) !!}
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('assigned_to', 'Asignado a (Doctor/Estilista)') !!}
                    {!! Form::select('assigned_to', $staff, $appointment->assigned_to, ['class' => 'form-control select2', 'placeholder' => 'Seleccione personal']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('appointment_datetime', 'Fecha y Hora de la Cita *') !!}
                    {!! Form::text('appointment_datetime', $appointment->appointment_datetime->format('Y-m-d H:i:s'), ['class' => 'form-control datetimepicker', 'required']) !!}
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('duration_minutes', 'Duración (minutos)') !!}
                    {!! Form::number('duration_minutes', $appointment->duration_minutes, ['class' => 'form-control', 'min' => '5', 'step' => '5']) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('location_id', 'Ubicación *') !!}
                    {!! Form::select('location_id', $locations, $appointment->location_id, ['class' => 'form-control select2', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('service_description', 'Descripción del Servicio') !!}
                    {!! Form::textarea('service_description', $appointment->service_description, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('notes', 'Notas Adicionales') !!}
                    {!! Form::textarea('notes', $appointment->notes, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('estimated_amount', 'Monto Estimado') !!}
                    {!! Form::number('estimated_amount', $appointment->estimated_amount, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Actualizar Cita</button>
                <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index']) }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    @endcomponent
    
    {!! Form::close() !!}
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        sideBySide: true,
        minDate: moment()
    });
});
</script>
@endsection
