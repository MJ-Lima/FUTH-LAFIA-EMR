<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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