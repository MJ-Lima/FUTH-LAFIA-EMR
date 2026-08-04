<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Receipt extends Model
{
    protected $fillable = [
        'hospital_id', 'purchase_id', 'supplier_id', 'received_by',
        'receipt_number', 'received_date',
        'invoice_number', 'delivery_note_number', 'notes', 'status',
    ];

    protected $casts = [
        'received_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $receipt) {
            if (empty($receipt->hospital_id) && Auth::check()) {
                $receipt->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($receipt->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $receipt->hospital_id)
                ->whereYear('created_at', $year)->latest('id')->first();
            $next = $last ? ((int) substr($last->receipt_number, -6)) + 1 : 1;
            $receipt->receipt_number = sprintf('%s-RC-%s-%06d', $prefix, $year, $next);
            if (empty($receipt->received_by) && Auth::check()) {
                $receipt->received_by = Auth::id();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function purchase(): BelongsTo { return $this->belongsTo(Purchase::class); }
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }
    public function receiver(): BelongsTo { return $this->belongsTo(User::class, 'received_by'); }
    public function items(): HasMany { return $this->hasMany(ReceiptItem::class); }
}
