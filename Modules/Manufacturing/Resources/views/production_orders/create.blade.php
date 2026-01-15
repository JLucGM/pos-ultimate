@extends('layouts.app')
@section('title', 'Nueva Orden de Producción')

@section('content')
<section class="content-header">
    <h1>Nueva Orden de Producción</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'store']), 'method' => 'post']) !!}
    
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('recipe_id', 'Proceso *') !!}
                    {!! Form::select('recipe_id', $recipes, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione un proceso', 'id' => 'recipe_id']) !!}
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('location_id', 'Ubicación *') !!}
                    {!! Form::select('location_id', $locations, null, ['class' => 'form-control select2', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('quantity_to_produce', 'Cantidad a Producir *') !!}
                    {!! Form::number('quantity_to_produce', 1, ['class' => 'form-control', 'required', 'step' => '0.01', 'min' => '0.01', 'id' => 'quantity_to_produce']) !!}
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('production_date', 'Fecha de Producción *') !!}
                    {!! Form::text('production_date', date('Y-m-d H:i:s'), ['class' => 'form-control', 'required', 'readonly']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('notes', 'Notas') !!}
                    {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
        </div>

        <div id="recipe_details" style="display:none;">
            <hr>
            <h4>Detalles del Proceso</h4>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingrediente</th>
                                <th>Cantidad por Unidad</th>
                                <th>Cantidad Total Necesaria</th>
                            </tr>
                        </thead>
                        <tbody id="ingredients_preview">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Crear Orden</button>
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'index']) }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    @endcomponent
    
    {!! Form::close() !!}
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#recipe_id').change(function() {
        var recipe_id = $(this).val();
        if (recipe_id) {
            $.ajax({
                url: '/manufacturing/production-orders/recipe/' + recipe_id + '/details',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        displayRecipeDetails(response.recipe);
                    }
                }
            });
        } else {
            $('#recipe_details').hide();
        }
    });

    $('#quantity_to_produce').on('input', function() {
        if ($('#recipe_id').val()) {
            $('#recipe_id').trigger('change');
        }
    });
});

function displayRecipeDetails(recipe) {
    var quantity = parseFloat($('#quantity_to_produce').val()) || 1;
    var html = '';
    
    recipe.ingredients.forEach(function(ingredient) {
        var total_needed = ingredient.quantity * quantity;
        html += '<tr>';
        html += '<td>' + (ingredient.product ? ingredient.product.name : 'N/A') + '</td>';
        html += '<td>' + ingredient.quantity + '</td>';
        html += '<td>' + total_needed.toFixed(2) + '</td>';
        html += '</tr>';
    });
    
    $('#ingredients_preview').html(html);
    $('#recipe_details').show();
}
</script>
@endsection
