@extends('layouts.app')
@section('title', 'Detalle de Proceso')

@section('content')
<section class="content-header">
    <h1>Proceso: {{ $recipe->name }}</h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="40%">Nombre:</th>
                        <td>{{ $recipe->name }}</td>
                    </tr>
                    <tr>
                        <th>Producto Final:</th>
                        <td>{{ $recipe->product->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad Producida:</th>
                        <td>{{ $recipe->quantity_produced }}</td>
                    </tr>
                    <tr>
                        <th>Tiempo de Preparación:</th>
                        <td>{{ $recipe->preparation_time_minutes ? $recipe->preparation_time_minutes . ' minutos' : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="40%">Costo Total:</th>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $recipe->total_cost }}</span></td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            @if($recipe->is_active)
                                <span class="label label-success">Activa</span>
                            @else
                                <span class="label label-default">Inactiva</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Creado por:</th>
                        <td>{{ $recipe->creator->user_full_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Creación:</th>
                        <td>{{ $recipe->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($recipe->description)
        <div class="row">
            <div class="col-md-12">
                <h4>Descripción:</h4>
                <p>{{ $recipe->description }}</p>
            </div>
        </div>
        @endif

        @if($recipe->instructions)
        <div class="row">
            <div class="col-md-12">
                <h4>Instrucciones de Preparación:</h4>
                <p style="white-space: pre-wrap;">{{ $recipe->instructions }}</p>
            </div>
        </div>
        @endif

        <hr>

        <h4>Ingredientes ({{ $recipe->ingredients->count() }})</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ingrediente</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Costo Unitario</th>
                        <th>Costo Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recipe->ingredients as $index => $ingredient)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ingredient->product->name ?? 'N/A' }}</td>
                        <td>{{ $ingredient->quantity }}</td>
                        <td>{{ $ingredient->unit->actual_name ?? 'N/A' }}</td>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $ingredient->cost_per_unit }}</span></td>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $ingredient->total_cost }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Costo Total del Proceso:</th>
                        <th><span class="display_currency" data-currency_symbol="true">{{ $recipe->total_cost }}</span></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                @can('manufacturing.edit')
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'edit'], [$recipe->id]) }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Editar
                </a>
                @endcan
                
                <a href="{{ action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'index']) }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    @endcomponent
</section>
@endsection
