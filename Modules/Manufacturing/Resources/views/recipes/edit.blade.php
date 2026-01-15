@extends('layouts.app')
@section('title', 'Editar Receta')

@section('content')
<section class="content-header">
    <h1>Editar Receta de Manufactura</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'update'], [$recipe->id]), 'method' => 'put', 'id' => 'recipe_form']) !!}
    
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('product_id', 'Producto Final *') !!}
                    {!! Form::select('product_id', $products, $recipe->product_id, ['class' => 'form-control select2', 'required', 'placeholder' => 'Seleccione un producto']) !!}
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre de la Receta *') !!}
                    {!! Form::text('name', $recipe->name, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('quantity_produced', 'Cantidad Producida *') !!}
                    {!! Form::number('quantity_produced', $recipe->quantity_produced, ['class' => 'form-control', 'required', 'step' => '0.01', 'min' => '0.01']) !!}
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('preparation_time_minutes', 'Tiempo de Preparación (minutos)') !!}
                    {!! Form::number('preparation_time_minutes', $recipe->preparation_time_minutes, ['class' => 'form-control', 'min' => '0']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('description', 'Descripción') !!}
                    {!! Form::textarea('description', $recipe->description, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('instructions', 'Instrucciones de Preparación') !!}
                    {!! Form::textarea('instructions', $recipe->instructions, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('is_active', 1, $recipe->is_active) !!} Receta Activa
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        
        <h4>Ingredientes</h4>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success btn-sm" id="add_ingredient">
                    <i class="fa fa-plus"></i> Agregar Ingrediente
                </button>
            </div>
        </div>
        <br>
        
        <div class="table-responsive">
            <table class="table table-bordered" id="ingredients_table">
                <thead>
                    <tr>
                        <th width="30%">Producto</th>
                        <th width="15%">Cantidad</th>
                        <th width="15%">Costo Unitario</th>
                        <th width="15%">Costo Total</th>
                        <th width="10%">Acción</th>
                    </tr>
                </thead>
                <tbody id="ingredients_body">
                    @foreach($recipe->ingredients as $index => $ingredient)
                    <tr>
                        <td>
                            <select name="ingredients[{{ $index }}][product_id]" class="form-control select2 ingredient_product" required>
                                <option value="">Seleccione producto</option>
                                @foreach($products as $id => $name)
                                    <option value="{{ $id }}" {{ $ingredient->ingredient_product_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="ingredients[{{ $index }}][quantity]" class="form-control ingredient_quantity" step="0.01" min="0.01" value="{{ $ingredient->quantity }}" required></td>
                        <td><input type="number" name="ingredients[{{ $index }}][cost_per_unit]" class="form-control ingredient_cost" step="0.01" min="0" value="{{ $ingredient->cost_per_unit }}" required></td>
                        <td><span class="ingredient_total">{{ number_format($ingredient->total_cost, 2) }}</span></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove_ingredient"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Costo Total de la Receta:</th>
                        <th><span id="recipe_total_cost">{{ number_format($recipe->total_cost, 2) }}</span></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Actualizar Receta</button>
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'index']) }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    @endcomponent
    
    {!! Form::close() !!}
</section>
@endsection

@section('javascript')
<script>
var ingredient_row = {{ count($recipe->ingredients) }};

$(document).ready(function() {
    $('#add_ingredient').click(function() {
        add_ingredient_row();
    });

    $(document).on('click', '.remove_ingredient', function() {
        $(this).closest('tr').remove();
        calculate_recipe_total();
    });

    $(document).on('change', '.ingredient_quantity, .ingredient_cost', function() {
        var row = $(this).closest('tr');
        calculate_ingredient_total(row);
        calculate_recipe_total();
    });
    
    // Calcular total inicial
    calculate_recipe_total();
});

function add_ingredient_row() {
    var html = '<tr>';
    html += '<td>';
    html += '<select name="ingredients[' + ingredient_row + '][product_id]" class="form-control select2 ingredient_product" required>';
    html += '<option value="">Seleccione producto</option>';
    @foreach($products as $id => $name)
        html += '<option value="{{ $id }}">{{ $name }}</option>';
    @endforeach
    html += '</select>';
    html += '</td>';
    html += '<td><input type="number" name="ingredients[' + ingredient_row + '][quantity]" class="form-control ingredient_quantity" step="0.01" min="0.01" required></td>';
    html += '<td><input type="number" name="ingredients[' + ingredient_row + '][cost_per_unit]" class="form-control ingredient_cost" step="0.01" min="0" required></td>';
    html += '<td><span class="ingredient_total">0.00</span></td>';
    html += '<td><button type="button" class="btn btn-danger btn-sm remove_ingredient"><i class="fa fa-trash"></i></button></td>';
    html += '</tr>';
    
    $('#ingredients_body').append(html);
    $('#ingredients_body tr:last .select2').select2();
    ingredient_row++;
}

function calculate_ingredient_total(row) {
    var quantity = parseFloat(row.find('.ingredient_quantity').val()) || 0;
    var cost = parseFloat(row.find('.ingredient_cost').val()) || 0;
    var total = quantity * cost;
    row.find('.ingredient_total').text(total.toFixed(2));
}

function calculate_recipe_total() {
    var total = 0;
    $('#ingredients_body tr').each(function() {
        var ingredient_total = parseFloat($(this).find('.ingredient_total').text()) || 0;
        total += ingredient_total;
    });
    $('#recipe_total_cost').text(total.toFixed(2));
}
</script>
@endsection
