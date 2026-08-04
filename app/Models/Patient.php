<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = [
	'patientcode', 'hospital_id', 'firstname', 'middlename', 'lastname', 'dob', 'gender', 'bloodgroup', 'genotype', 'marital', 'religion', 'occupation', 'phonemain', 'phonealt', 'email', 'address', 'city', 'state', 'country', 'postalcode', 'nokname', 'relationship', 'nokphone', 'nokaddress', 'hereabout', 'notes', 'status'];
	
	protected static function booted()
    {
        static::creating(function ($patient) {

		   if (empty($patient->hospital_id) && Auth::check()) {
				$patient->hospital_id = Auth::user()->hospital_id;
			}

			$hospital = Hospital::find($patient->hospital_id);

			$prefix = $hospital?->code ?? 'HSP';

			$year = now()->year;

			$lastPatient = self::where('hospital_id', $patient->hospital_id)
				->whereYear('created_at', $year)
				->latest('id')
				->first();

			$next = $lastPatient
				? ((int) substr($lastPatient->patientcode, -6)) + 1
				: 1;

			$patient->patientcode = sprintf(
				'%s-%s-%01d',
				$prefix,
				$year,
				$next
			);
		});
    }
	
	public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
	
	public function encounter(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }
}
