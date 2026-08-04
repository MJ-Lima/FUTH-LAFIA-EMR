<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class StockReturn extends Model
{
    protected $fillable = [
        'hospital_id', 'patient_id', 'dispensing_log_id',
        'drug_id', 'drug_batch_id', 'received_by',
        'return_number', 'returned_at',
        'quantity', 'reason', 'notes', 'disposition',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
        'quantity' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $ret) {
            if (empty($ret->hospital_id) && Auth::check()) {
                $ret->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($ret->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $ret->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->return_number, -6)) + 1 : 1;
            $ret->return_number = sprintf('%s-RT-%s-%06d', $prefix, $year, $next);
            if (empty($ret->received_by) && Auth::check()) {
                $ret->received_by = Auth::id();
            }
            if (empty($ret->returned_at)) {
                $ret->returned_at = now();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function dispensingLog(): BelongsTo { return $this->belongsTo(DispensingLog::class); }
    public function drug(): BelongsTo { return $this->belongsTo(Drug::class); }
    public function batch(): BelongsTo { return $this->belongsTo(DrugBatch::class, 'drug_batch_id'); }
    public function receiver(): BelongsTo { return $this->belongsTo(User::class, 'received_by'); }
}
