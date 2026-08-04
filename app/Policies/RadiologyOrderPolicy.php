<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\RadiologyOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class RadiologyOrderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:RadiologyOrder');
    }

    public function view(AuthUser $authUser, RadiologyOrder $radiologyOrder): bool
    {
        return $authUser->can('View:RadiologyOrder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:RadiologyOrder');
    }

    public function update(AuthUser $authUser, RadiologyOrder $radiologyOrder): bool
    {
        return $authUser->can('Update:RadiologyOrder');
    }

    public function delete(AuthUser $authUser, RadiologyOrder $radiologyOrder): bool
    {
        return $authUser->can('Delete:RadiologyOrder');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:RadiologyOrder');
    }

    public function restore(AuthUser $authUser, RadiologyOrder $radiologyOrder): bool
    {
        return $authUser->can('Restore:RadiologyOrder');
    }

    public function forceDelete(AuthUser $authUser, RadiologyOrder $radiologyOrder): bool
    {
        return $authUser->can('ForceDelete:RadiologyOrder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:RadiologyOrder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:RadiologyOrder');
    }

    public function replicate(AuthUser $authUser, RadiologyOrder $radiologyOrder): bool
    {
        return $authUser->can('Replicate:RadiologyOrder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:RadiologyOrder');
    }

}