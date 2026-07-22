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
}
