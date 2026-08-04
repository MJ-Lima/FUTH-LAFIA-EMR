<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\RadiologyModality;
use Illuminate\Auth\Access\HandlesAuthorization;

class RadiologyModalityPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:RadiologyModality');
    }

    public function view(AuthUser $authUser, RadiologyModality $radiologyModality): bool
    {
        return $authUser->can('View:RadiologyModality');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:RadiologyModality');
    }

    public function update(AuthUser $authUser, RadiologyModality $radiologyModality): bool
    {
        return $authUser->can('Update:RadiologyModality');
    }

    public function delete(AuthUser $authUser, RadiologyModality $radiologyModality): bool
    {
        return $authUser->can('Delete:RadiologyModality');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:RadiologyModality');
    }

    public function restore(AuthUser $authUser, RadiologyModality $radiologyModality): bool
    {
        return $authUser->can('Restore:RadiologyModality');
    }

    public function forceDelete(AuthUser $authUser, RadiologyModality $radiologyModality): bool
    {
        return $authUser->can('ForceDelete:RadiologyModality');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:RadiologyModality');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:RadiologyModality');
    }

    public function replicate(AuthUser $authUser, RadiologyModality $radiologyModality): bool
    {
        return $authUser->can('Replicate:RadiologyModality');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:RadiologyModality');
    }

}