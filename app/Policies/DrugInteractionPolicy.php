<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DrugInteraction;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrugInteractionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DrugInteraction');
    }

    public function view(AuthUser $authUser, DrugInteraction $drugInteraction): bool
    {
        return $authUser->can('View:DrugInteraction');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DrugInteraction');
    }

    public function update(AuthUser $authUser, DrugInteraction $drugInteraction): bool
    {
        return $authUser->can('Update:DrugInteraction');
    }

    public function delete(AuthUser $authUser, DrugInteraction $drugInteraction): bool
    {
        return $authUser->can('Delete:DrugInteraction');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:DrugInteraction');
    }

    public function restore(AuthUser $authUser, DrugInteraction $drugInteraction): bool
    {
        return $authUser->can('Restore:DrugInteraction');
    }

    public function forceDelete(AuthUser $authUser, DrugInteraction $drugInteraction): bool
    {
        return $authUser->can('ForceDelete:DrugInteraction');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DrugInteraction');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DrugInteraction');
    }

    public function replicate(AuthUser $authUser, DrugInteraction $drugInteraction): bool
    {
        return $authUser->can('Replicate:DrugInteraction');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DrugInteraction');
    }

}