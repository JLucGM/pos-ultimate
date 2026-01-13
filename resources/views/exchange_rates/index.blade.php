@extends('layouts.app')
@section('title', 'Tasas de Cambio')

@section('content')
<section class="content-header">
    <h1>Tasas de Cambio
        <small>Gestionar tasas de cambio entre monedas</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Todas las Tasas de Cambio'])
        @can('create_exchange_rate')
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="{{action([\App\Http\Controllers\ExchangeRateController::class, 'create'])}}">
                        <i class="fa fa-plus"></i> Agregar Tasa de Cambio
                    </a>
                </div>
            @endslot
        @endcan
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="exchange_rates_table">
                <thead>
                    <tr>
                        <th>Fecha Efectiva</th>
                        <th>De Moneda</th>
                        <th>A Moneda</th>
                        <th>Tasa</th>
                        <th>Creado Por</th>
                        <th>Notas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent

    <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var exchange_rates_table = $('#exchange_rates_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action([\App\Http\Controllers\ExchangeRateController::class, 'getData']) }}',
        columns: [
            { data: 'effective_date', name: 'effective_date' },
            { data: 'from_currency', name: 'fromCurrency.currency', searchable: false },
            { data: 'to_currency', name: 'toCurrency.currency', searchable: false },
            { data: 'rate', name: 'rate' },
            { data: 'created_by', name: 'creator.username', searchable: false },
            { data: 'notes', name: 'notes' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });
});
</script>
@endsection
