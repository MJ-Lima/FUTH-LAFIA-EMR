<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Diagnosis;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiagnosisPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Diagnosis');
    }

    public function view(AuthUser $authUser, Diagnosis $diagnosis): bool
    {
        return $authUser->can('View:Diagnosis');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Diagnosis');
    }

    public function update(AuthUser $authUser, Diagnosis $diagnosis): bool
    {
        return $authUser->can('Update:Diagnosis');
    }

    public function delete(AuthUser $authUser, Diagnosis $diagnosis): bool
    {
        return $authUser->can('Delete:Diagnosis');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Diagnosis');
    }

    public function restore(AuthUser $authUser, Diagnosis $diagnosis): bool
    {
        return $authUser->can('Restore:Diagnosis');
    }

    public function forceDelete(AuthUser $authUser, Diagnosis $diagnosis): bool
    {
        return $authUser->can('ForceDelete:Diagnosis');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Diagnosis');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Diagnosis');
    }

    public function replicate(AuthUser $authUser, Diagnosis $diagnosis): bool
    {
        return $authUser->can('Replicate:Diagnosis');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Diagnosis');
    }

}