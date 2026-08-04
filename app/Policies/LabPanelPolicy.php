<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LabPanel;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabPanelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LabPanel');
    }

    public function view(AuthUser $authUser, LabPanel $labPanel): bool
    {
        return $authUser->can('View:LabPanel');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LabPanel');
    }

    public function update(AuthUser $authUser, LabPanel $labPanel): bool
    {
        return $authUser->can('Update:LabPanel');
    }

    public function delete(AuthUser $authUser, LabPanel $labPanel): bool
    {
        return $authUser->can('Delete:LabPanel');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:LabPanel');
    }

    public function restore(AuthUser $authUser, LabPanel $labPanel): bool
    {
        return $authUser->can('Restore:LabPanel');
    }

    public function forceDelete(AuthUser $authUser, LabPanel $labPanel): bool
    {
        return $authUser->can('ForceDelete:LabPanel');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LabPanel');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LabPanel');
    }

    public function replicate(AuthUser $authUser, LabPanel $labPanel): bool
    {
        return $authUser->can('Replicate:LabPanel');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LabPanel');
    }

}