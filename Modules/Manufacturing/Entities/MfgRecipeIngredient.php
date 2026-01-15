<?php

namespace Modules\Manufacturing\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Variation;
use App\Unit;

class MfgRecipeIngredient extends Model
{
    protected $fillable = [
        'recipe_id',
        'ingredient_product_id',
        'variation_id',
        'quantity',
        'unit_id',
        'cost_per_unit',
        'total_cost',
        'sort_order'
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'cost_per_unit' => 'decimal:4',
        'total_cost' => 'decimal:4',
    ];

    public function recipe()
    {
        return $this->belongsTo(MfgRecipe::class, 'recipe_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ingredient_product_id');
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class, 'variation_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Calcular el costo total del ingrediente
     */
    public function calculateTotalCost()
    {
        $this->total_cost = $this->quantity * $this->cost_per_unit;
        $this->save();
        return $this->total_cost;
    }

    /**
     * Obtener el nombre completo del ingrediente
     */
    public function getFullNameAttribute()
    {
        $name = $this->product ? $this->product->name : 'Producto eliminado';
        
        if ($this->variation) {
            $name .= ' - ' . $this->variation->name;
        }
        
        return $name;
    }
}
