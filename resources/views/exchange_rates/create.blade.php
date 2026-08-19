@extends('layouts.app')
@section('title', 'Agregar Tasa de Cambio')

@section('content')
<section class="content-header">
    <h1>Agregar Tasa de Cambio</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\App\Http\Controllers\ExchangeRateController::class, 'store']), 'method' => 'post']) !!}
    
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('from_currency_id', 'De Moneda:' . '*') !!}
                        {!! Form::select('from_currency_id', $currencies, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('to_currency_id', 'A Moneda:' . '*') !!}
                        {!! Form::select('to_currency_id', $currencies, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('rate', 'Tasa de Cambio:' . '*') !!}
                        {!! Form::number('rate', null, ['class' => 'form-control', 'required', 'step' => '0.000001', 'min' => '0', 'placeholder' => 'Ej: 36.50']) !!}
                        <small class="text-muted">1 unidad de la primera moneda = X unidades de la segunda</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('effective_date', 'Fecha Efectiva:' . '*') !!}
                        {!! Form::text('effective_date', @format_date('now'), ['class' => 'form-control', 'required', 'readonly']) !!}
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('notes', 'Notas:') !!}
                        {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Notas opcionales sobre esta tasa']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> <strong>Ejemplo:</strong> Si 1 USD = 36.50 Bs, selecciona USD como "De Moneda", Bs como "A Moneda" y escribe 36.50 en la tasa.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                    <a href="{{action([\App\Http\Controllers\ExchangeRateController::class, 'index'])}}" class="btn btn-default pull-right" style="margin-right: 10px;">
                        <i class="fa fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</section>

@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.select2').select2();
    $('#effective_date').datepicker({
        autoclose: true,
        format: typeof datepicker_date_format !== 'undefined' ? datepicker_date_format : 'dd/mm/yyyy',
        todayHighlight: true
    });
});
</script>
@endsection
