<?php

namespace Modules\Consultorio\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Contact;
use App\User;
use App\BusinessLocation;
use App\Transaction;

class Appointment extends Model
{
    protected $fillable = [
        'business_id',
        'location_id',
        'contact_id',
        'assigned_to',
        'appointment_number',
        'appointment_datetime',
        'duration_minutes',
        'status',
        'notes',
        'service_description',
        'estimated_amount',
        'transaction_id',
        'created_by'
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime',
        'estimated_amount' => 'decimal:2',
    ];

    // Relaciones
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Métodos útiles
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'reserved' => '<span class="label label-info">Reservada</span>',
            'waiting' => '<span class="label label-warning">En Espera</span>',
            'attending' => '<span class="label label-primary">Atendiendo</span>',
            'completed' => '<span class="label label-success">Atendido</span>',
            'cancelled' => '<span class="label label-danger">Cancelada</span>',
        ];

        return $badges[$this->status] ?? '<span class="label label-default">Desconocido</span>';
    }

    public function getStatusNameAttribute()
    {
        $names = [
            'reserved' => 'Reservada',
            'waiting' => 'En Espera',
            'attending' => 'Atendiendo',
            'completed' => 'Atendido',
            'cancelled' => 'Cancelada',
        ];

        return $names[$this->status] ?? 'Desconocido';
    }

    public static function generateAppointmentNumber($business_id)
    {
        $prefix = 'APT';
        $year = date('Y');
        $month = date('m');
        
        $last = self::where('business_id', $business_id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $last ? (int)substr($last->appointment_number, -4) + 1 : 1;
        
        return $prefix . $year . $month . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function canChangeStatus($new_status)
    {
        $allowed_transitions = [
            'reserved' => ['waiting', 'cancelled'],
            'waiting' => ['attending', 'cancelled'],
            'attending' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];

        return in_array($new_status, $allowed_transitions[$this->status] ?? []);
    }

    public function changeStatus($new_status)
    {
        if ($this->canChangeStatus($new_status)) {
            $this->status = $new_status;
            $this->save();
            return true;
        }
        return false;
    }
}
