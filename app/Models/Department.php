<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class Department extends Model
{
    use SoftDeletes;
	
	protected $fillable = [
        'hospital_id',
        'name',
        'code',
        'description',
		'status'
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
