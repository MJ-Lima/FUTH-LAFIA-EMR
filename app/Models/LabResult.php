<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabResult extends Model
{
    protected $fillable = [
        'lab_order_item_id', 'lab_test_id',
        'performed_by', 'verified_by',
        'value', 'value_numeric', 'unit', 'reference_range',
        'flag', 'interpretation', 'comments',
        'performed_at', 'verified_at', 'is_verified',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function orderItem(): BelongsTo { return $this->belongsTo(LabOrderItem::class); }
    public function test(): BelongsTo { return $this->belongsTo(LabTest::class, 'lab_test_id'); }
    public function performer(): BelongsTo { return $this->belongsTo(User::class, 'performed_by'); }
    public function verifier(): BelongsTo { return $this->belongsTo(User::class, 'verified_by'); }
}
