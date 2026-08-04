<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DispensingPoint;
use Illuminate\Auth\Access\HandlesAuthorization;

class DispensingPointPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DispensingPoint');
    }

    public function view(AuthUser $authUser, DispensingPoint $dispensingPoint): bool
    {
        return $authUser->can('View:DispensingPoint');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DispensingPoint');
    }

    public function update(AuthUser $authUser, DispensingPoint $dispensingPoint): bool
    {
        return $authUser->can('Update:DispensingPoint');
    }

    public function delete(AuthUser $authUser, DispensingPoint $dispensingPoint): bool
    {
        return $authUser->can('Delete:DispensingPoint');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:DispensingPoint');
    }

    public function restore(AuthUser $authUser, DispensingPoint $dispensingPoint): bool
    {
        return $authUser->can('Restore:DispensingPoint');
    }

    public function forceDelete(AuthUser $authUser, DispensingPoint $dispensingPoint): bool
    {
        return $authUser->can('ForceDelete:DispensingPoint');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DispensingPoint');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DispensingPoint');
    }

    public function replicate(AuthUser $authUser, DispensingPoint $dispensingPoint): bool
    {
        return $authUser->can('Replicate:DispensingPoint');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DispensingPoint');
    }

}