<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Prescription extends Model
{
    protected $fillable = [
        'hospital_id', 'patient_id', 'encounter_id',
        'prescriber_id', 'dispensing_point_id',
        'prescription_number', 'prescribed_at', 'dispensed_at', 'dispensed_by',
        'status', 'priority', 'is_inpatient', 'notes',
    ];

    protected $casts = [
        'prescribed_at' => 'datetime',
        'dispensed_at' => 'datetime',
        'is_inpatient' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $rx) {
            if (empty($rx->hospital_id) && Auth::check()) {
                $rx->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($rx->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $rx->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->prescription_number, -6)) + 1 : 1;
            $rx->prescription_number = sprintf('%s-RX-%s-%06d', $prefix, $year, $next);
            if (empty($rx->prescriber_id) && Auth::check()) {
                $rx->prescriber_id = Auth::id();
            }
            if (empty($rx->prescribed_at)) {
                $rx->prescribed_at = now();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function encounter(): BelongsTo { return $this->belongsTo(Encounter::class); }
    public function prescriber(): BelongsTo { return $this->belongsTo(User::class, 'prescriber_id'); }
    public function dispenser(): BelongsTo { return $this->belongsTo(User::class, 'dispensed_by'); }
    public function dispensingPoint(): BelongsTo { return $this->belongsTo(DispensingPoint::class); }
    public function items(): HasMany { return $this->hasMany(PrescriptionItem::class); }
}
