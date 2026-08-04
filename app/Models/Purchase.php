<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Purchase extends Model
{
    protected $fillable = [
        'hospital_id', 'supplier_id', 'received_by',
        'purchase_number', 'invoice_number', 'lpo_number',
        'order_date', 'received_date', 'invoice_date',
        'subtotal', 'tax_amount', 'discount_amount', 'total_amount', 'amount_paid',
        'status', 'payment_status', 'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'received_date' => 'date',
        'invoice_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $purchase) {
            if (empty($purchase->hospital_id) && Auth::check()) {
                $purchase->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($purchase->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $purchase->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->purchase_number, -6)) + 1 : 1;
            $purchase->purchase_number = sprintf('%s-PO-%s-%06d', $prefix, $year, $next);
            if (empty($purchase->received_by) && Auth::check()) {
                $purchase->received_by = Auth::id();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }
    public function receiver(): BelongsTo { return $this->belongsTo(User::class, 'received_by'); }
    public function items(): HasMany { return $this->hasMany(PurchaseItem::class); }
    public function receipts(): HasMany { return $this->hasMany(Receipt::class); }
}
