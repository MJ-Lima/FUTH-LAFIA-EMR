<?php

namespace App\Filament\Traits;

use App\Models\DutyPosting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema as DBSchema;

/**
 * Apply hospital / unit scoping to Filament resources so that staff only see
 * records belonging to the hospital, department and clinic they are currently
 * posted to.
 *
 * Super Admin and Medical Administrator bypass the scope.
 */
trait HasUnitScoping
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();

        if (! $user) return $query;

        if ($user->hasRole(['Super Admin', 'Medical Administrator'])) {
            return $query;
        }

        // Only apply hospital_id scope if the table actually has the column
        $model = $query->getModel();
        $table = $model->getTable();
        if (! DBSchema::hasColumn($table, 'hospital_id')) {
            return $query;
        }

        $today = now()->toDateString();

        // Find the user's currently-active duty posting
        $posting = DutyPosting::where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->latest('id')
            ->first();

        // If a posting exists, filter by its hospital
        if ($posting && $posting->hospital_id) {
            $query->where('hospital_id', $posting->hospital_id);
        } elseif ($user->hospital_id) {
            // Fallback: restrict to user's hospital
            $query->where('hospital_id', $user->hospital_id);
        }

        return $query;
    }

    /**
     * Get the current user's duty posting context.
     */
    public static function currentUserContext(): ?array
    {
        $user = auth()->user();
        if (! $user) return null;
        if ($user->hasRole(['Super Admin', 'Medical Administrator'])) return null;

        $today = now()->toDateString();
        $posting = DutyPosting::where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->latest('id')
            ->first();

        if ($posting) {
            return [
                'hospital_id'   => $posting->hospital_id,
                'department_id' => $posting->department_id,
                'clinic_id'     => $posting->clinic_id,
            ];
        }

        return [
            'hospital_id'   => $user->hospital_id,
            'department_id' => $user->department_id,
            'clinic_id'     => $user->default_clinic_id,
        ];
    }
}