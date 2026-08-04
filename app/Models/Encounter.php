<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
	
	protected static function booted(): void
    {
        static::creating(function (Encounter $encounter) {
            $encounter->encounter_number = static::generateNumber();
			$encounter->created_by = Auth::user()->id;
			$encounter->hospital_id = Auth::user()->hospital_id;
			$encounter->user_id = Auth::user()->id;
        });
    }

    public static function generateNumber(): string
    {
        $year = now()->format('Y');
        $last = static::where('encounter_number', 'like', "ENC-{$year}-%")
            ->latest('id')
            ->first();

        $next = $last ? ((int) substr($last->encounter_number, -5)) + 1 : 1;

        return "ENC-{$year}-" . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

	
	
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
