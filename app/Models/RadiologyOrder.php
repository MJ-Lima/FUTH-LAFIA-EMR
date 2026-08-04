<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class RadiologyOrder extends Model
{
    protected $fillable = [
        'hospital_id', 'patient_id', 'encounter_id', 'modality_id',
        'requested_by', 'received_by',
        'order_number', 'ordered_at', 'performed_at', 'resulted_at',
        'examination', 'body_part', 'clinical_indication', 'request_notes',
        'priority', 'status',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
        'performed_at' => 'datetime',
        'resulted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $order) {
            if (empty($order->hospital_id) && Auth::check()) {
                $order->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($order->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $order->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->order_number, -6)) + 1 : 1;
            $order->order_number = sprintf('%s-RAD-%s-%06d', $prefix, $year, $next);
            if (empty($order->requested_by) && Auth::check()) {
                $order->requested_by = Auth::id();
            }
            if (empty($order->ordered_at)) {
                $order->ordered_at = now();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function encounter(): BelongsTo { return $this->belongsTo(Encounter::class); }
    public function modality(): BelongsTo { return $this->belongsTo(RadiologyModality::class, 'modality_id'); }
    public function requester(): BelongsTo { return $this->belongsTo(User::class, 'requested_by'); }
    public function receiver(): BelongsTo { return $this->belongsTo(User::class, 'received_by'); }
    public function result(): HasOne { return $this->hasOne(RadiologyResult::class, 'radiology_order_id'); }
}
