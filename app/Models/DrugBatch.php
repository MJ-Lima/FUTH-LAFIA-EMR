<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugBatch extends Model
{
    protected $fillable = [
        'drug_id', 'batch_number', 'expiry_date', 'manufactured_date',
        'quantity_received', 'quantity_remaining', 'cost_price',
        'supplier', 'received_date', 'is_quarantined',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'manufactured_date' => 'date',
        'received_date' => 'date',
        'quantity_received' => 'decimal:2',
        'quantity_remaining' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_quarantined' => 'boolean',
    ];

    public function drug(): BelongsTo { return $this->belongsTo(Drug::class); }

    public function isExpired(): bool
    {
        return $this->expiry_date?->isPast() ?? false;
    }

    public function isExpiringSoon(int $days = 90): bool
    {
        return $this->expiry_date?->lessThanOrEqualTo(now()->addDays($days)) ?? false;
    }
}
