<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Appointment extends Model
{
    protected $fillable = [
        'hospital_id',
        'patient_id',
        'clinic_id',
        'provider_id',
        'appointment_number',
        'appointment_date',
        'appointment_time',
        'estimated_duration',
        'visit_type',
        'priority',
        'reason_for_visit',
        'status',
        'encounter_id',
        'created_by',
        'notes',
        'cancellation_reason',
    ];
	
	protected static function booted(): void
    {
        static::creating(function (Appointment $appointment) {
            $appointment->appointment_number = static::generateNumber();
			$appointment->hospital_id = Auth::user()->hospital_id;
			$appointment->created_by = Auth::user()->id;
        });
    }

    public static function generateNumber(): string
    {
        $year = now()->format('Y');
        $last = static::where('appointment_number', 'like', "APT-{$year}-%")
            ->latest('id')
            ->first();

        $next = $last ? ((int) substr($last->appointment_number, -5)) + 1 : 1;

        return "APT-{$year}-" . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
	
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function encounter()
    {
        return $this->belongsTo(Encounter::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}