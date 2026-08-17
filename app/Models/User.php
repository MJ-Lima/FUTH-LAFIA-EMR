<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'hospital_id',
        'department_id',
        'default_clinic_id',
        'name',
        'email',
        'password',
        'phone',
        'avatar_url',
        'status',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email'         => 'string',
            'password'      => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    // =========================================
    // RELATIONSHIPS
    // =========================================

    /** User belongs to a Hospital */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /** User belongs to a Department */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /** User's default Clinic */
    public function defaultClinic()
    {
        return $this->belongsTo(Clinic::class, 'default_clinic_id');
    }

    /** User has one Staff record */
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    /** Encounters created by this user (as attending provider — user_id FK) */
    public function encounters()
    {
        return $this->hasMany(Encounter::class, 'user_id');
    }

    /** Encounters created by this user (as creator — created_by FK) */
    public function createdEncounters()
    {
        return $this->hasMany(Encounter::class, 'created_by');
    }

    /** Appointments where user is the provider */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'provider_id');
    }

    /** Clinical notes authored by this user */
    public function clinicalNotes()
    {
        return $this->hasMany(ClinicalNote::class, 'author_id');
    }

    /** Vitals recorded by this user */
    public function recordedVitals()
    {
        return $this->hasMany(Vitals::class, 'recorded_by');
    }

    /** Prescriptions prescribed by this user */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'prescriber');
    }

    /** Lab orders placed by this user */
    public function labOrders()
    {
        return $this->hasMany(LabOrder::class, 'ordering_provider');
    }

    /** Radiology orders placed by this user */
    public function radiologyOrders()
    {
        return $this->hasMany(RadiologyOrder::class, 'ordering_provider');
    }

    /** Duty postings for this user */
    public function dutyPostings()
    {
        return $this->hasMany(DutyPosting::class);
    }

    /** Admissions where user is the admitting doctor */
    public function admissions()
    {
        return $this->hasMany(Admission::class, 'admitting_doctor');
    }

    // =========================================
    // HELPER METHODS
    // =========================================

    /** Get the user's primary role name */
    public function getPrimaryRoleName(): ?string
    {
        return $this->roles->first()?->name;
    }

    /** Check if user has any of the given roles */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /** Get user's display name with title */
    public function getDisplayName(): string
    {
        $staff = $this->staff;
        $title = $staff?->title;

        return trim(($title ? $title . ' ' : '') . $this->name);
    }
}
