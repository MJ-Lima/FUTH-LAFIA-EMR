<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes;

    protected $fillable = ['hospital_id', 'name', 'code', 'status'];

    protected function casts(): array
    {
        return ['status' => 'boolean'];
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function encounters(): HasMany { return $this->hasMany(Encounter::class); }
    public function appointments(): HasMany { return $this->hasMany(Appointment::class); }
    public function staff(): HasMany { return $this->hasMany(Staff::class); }
    public function dutyPostings(): HasMany { return $this->hasMany(DutyPosting::class); }
}
