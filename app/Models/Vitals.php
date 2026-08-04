<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vitals extends Model
{
    protected $table = 'vitals';

    protected $fillable = [
        'hospital_id', 'patient_id', 'encounter_id', 'recorded_by', 'recorded_at',
        'height_cm', 'weight_kg', 'bmi', 'muac_cm',
        'systolic_bp', 'diastolic_bp', 'heart_rate', 'bp_position',
        'respiratory_rate', 'spo2',
        'temperature_c', 'temperature_route',
        'pain_score', 'glasgow_coma_score',
        'blood_glucose_mmol_l', 'glucose_fasting',
        'fetal_heart_rate', 'fundal_height_cm',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'height_cm' => 'decimal:2',
        'weight_kg' => 'decimal:2',
        'bmi' => 'decimal:2',
        'muac_cm' => 'decimal:2',
        'temperature_c' => 'decimal:2',
        'blood_glucose_mmol_l' => 'decimal:2',
        'fundal_height_cm' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $v) {
            if ($v->height_cm && $v->weight_kg && $v->height_cm > 0) {
                $h = (float) $v->height_cm / 100;
                $v->bmi = round((float) $v->weight_kg / ($h * $h), 2);
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function encounter(): BelongsTo { return $this->belongsTo(Encounter::class); }
    public function recorder(): BelongsTo { return $this->belongsTo(User::class, 'recorded_by'); }

    public function getBpAttribute(): string
    {
        if ($this->systolic_bp && $this->diastolic_bp) {
            return "{$this->systolic_bp}/{$this->diastolic_bp}";
        }
        return '—';
    }
}
