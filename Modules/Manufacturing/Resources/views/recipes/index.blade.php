@extends('layouts.app')
@section('title', 'Recetas de Producción')

@section('content')
<section class="content-header">
    <h1>Recetas de Producción
        <small>Gestiona las recetas de productos</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-sm-12">
                @can('manufacturing.create')
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'create']) }}" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i> Nueva Receta
                </a>
                @endcan
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="recipes_table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Producto Final</th>
                        <th>Cantidad Producida</th>
                        <th>Ingredientes</th>
                        <th>Costo Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        var recipes_table = $('#recipes_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, "index"]) }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'product.name', name: 'product.name' },
                { data: 'quantity_produced', name: 'quantity_produced' },
                { data: 'ingredients_count', name: 'ingredients_count', searchable: false },
                { data: 'total_cost', name: 'total_cost' },
                { data: 'is_active', name: 'is_active' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.delete-recipe', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            
            swal({
                title: '¿Estás seguro?',
                text: 'Esta receta será eliminada',
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
                                recipes_table.ajax.reload();
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
