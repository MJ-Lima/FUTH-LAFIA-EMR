<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabPanel extends Model
{
    protected $fillable = [
        'hospital_id', 'name', 'code', 'loinc_code', 'specimen_type',
        'container', 'description', 'price', 'turnaround_hours', 'status',
    ];

    protected $casts = ['price' => 'decimal:2'];

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function tests(): HasMany { return $this->hasMany(LabTest::class); }
}
