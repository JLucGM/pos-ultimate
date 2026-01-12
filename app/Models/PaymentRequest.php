<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Superadmin\Entities\Package;

class PaymentRequest extends Model
{
    protected $fillable = [
        'package_id',
        'business_name',
        'contact_name',
        'email',
        'phone',
        'payment_method',
        'reference_number',
        'payment_proof',
        'amount',
        'status',
        'admin_notes',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
