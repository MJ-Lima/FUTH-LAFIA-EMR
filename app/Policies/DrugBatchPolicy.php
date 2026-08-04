<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DrugBatch;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrugBatchPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DrugBatch');
    }

    public function view(AuthUser $authUser, DrugBatch $drugBatch): bool
    {
        return $authUser->can('View:DrugBatch');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DrugBatch');
    }

    public function update(AuthUser $authUser, DrugBatch $drugBatch): bool
    {
        return $authUser->can('Update:DrugBatch');
    }

    public function delete(AuthUser $authUser, DrugBatch $drugBatch): bool
    {
        return $authUser->can('Delete:DrugBatch');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:DrugBatch');
    }

    public function restore(AuthUser $authUser, DrugBatch $drugBatch): bool
    {
        return $authUser->can('Restore:DrugBatch');
    }

    public function forceDelete(AuthUser $authUser, DrugBatch $drugBatch): bool
    {
        return $authUser->can('ForceDelete:DrugBatch');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DrugBatch');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DrugBatch');
    }

    public function replicate(AuthUser $authUser, DrugBatch $drugBatch): bool
    {
        return $authUser->can('Replicate:DrugBatch');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DrugBatch');
    }

}