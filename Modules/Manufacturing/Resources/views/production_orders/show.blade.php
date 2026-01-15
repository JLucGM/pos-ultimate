@extends('layouts.app')
@section('title', 'Detalle de Orden de Producción')

@section('content')
<section class="content-header">
    <h1>Orden de Producción: {{ $order->ref_no }}</h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="40%">Referencia:</th>
                        <td>{{ $order->ref_no }}</td>
                    </tr>
                    <tr>
                        <th>Proceso:</th>
                        <td>{{ $order->recipe->name }}</td>
                    </tr>
                    <tr>
                        <th>Producto Final:</th>
                        <td>{{ $order->recipe->product->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad a Producir:</th>
                        <td>{{ $order->quantity_to_produce }}</td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>{!! $order->status_badge !!}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="40%">Ubicación:</th>
                        <td>{{ $order->location->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Producción:</th>
                        <td>{{ $order->production_date->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Costo Total:</th>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $order->total_cost }}</span></td>
                    </tr>
                    <tr>
                        <th>Creado por:</th>
                        <td>{{ $order->creator->user_full_name ?? 'N/A' }}</td>
                    </tr>
                    @if($order->completed_at)
                    <tr>
                        <th>Completado:</th>
                        <td>{{ $order->completed_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($order->notes)
        <div class="row">
            <div class="col-md-12">
                <h4>Notas:</h4>
                <p>{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        <hr>

        <h4>Ingredientes Necesarios</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Ingrediente</th>
                        <th>Cantidad por Unidad</th>
                        <th>Cantidad Total Necesaria</th>
                        <th>Costo Unitario</th>
                        <th>Costo Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->recipe->ingredients as $ingredient)
                    <tr>
                        <td>{{ $ingredient->product->name ?? 'N/A' }}</td>
                        <td>{{ $ingredient->quantity }} {{ $ingredient->unit->actual_name ?? '' }}</td>
                        <td>{{ $ingredient->quantity * $order->quantity_to_produce }} {{ $ingredient->unit->actual_name ?? '' }}</td>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $ingredient->cost_per_unit }}</span></td>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $ingredient->total_cost * $order->quantity_to_produce }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total:</th>
                        <th><span class="display_currency" data-currency_symbol="true">{{ $order->total_cost }}</span></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if($order->status == 'pending' && auth()->user()->can('manufacturing.create'))
                <button type="button" class="btn btn-success produce-order" data-href="{{ action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'produce'], [$order->id]) }}">
                    <i class="fa fa-cogs"></i> Iniciar Producción
                </button>
                @endif
                
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'index']) }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.produce-order').click(function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        
        swal({
            title: '¿Iniciar Producción?',
            text: 'Se descontarán los ingredientes y se agregará el producto final al inventario',
            icon: 'warning',
            buttons: true,
        }).then((willProduce) => {
            if (willProduce) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            toastr.success(result.msg);
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
