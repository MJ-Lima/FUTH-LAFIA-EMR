<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allergy extends Model
{
    protected $fillable = [
        'patient_id', 'recorded_by', 'encounter_id',
        'substance', 'code', 'category', 'criticality', 'severity',
        'reaction', 'reaction_description', 'onset_date', 'notes', 'status',
    ];

    protected $casts = ['onset_date' => 'date'];

    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function encounter(): BelongsTo { return $this->belongsTo(Encounter::class); }
    public function recorder(): BelongsTo { return $this->belongsTo(User::class, 'recorded_by'); }
}
