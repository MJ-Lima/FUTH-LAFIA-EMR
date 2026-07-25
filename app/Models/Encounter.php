<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $fillable = [
        'hospital_id',
        'patient_id',
        'clinic_id',
        'user_id',
        'encounter_number',
        'visit_type',
        'encounter_date',
        'encounter_time',
        'status',
        'chief_complaint',
        'referred_by',
        'appointment_id',
        'created_by',
        'notes',
    ];
	
	 public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
	
	public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
	
}
