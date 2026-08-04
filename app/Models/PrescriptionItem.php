<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrescriptionItem extends Model
{
    protected $fillable = [
        'prescription_id', 'drug_id', 'drug_batch_id',
        'drug_name', 'dosage_form', 'strength',
        'dose', 'route', 'frequency', 'duration',
        'quantity', 'quantity_dispensed', 'instructions', 'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_dispensed' => 'integer',
    ];

    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class); }
    public function drug(): BelongsTo { return $this->belongsTo(Drug::class); }
    public function batch(): BelongsTo { return $this->belongsTo(DrugBatch::class, 'drug_batch_id'); }
}
