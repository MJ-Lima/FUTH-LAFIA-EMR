<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DispensingLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class DispensingLogPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DispensingLog');
    }

    public function view(AuthUser $authUser, DispensingLog $dispensingLog): bool
    {
        return $authUser->can('View:DispensingLog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DispensingLog');
    }

    public function update(AuthUser $authUser, DispensingLog $dispensingLog): bool
    {
        return $authUser->can('Update:DispensingLog');
    }

    public function delete(AuthUser $authUser, DispensingLog $dispensingLog): bool
    {
        return $authUser->can('Delete:DispensingLog');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:DispensingLog');
    }

    public function restore(AuthUser $authUser, DispensingLog $dispensingLog): bool
    {
        return $authUser->can('Restore:DispensingLog');
    }

    public function forceDelete(AuthUser $authUser, DispensingLog $dispensingLog): bool
    {
        return $authUser->can('ForceDelete:DispensingLog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DispensingLog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DispensingLog');
    }

    public function replicate(AuthUser $authUser, DispensingLog $dispensingLog): bool
    {
        return $authUser->can('Replicate:DispensingLog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DispensingLog');
    }

}