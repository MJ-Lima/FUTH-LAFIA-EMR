<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Appointment extends Model
{
    protected $fillable = [
        'hospital_id', 'patient_id', 'clinic_id', 'provider_id', 'appointment_number',
        'appointment_date', 'appointment_time', 'estimated_duration', 'visit_type',
        'priority', 'reason_for_visit', 'status', 'encounter_id', 'created_by',
        'notes', 'cancellation_reason', 'queue_number', 'checked_in_at', 'consultation_started_at', 'consultation_ended_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'appointment_time' => 'datetime',
        'checked_in_at' => 'datetime',
        'consultation_started_at' => 'datetime',
        'consultation_ended_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($appt) {
            if (empty($appt->hospital_id) && Auth::check()) {
                $appt->hospital_id = Auth::user()->hospital_id;
            }
            if (empty($appt->created_by) && Auth::check()) {
                $appt->created_by = Auth::id();
            }
            $hospital = Hospital::find($appt->hospital_id);
            $prefix   = $hospital?->code ?? 'FUTH';
            $year     = now()->year;
            $last     = self::where('hospital_id', $appt->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->appointment_number, -6)) + 1 : 1;
            $appt->appointment_number = sprintf('%s-APT-%s-%06d', $prefix, $year, $next);
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function clinic(): BelongsTo { return $this->belongsTo(Clinic::class); }
    public function provider(): BelongsTo { return $this->belongsTo(User::class, 'provider_id'); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function encounter(): BelongsTo { return $this->belongsTo(Encounter::class); }
}
