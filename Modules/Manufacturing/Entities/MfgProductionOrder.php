<?php

namespace Modules\Manufacturing\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Business;
use App\BusinessLocation;
use App\User;

class MfgProductionOrder extends Model
{
    protected $fillable = [
        'business_id',
        'location_id',
        'recipe_id',
        'ref_no',
        'quantity_to_produce',
        'quantity_produced',
        'status',
        'production_date',
        'completion_date',
        'total_cost',
        'transaction_id',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'quantity_to_produce' => 'decimal:4',
        'quantity_produced' => 'decimal:4',
        'total_cost' => 'decimal:4',
        'production_date' => 'datetime',
        'completion_date' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }

    public function recipe()
    {
        return $this->belongsTo(MfgRecipe::class, 'recipe_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generar número de referencia único
     */
    public static function generateRefNo($business_id)
    {
        $prefix = config('manufacturing.production_order_prefix', 'PRD');
        $year = date('Y');
        $month = date('m');
        
        $last = self::where('business_id', $business_id)
            ->where('ref_no', 'like', $prefix . $year . $month . '%')
            ->orderBy('id', 'desc')
            ->first();
        
        if ($last) {
            $lastNumber = intval(substr($last->ref_no, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Calcular el costo total de la orden
     */
    public function calculateTotalCost()
    {
        if ($this->recipe) {
            $this->total_cost = $this->recipe->total_cost * $this->quantity_to_produce;
            $this->save();
        }
        return $this->total_cost;
    }

    /**
     * Marcar como completada
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->quantity_produced = $this->quantity_to_produce;
        $this->completion_date = now();
        $this->save();
    }

    /**
     * Obtener badge de estado
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pendiente</span>',
            'in_progress' => '<span class="badge badge-info">En Proceso</span>',
            'completed' => '<span class="badge badge-success">Completada</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelada</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Desconocido</span>';
    }
}
