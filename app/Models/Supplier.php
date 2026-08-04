<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'hospital_id', 'name', 'code', 'contact_person',
        'phone', 'email', 'address', 'tax_id', 'registration_number',
        'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function purchases(): HasMany { return $this->hasMany(Purchase::class); }
}
