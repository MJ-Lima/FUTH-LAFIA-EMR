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
	
	protected static function booted()
    {
        static::creating(function ($encounter) {

		   if (empty($encounter->hospital_id) && Auth::check()) {
				$encounter->hospital_id = Auth::user()->hospital_id;
			}

			$hospital = Hospital::find($encounter->hospital_id);

			$prefix = $hospital?->code ?? 'HSP';

			$year = now()->year;

			$lastPatient = self::where('hospital_id', $encounter->hospital_id)
				->whereYear('created_at', $year)
				->latest('id')
				->first();

			$next = $lastPatient
				? ((int) substr($lastPatient->patientcode, -6)) + 1
				: 1;

			$encounter->encounter_number = sprintf(
				'%s-%s-%06d',
				$prefix,
				$year,
				$next
			);
			$encounter->user_id = Auth::user()->id;
			$encounter->created_by = Auth::user()->id;
		});
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
