<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Vitals;
use Illuminate\Auth\Access\HandlesAuthorization;

class VitalsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Vitals');
    }

    public function view(AuthUser $authUser, Vitals $vitals): bool
    {
        return $authUser->can('View:Vitals');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Vitals');
    }

    public function update(AuthUser $authUser, Vitals $vitals): bool
    {
        return $authUser->can('Update:Vitals');
    }

    public function delete(AuthUser $authUser, Vitals $vitals): bool
    {
        return $authUser->can('Delete:Vitals');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Vitals');
    }

    public function restore(AuthUser $authUser, Vitals $vitals): bool
    {
        return $authUser->can('Restore:Vitals');
    }

    public function forceDelete(AuthUser $authUser, Vitals $vitals): bool
    {
        return $authUser->can('ForceDelete:Vitals');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Vitals');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Vitals');
    }

    public function replicate(AuthUser $authUser, Vitals $vitals): bool
    {
        return $authUser->can('Replicate:Vitals');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Vitals');
    }

}