<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Patient extends Model
{
    protected $fillable = [
        'patientcode', 'hospital_id',
        'firstname', 'middlename', 'lastname',
        'dob', 'gender', 'bloodgroup', 'genotype', 'marital',
        'religion', 'occupation',
        'phonemain', 'phonealt', 'email',
        'address', 'city', 'state', 'country', 'postalcode',
        'nokname', 'relationship', 'nokphone', 'nokaddress',
        'hereabout', 'notes', 'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'status' => 'boolean',
    ];

    protected static function booted(): void
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
                ->latest('id')->first();
            $next = $lastPatient ? ((int) substr($lastPatient->patientcode, -6)) + 1 : 1;
            $patient->patientcode = sprintf('%s-%s-%06d', $prefix, $year, $next);
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }

    public function encounters(): HasMany { return $this->hasMany(Encounter::class); }
    public function appointments(): HasMany { return $this->hasMany(Appointment::class); }
    public function clinicalNotes(): HasMany { return $this->hasMany(ClinicalNote::class); }
    public function vitals(): HasMany { return $this->hasMany(Vitals::class); }
    public function allergies(): HasMany { return $this->hasMany(Allergy::class); }
    public function diagnoses(): HasMany { return $this->hasMany(Diagnosis::class); }
    public function labOrders(): HasMany { return $this->hasMany(LabOrder::class); }
    public function radiologyOrders(): HasMany { return $this->hasMany(RadiologyOrder::class); }
    public function prescriptions(): HasMany { return $this->hasMany(Prescription::class); }
    public function dispensingLogs(): HasMany { return $this->hasMany(DispensingLog::class); }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->firstname} {$this->middlename} {$this->lastname}");
    }

    public function getAgeAttribute(): ?string
    {
        if (! $this->dob) {
            return null;
        }
        return $this->dob->age . ' yrs';
    }
}
