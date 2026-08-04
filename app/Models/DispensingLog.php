<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class DispensingLog extends Model
{
    protected $fillable = [
        'hospital_id', 'dispensing_point_id',
        'prescription_id', 'prescription_item_id',
        'drug_id', 'drug_batch_id', 'patient_id', 'dispensed_by',
        'reference_number', 'dispensed_at',
        'quantity', 'unit_price', 'total_price', 'notes',
    ];

    protected $casts = [
        'dispensed_at' => 'datetime',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $log) {
            if (empty($log->hospital_id) && Auth::check()) {
                $log->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($log->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $log->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->reference_number, -6)) + 1 : 1;
            $log->reference_number = sprintf('%s-DP-%s-%06d', $prefix, $year, $next);
            if (empty($log->dispensed_by) && Auth::check()) {
                $log->dispensed_by = Auth::id();
            }
            if (empty($log->dispensed_at)) {
                $log->dispensed_at = now();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function dispensingPoint(): BelongsTo { return $this->belongsTo(DispensingPoint::class); }
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class); }
    public function prescriptionItem(): BelongsTo { return $this->belongsTo(PrescriptionItem::class); }
    public function drug(): BelongsTo { return $this->belongsTo(Drug::class); }
    public function batch(): BelongsTo { return $this->belongsTo(DrugBatch::class, 'drug_batch_id'); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function dispenser(): BelongsTo { return $this->belongsTo(User::class, 'dispensed_by'); }
}
