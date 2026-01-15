<?php

namespace Modules\Manufacturing\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\User;

class MfgRecipe extends Model
{
    protected $fillable = [
        'business_id',
        'product_id',
        'name',
        'description',
        'quantity_produced',
        'total_cost',
        'preparation_time_minutes',
        'instructions',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'quantity_produced' => 'decimal:4',
        'total_cost' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ingredients()
    {
        return $this->hasMany(MfgRecipeIngredient::class, 'recipe_id')->orderBy('sort_order');
    }

    public function productionOrders()
    {
        return $this->hasMany(MfgProductionOrder::class, 'recipe_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Calcular el costo total de la receta
     */
    public function calculateTotalCost()
    {
        $total = $this->ingredients->sum('total_cost');
        $this->total_cost = $total;
        $this->save();
        return $total;
    }

    /**
     * Verificar si hay suficiente stock para producir
     */
    public function hasEnoughStock($quantity = 1, $location_id = null)
    {
        foreach ($this->ingredients as $ingredient) {
            $required = $ingredient->quantity * $quantity;
            $available = $this->getIngredientStock($ingredient, $location_id);
            
            if ($available < $required) {
                return false;
            }
        }
        return true;
    }

    /**
     * Obtener stock disponible de un ingrediente
     */
    private function getIngredientStock($ingredient, $location_id)
    {
        $variation_id = $ingredient->variation_id;
        
        if (!$variation_id) {
            return 0;
        }
        
        if ($location_id) {
            $stock = \DB::table('variation_location_details')
                ->where('variation_id', $variation_id)
                ->where('location_id', $location_id)
                ->value('qty_available');
            
            return $stock ?? 0;
        }
        
        $stock = \DB::table('variation_location_details')
            ->where('variation_id', $variation_id)
            ->sum('qty_available');
        
        return $stock ?? 0;
    }
}
