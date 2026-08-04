<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes;
	
	protected $fillable = [
        'hospital_id',
        'name',
        'code',
        'status',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
	
	public function encounter(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }
	
	public function scheduleConfigurations(): HasMany
    {
        return $this->hasMany(ScheduleConfiguration::class);
    }
	
}