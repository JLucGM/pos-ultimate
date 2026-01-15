<?php

namespace Modules\Manufacturing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Manufacturing\Entities\MfgProductionOrder;
use Modules\Manufacturing\Entities\MfgRecipe;
use App\BusinessLocation;
use App\Transaction;
use App\TransactionSellLine;
use App\Product;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Yajra\DataTables\Facades\DataTables;
use DB;

class ProductionOrderController extends Controller
{
    protected $productUtil;
    protected $transactionUtil;

    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
    }

    public function index()
    {
        if (!auth()->user()->can('manufacturing.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $orders = MfgProductionOrder::where('business_id', $business_id)
                ->with(['recipe.product', 'location', 'creator'])
                ->select('mfg_production_orders.*');

            return DataTables::of($orders)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">';
                    $html .= '<button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">' . __('messages.actions') . '</button>';
                    $html .= '<ul class="dropdown-menu dropdown-menu-right" role="menu">';
                    
                    $html .= '<li><a href="' . action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'show'], [$row->id]) . '"><i class="fa fa-eye"></i> Ver</a></li>';
                    
                    if ($row->status == 'pending' && auth()->user()->can('manufacturing.create')) {
                        $html .= '<li><a href="' . action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'produce'], [$row->id]) . '" class="produce-order"><i class="fa fa-cogs"></i> Producir</a></li>';
                    }
                    
                    if ($row->status == 'pending' && auth()->user()->can('manufacturing.delete')) {
                        $html .= '<li><a href="' . action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'destroy'], [$row->id]) . '" class="delete-order"><i class="fa fa-trash"></i> Eliminar</a></li>';
                    }
                    
                    $html .= '</ul></div>';
                    return $html;
                })
                ->editColumn('ref_no', function ($row) {
                    return '<a href="' . action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'show'], [$row->id]) . '">' . $row->ref_no . '</a>';
                })
                ->editColumn('recipe.product.name', function ($row) {
                    return $row->recipe && $row->recipe->product ? $row->recipe->product->name : '-';
                })
                ->editColumn('status', function ($row) {
                    return $row->status_badge;
                })
                ->editColumn('total_cost', function ($row) {
                    return '<span class="display_currency" data-currency_symbol="true">' . $row->total_cost . '</span>';
                })
                ->editColumn('production_date', function ($row) {
                    return $row->production_date->format('d/m/Y H:i');
                })
                ->rawColumns(['action', 'ref_no', 'status', 'total_cost'])
                ->make(true);
        }

        return view('manufacturing::production_orders.index');
    }

    public function create()
    {
        if (!auth()->user()->can('manufacturing.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $recipes = MfgRecipe::where('business_id', $business_id)
            ->where('is_active', 1)
            ->with('product')
            ->get()
            ->pluck('name', 'id');
        
        $locations = BusinessLocation::where('business_id', $business_id)
            ->pluck('name', 'id');

        return view('manufacturing::production_orders.create', compact('recipes', 'locations'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('manufacturing.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');
            
            $request->validate([
                'recipe_id' => 'required|exists:mfg_recipes,id',
                'location_id' => 'required|exists:business_locations,id',
                'quantity_to_produce' => 'required|numeric|min:0.0001',
                'production_date' => 'required|date',
            ]);

            $recipe = MfgRecipe::findOrFail($request->recipe_id);

            // Verificar stock
            if (!$recipe->hasEnoughStock($request->quantity_to_produce, $request->location_id)) {
                return back()->with('status', [
                    'success' => false,
                    'msg' => 'No hay suficiente stock de ingredientes para producir esta cantidad'
                ])->withInput();
            }

            DB::beginTransaction();

            $order = MfgProductionOrder::create([
                'business_id' => $business_id,
                'location_id' => $request->location_id,
                'recipe_id' => $request->recipe_id,
                'ref_no' => MfgProductionOrder::generateRefNo($business_id),
                'quantity_to_produce' => $request->quantity_to_produce,
                'status' => 'pending',
                'production_date' => $request->production_date,
                'notes' => $request->notes,
                'created_by' => auth()->user()->id,
            ]);

            $order->calculateTotalCost();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Orden de producción creada exitosamente'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al crear la orden: ' . $e->getMessage()
            ];
        }

        return redirect()->action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'index'])->with('status', $output);
    }

    public function show($id)
    {
        if (!auth()->user()->can('manufacturing.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        
        $order = MfgProductionOrder::where('business_id', $business_id)
            ->with(['recipe.product', 'recipe.ingredients.product', 'location', 'creator'])
            ->findOrFail($id);

        return view('manufacturing::production_orders.show', compact('order'));
    }

    public function produce($id)
    {
        if (!auth()->user()->can('manufacturing.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            
            $order = MfgProductionOrder::where('business_id', $business_id)
                ->with(['recipe.product', 'recipe.ingredients'])
                ->findOrFail($id);

            if ($order->status != 'pending') {
                return response()->json([
                    'success' => false,
                    'msg' => 'Esta orden ya fue procesada'
                ]);
            }

            // Verificar stock nuevamente
            if (!$order->recipe->hasEnoughStock($order->quantity_to_produce, $order->location_id)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'No hay suficiente stock de ingredientes'
                ]);
            }

            DB::beginTransaction();

            // Descontar ingredientes del inventario
            foreach ($order->recipe->ingredients as $ingredient) {
                $quantity_needed = $ingredient->quantity * $order->quantity_to_produce;
                
                if (!$ingredient->variation_id) {
                    throw new \Exception("El ingrediente no tiene variación asignada");
                }
                
                // Descontar directamente del stock
                $affected = \DB::table('variation_location_details')
                    ->where('variation_id', $ingredient->variation_id)
                    ->where('location_id', $order->location_id)
                    ->decrement('qty_available', $quantity_needed);
                
                if ($affected == 0) {
                    throw new \Exception("No se pudo descontar el ingrediente del inventario");
                }
            }

            // Agregar producto final al inventario
            $product = $order->recipe->product;
            $quantity_produced = $order->recipe->quantity_produced * $order->quantity_to_produce;
            
            // Obtener la primera variación del producto final
            $product_variation = \DB::table('product_variations')
                ->where('product_id', $product->id)
                ->first();
            
            if ($product_variation) {
                $variation = \DB::table('variations')
                    ->where('product_variation_id', $product_variation->id)
                    ->first();
                
                if ($variation) {
                    // Verificar si existe el registro en variation_location_details
                    $existing = \DB::table('variation_location_details')
                        ->where('variation_id', $variation->id)
                        ->where('location_id', $order->location_id)
                        ->first();
                    
                    if ($existing) {
                        // Actualizar stock existente
                        \DB::table('variation_location_details')
                            ->where('variation_id', $variation->id)
                            ->where('location_id', $order->location_id)
                            ->increment('qty_available', $quantity_produced);
                    } else {
                        // Crear nuevo registro
                        \DB::table('variation_location_details')->insert([
                            'product_id' => $product->id,
                            'product_variation_id' => $product_variation->id,
                            'variation_id' => $variation->id,
                            'location_id' => $order->location_id,
                            'qty_available' => $quantity_produced,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Marcar orden como completada
            $order->markAsCompleted();

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Producción completada exitosamente'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al producir: ' . $e->getMessage()
            ];
        }

        return response()->json($output);
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('manufacturing.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            
            $order = MfgProductionOrder::where('business_id', $business_id)->findOrFail($id);
            
            if ($order->status != 'pending') {
                return response()->json([
                    'success' => false,
                    'msg' => 'Solo se pueden eliminar órdenes pendientes'
                ]);
            }
            
            $order->delete();

            $output = [
                'success' => true,
                'msg' => 'Orden eliminada exitosamente'
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            
            $output = [
                'success' => false,
                'msg' => 'Error al eliminar la orden'
            ];
        }

        return response()->json($output);
    }

    public function getRecipeDetails($id)
    {
        try {
            $business_id = request()->session()->get('user.business_id');
            
            $recipe = MfgRecipe::where('business_id', $business_id)
                ->with(['product', 'ingredients.product', 'ingredients.unit'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'recipe' => $recipe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Error al obtener detalles de la receta'
            ]);
        }
    }
}
