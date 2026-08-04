<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ClinicalNote extends Model
{
    protected $fillable = [
        'hospital_id', 'patient_id', 'encounter_id', 'author_id',
        'note_number', 'note_type', 'title',
        'subjective', 'objective', 'assessment', 'plan',
        'narrative', 'tags',
        'is_signed', 'signed_at', 'signed_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_signed' => 'boolean',
        'signed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $note) {
            if (empty($note->hospital_id) && Auth::check()) {
                $note->hospital_id = Auth::user()->hospital_id;
            }
            $hospital = Hospital::find($note->hospital_id);
            $prefix = $hospital?->code ?? 'HSP';
            $year = now()->year;
            $last = self::where('hospital_id', $note->hospital_id)
                ->whereYear('created_at', $year)
                ->latest('id')->first();
            $next = $last ? ((int) substr($last->note_number, -6)) + 1 : 1;
            $note->note_number = sprintf('%s-CN-%s-%06d', $prefix, $year, $next);
            if (empty($note->author_id) && Auth::check()) {
                $note->author_id = Auth::id();
            }
        });
    }

    public function hospital(): BelongsTo { return $this->belongsTo(Hospital::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function encounter(): BelongsTo { return $this->belongsTo(Encounter::class); }
    public function author(): BelongsTo { return $this->belongsTo(User::class, 'author_id'); }
    public function signer(): BelongsTo { return $this->belongsTo(User::class, 'signed_by'); }
}
