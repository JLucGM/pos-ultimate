<?php

namespace Modules\Manufacturing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Manufacturing\Entities\MfgRecipe;
use Modules\Manufacturing\Entities\MfgRecipeIngredient;
use App\Product;
use App\Unit;
use Yajra\DataTables\Facades\DataTables;
use DB;

class RecipeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('manufacturing.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $recipes = MfgRecipe::where('business_id', $business_id)
                ->with(['product', 'ingredients'])
                ->select('mfg_recipes.*');

            return DataTables::of($recipes)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">';
                    $html .= '<button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">' . __('messages.actions') . '<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
                    $html .= '<ul class="dropdown-menu dropdown-menu-right" role="menu">';
                    
                    if (auth()->user()->can('manufacturing.view')) {
                        $html .= '<li><a href="' . action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'show'], [$row->id]) . '"><i class="fa fa-eye"></i> ' . __('messages.view') . '</a></li>';
                    }
                    
                    if (auth()->user()->can('manufacturing.edit')) {
                        $html .= '<li><a href="' . action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'edit'], [$row->id]) . '"><i class="glyphicon glyphicon-edit"></i> ' . __('messages.edit') . '</a></li>';
                    }
                    
                    if (auth()->user()->can('manufacturing.delete')) {
                        $html .= '<li><a href="' . action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'destroy'], [$row->id]) . '" class="delete-recipe"><i class="glyphicon glyphicon-trash"></i> ' . __('messages.delete') . '</a></li>';
                    }
                    
                    $html .= '</ul></div>';
                    return $html;
                })
                ->editColumn('product.name', function ($row) {
                    return $row->product ? $row->product->name : '-';
                })
                ->editColumn('total_cost', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' . $row->total_cost . '</span>';
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? '<span class="label label-success">Activa</span>' : '<span class="label label-default">Inactiva</span>';
                })
                ->addColumn('ingredients_count', function ($row) {
                    return $row->ingredients->count();
                })
                ->rawColumns(['action', 'total_cost', 'is_active'])
                ->make(true);
        }

        return view('manufacturing::recipes.index');
    }

    public function create()
    {
        if (!auth()->user()->can('manufacturing.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        // Obtener productos de forma correcta
        $products = Product::where('business_id', $business_id)
            ->where('type', '!=', 'modifier')
            ->pluck('name', 'id');
        
        $units = Unit::where('business_id', $business_id)
            ->pluck('actual_name', 'id');

        return view('manufacturing::recipes.create', compact('products', 'units'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('manufacturing.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');
            
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:255',
                'quantity_produced' => 'required|numeric|min:0.0001',
            ]);

            DB::beginTransaction();

            $recipe = MfgRecipe::create([
                'business_id' => $business_id,
                'product_id' => $request->product_id,
                'name' => $request->name,
                'description' => $request->description,
                'quantity_produced' => $request->quantity_produced,
                'preparation_time_minutes' => $request->preparation_time_minutes,
                'instructions' => $request->instructions,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'created_by' => auth()->user()->id,
            ]);

            // Agregar ingredientes
            if ($request->has('ingredients')) {
                foreach ($request->ingredients as $index => $ingredient) {
                    if (!empty($ingredient['product_id']) && !empty($ingredient['quantity'])) {
                        // Obtener la primera variación del producto
                        $product = Product::find($ingredient['product_id']);
                        $variation_id = null;
                        
                        if ($product) {
                            $product_variation = \DB::table('product_variations')
                                ->where('product_id', $product->id)
                                ->first();
                            
                            if ($product_variation) {
                                $variation = \DB::table('variations')
                                    ->where('product_variation_id', $product_variation->id)
                                    ->first();
                                
                                if ($variation) {
                                    $variation_id = $variation->id;
                                }
                            }
                        }
                        
                        MfgRecipeIngredient::create([
                            'recipe_id' => $recipe->id,
                            'ingredient_product_id' => $ingredient['product_id'],
                            'variation_id' => $variation_id,
                            'quantity' => $ingredient['quantity'],
                            'unit_id' => $ingredient['unit_id'] ?? null,
                            'cost_per_unit' => $ingredient['cost_per_unit'] ?? 0,
                            'total_cost' => $ingredient['quantity'] * ($ingredient['cost_per_unit'] ?? 0),
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            // Calcular costo total
            $recipe->calculateTotalCost();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Receta creada exitosamente'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al crear la receta: ' . $e->getMessage()
            ];
        }

        return redirect()->action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'index'])->with('status', $output);
    }

    public function show($id)
    {
        if (!auth()->user()->can('manufacturing.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $recipe = MfgRecipe::where('business_id', $business_id)
            ->with(['product', 'ingredients.product', 'ingredients.variation', 'ingredients.unit'])
            ->findOrFail($id);

        return view('manufacturing::recipes.show', compact('recipe'));
    }

    public function edit($id)
    {
        if (!auth()->user()->can('manufacturing.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $recipe = MfgRecipe::where('business_id', $business_id)
            ->with(['ingredients'])
            ->findOrFail($id);
        
        $products = Product::where('business_id', $business_id)
            ->where('type', '!=', 'modifier')
            ->pluck('name', 'id');
        
        $units = Unit::where('business_id', $business_id)
            ->pluck('actual_name', 'id');

        return view('manufacturing::recipes.edit', compact('recipe', 'products', 'units'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('manufacturing.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');
            
            $recipe = MfgRecipe::where('business_id', $business_id)->findOrFail($id);

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:255',
                'quantity_produced' => 'required|numeric|min:0.0001',
            ]);

            DB::beginTransaction();

            $recipe->update([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'description' => $request->description,
                'quantity_produced' => $request->quantity_produced,
                'preparation_time_minutes' => $request->preparation_time_minutes,
                'instructions' => $request->instructions,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            // Eliminar ingredientes existentes
            $recipe->ingredients()->delete();

            // Agregar nuevos ingredientes
            if ($request->has('ingredients')) {
                foreach ($request->ingredients as $index => $ingredient) {
                    if (!empty($ingredient['product_id']) && !empty($ingredient['quantity'])) {
                        // Obtener la primera variación del producto
                        $product = Product::find($ingredient['product_id']);
                        $variation_id = null;
                        
                        if ($product) {
                            $product_variation = \DB::table('product_variations')
                                ->where('product_id', $product->id)
                                ->first();
                            
                            if ($product_variation) {
                                $variation = \DB::table('variations')
                                    ->where('product_variation_id', $product_variation->id)
                                    ->first();
                                
                                if ($variation) {
                                    $variation_id = $variation->id;
                                }
                            }
                        }
                        
                        MfgRecipeIngredient::create([
                            'recipe_id' => $recipe->id,
                            'ingredient_product_id' => $ingredient['product_id'],
                            'variation_id' => $variation_id,
                            'quantity' => $ingredient['quantity'],
                            'unit_id' => $ingredient['unit_id'] ?? null,
                            'cost_per_unit' => $ingredient['cost_per_unit'] ?? 0,
                            'total_cost' => $ingredient['quantity'] * ($ingredient['cost_per_unit'] ?? 0),
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            // Recalcular costo total
            $recipe->calculateTotalCost();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Receta actualizada exitosamente'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al actualizar la receta: ' . $e->getMessage()
            ];
        }

        return redirect()->action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'index'])->with('status', $output);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('manufacturing.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            
            $recipe = MfgRecipe::where('business_id', $business_id)->findOrFail($id);
            $recipe->delete();

            $output = [
                'success' => true,
                'msg' => 'Receta eliminada exitosamente'
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al eliminar la receta'
            ];
        }

        return $output;
    }
}
