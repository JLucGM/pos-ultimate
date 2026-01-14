@extends('layouts.app')
@section('title', 'Editar Tasa de Cambio')

@section('content')
<section class="content-header">
    <h1>Editar Tasa de Cambio</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\App\Http\Controllers\ExchangeRateController::class, 'update'], [$rate->id]), 'method' => 'PUT', 'id' => 'exchange_rate_form']) !!}
    
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('from_currency_id', 'De Moneda *') !!}
                        {!! Form::select('from_currency_id', $currencies, $rate->from_currency_id, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione moneda origen']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('to_currency_id', 'A Moneda *') !!}
                        {!! Form::select('to_currency_id', $currencies, $rate->to_currency_id, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione moneda destino']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('rate', 'Tasa de Cambio *') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-exchange-alt"></i>
                            </span>
                            {!! Form::text('rate', $rate->rate, ['class' => 'form-control input_number', 'required', 'placeholder' => '0.000000']) !!}
                        </div>
                        <small class="text-muted">1 [Moneda Origen] = ? [Moneda Destino]</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('effective_date', 'Fecha Efectiva *') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            {!! Form::text('effective_date', @format_date($rate->effective_date), ['class' => 'form-control', 'required', 'readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('notes', 'Notas') !!}
                        {!! Form::textarea('notes', $rate->notes, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Notas adicionales sobre esta tasa de cambio']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Actualizar
            </button>
            <a href="{{ action([\App\Http\Controllers\ExchangeRateController::class, 'index']) }}" class="btn btn-default">
                <i class="fa fa-times"></i> Cancelar
            </a>
        </div>
    </div>

    {!! Form::close() !!}
</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        // Inicializar select2
        $('.select2').select2();

        // Inicializar datepicker
        $('#effective_date').datepicker({
            autoclose: true,
            format: datepicker_date_format,
            todayHighlight: true
        });

        // Validación del formulario
        $('#exchange_rate_form').validate({
            rules: {
                from_currency_id: {
                    required: true
                },
                to_currency_id: {
                    required: true
                },
                rate: {
                    required: true,
                    number: true,
                    min: 0.000001
                },
                effective_date: {
                    required: true
                }
            },
            messages: {
                from_currency_id: {
                    required: 'Por favor seleccione la moneda origen'
                },
                to_currency_id: {
                    required: 'Por favor seleccione la moneda destino'
                },
                rate: {
                    required: 'Por favor ingrese la tasa de cambio',
                    number: 'Por favor ingrese un número válido',
                    min: 'La tasa debe ser mayor a 0'
                },
                effective_date: {
                    required: 'Por favor seleccione la fecha efectiva'
                }
            }
        });

        // Validar que las monedas sean diferentes
        $('#to_currency_id').on('change', function() {
            var from_currency = $('#from_currency_id').val();
            var to_currency = $(this).val();
            
            if (from_currency && to_currency && from_currency === to_currency) {
                toastr.error('Las monedas de origen y destino deben ser diferentes');
                $(this).val('').trigger('change');
            }
        });

        $('#from_currency_id').on('change', function() {
            var from_currency = $(this).val();
            var to_currency = $('#to_currency_id').val();
            
            if (from_currency && to_currency && from_currency === to_currency) {
                toastr.error('Las monedas de origen y destino deben ser diferentes');
                $(this).val('').trigger('change');
            }
        });
    });
</script>
@endsection
