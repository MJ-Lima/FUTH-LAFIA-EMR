<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'hospital_id',
        'department_id',
        'clinic_id',
        'staff_number',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'designation',
        'staff_type',
        'signature',
        'passport',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function getFullNameAttribute()
    {
        return trim(
            "{$this->title} {$this->first_name} {$this->middle_name} {$this->last_name}"
        );
    }
}