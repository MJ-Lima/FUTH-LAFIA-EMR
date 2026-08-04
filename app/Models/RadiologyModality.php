<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RadiologyModality extends Model
{
    protected $fillable = [
        'hospital_id', 'name', 'code', 'description', 'price', 'turnaround_hours', 'status',
    ];

    protected $casts = ['price' => 'decimal:2'];

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function orders(): HasMany { return $this->hasMany(RadiologyOrder::class, 'modality_id'); }
}
