@extends('layouts.app')
@section('title', 'Nueva Cita')

@section('content')
<section class="content-header">
    <h1>Nueva Cita</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'store']), 'method' => 'post']) !!}
    
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('contact_id', 'Paciente/Cliente *') !!}
                    {!! Form::select('contact_id', $contacts, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione un paciente/cliente']) !!}
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('assigned_to', 'Asignado a (Doctor/Estilista)') !!}
                    {!! Form::select('assigned_to', $staff, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccione personal']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('appointment_datetime', 'Fecha y Hora de la Cita *') !!}
                    {!! Form::text('appointment_datetime', null, ['class' => 'form-control datetimepicker', 'required']) !!}
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('duration_minutes', 'Duración (minutos)') !!}
                    {!! Form::number('duration_minutes', 30, ['class' => 'form-control', 'min' => '5', 'step' => '5']) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('location_id', 'Ubicación *') !!}
                    {!! Form::select('location_id', $locations, null, ['class' => 'form-control select2', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('service_description', 'Descripción del Servicio') !!}
                    {!! Form::textarea('service_description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('notes', 'Notas Adicionales') !!}
                    {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('estimated_amount', 'Monto Estimado') !!}
                    {!! Form::number('estimated_amount', 0, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Crear Cita</button>
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
