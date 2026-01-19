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
            'in_service' => '<span class="label label-primary">Atendiendo</span>',
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
            'in_service' => 'Atendiendo',
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
        $day = date('d');
        
        // Buscar el último número del día actual con bloqueo
        $last = self::where('business_id', $business_id)
            ->where('appointment_number', 'like', $prefix . $year . $month . $day . '%')
            ->orderBy('id', 'desc')
            ->lockForUpdate() // Bloqueo para evitar duplicados en concurrencia
            ->first();
        
        if ($last) {
            $lastNumber = intval(substr($last->appointment_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $appointmentNumber = $prefix . $year . $month . $day . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        // Verificar que no exista (doble verificación)
        $attempts = 0;
        while (self::where('appointment_number', $appointmentNumber)->exists() && $attempts < 10) {
            $newNumber++;
            $appointmentNumber = $prefix . $year . $month . $day . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $attempts++;
        }
        
        return $appointmentNumber;
    }

    public function canChangeStatus($new_status)
    {
        $allowed_transitions = [
            'reserved' => ['waiting', 'cancelled'],
            'waiting' => ['in_service', 'cancelled'],
            'in_service' => ['completed', 'cancelled'],
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
