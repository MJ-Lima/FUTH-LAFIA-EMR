<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encounter extends Model
{
    protected $fillable = [
        'hospital_id', 'patient_id', 'clinic_id', 'user_id',
        'encounter_number', 'visit_type',
        'encounter_date', 'encounter_time',
        'status', 'chief_complaint', 'referred_by',
        'appointment_id', 'created_by', 'notes',
    ];

    protected $casts = [
        'encounter_date' => 'date',
        'encounter_time' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($encounter) {
            if (empty($encounter->hospital_id) && Auth::check()) {
                $encounter->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($encounter->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $lastPatient = self::where('hospital_id', $encounter->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $lastPatient ? ((int) substr($lastPatient->encounter_number, -6)) + 1 : 1;
            $encounter->encounter_number = sprintf('%s-ENC-%s-%06d', $prefix, $year, $next);
            if (Auth::check()) {
                if (empty($encounter->user_id)) $encounter->user_id = Auth::id();
                if (empty($encounter->created_by)) $encounter->created_by = Auth::id();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function clinic(): BelongsTo { return $this->belongsTo(Clinic::class); }
    public function provider(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
    public function appointment(): BelongsTo { return $this->belongsTo(Appointment::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }

    public function clinicalNotes(): HasMany { return $this->hasMany(ClinicalNote::class); }
    public function vitals(): HasMany { return $this->hasMany(Vitals::class); }
    public function allergies(): HasMany { return $this->hasMany(Allergy::class); }
    public function diagnoses(): HasMany { return $this->hasMany(Diagnosis::class); }
    public function labOrders(): HasMany { return $this->hasMany(LabOrder::class); }
    public function radiologyOrders(): HasMany { return $this->hasMany(RadiologyOrder::class); }
    public function prescriptions(): HasMany { return $this->hasMany(Prescription::class); }
}
