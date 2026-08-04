<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
	
	protected $fillable = [
        'name',
        'code',
        'status',
    ];

	public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
	
	public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
	
	public function encounter(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }
}