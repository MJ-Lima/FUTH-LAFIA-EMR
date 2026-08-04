<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DrugCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrugCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DrugCategory');
    }

    public function view(AuthUser $authUser, DrugCategory $drugCategory): bool
    {
        return $authUser->can('View:DrugCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DrugCategory');
    }

    public function update(AuthUser $authUser, DrugCategory $drugCategory): bool
    {
        return $authUser->can('Update:DrugCategory');
    }

    public function delete(AuthUser $authUser, DrugCategory $drugCategory): bool
    {
        return $authUser->can('Delete:DrugCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:DrugCategory');
    }

    public function restore(AuthUser $authUser, DrugCategory $drugCategory): bool
    {
        return $authUser->can('Restore:DrugCategory');
    }

    public function forceDelete(AuthUser $authUser, DrugCategory $drugCategory): bool
    {
        return $authUser->can('ForceDelete:DrugCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DrugCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DrugCategory');
    }

    public function replicate(AuthUser $authUser, DrugCategory $drugCategory): bool
    {
        return $authUser->can('Replicate:DrugCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DrugCategory');
    }

}