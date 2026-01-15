@extends('layouts.app')
@section('title', 'Órdenes de Producción')

@section('content')
<section class="content-header">
    <h1>Órdenes de Producción</h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-sm-12">
                @can('manufacturing.create')
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'create']) }}" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i> Nueva Orden
                </a>
                @endcan
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="production_orders_table">
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Costo Total</th>
                        <th>Fecha Producción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var orders_table = $('#production_orders_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, "index"]) }}',
        columns: [
            { data: 'ref_no', name: 'ref_no' },
            { data: 'recipe.product.name', name: 'recipe.product.name' },
            { data: 'quantity_to_produce', name: 'quantity_to_produce' },
            { data: 'status', name: 'status' },
            { data: 'total_cost', name: 'total_cost' },
            { data: 'production_date', name: 'production_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[5, 'desc']]
    });

    $(document).on('click', '.produce-order', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
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
                    success: function(result) {
                        if (result.success) {
                            toastr.success(result.msg);
                            orders_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete-order', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        swal({
            title: '¿Eliminar orden?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    dataType: 'json',
                    success: function(result) {
                        if (result.success) {
                            toastr.success(result.msg);
                            orders_table.ajax.reload();
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
