<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\SelectOption;
use App\Models\User;

class SelectOptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any SelectOption');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SelectOption $selectoption): bool
    {
        return $user->checkPermissionTo('view SelectOption');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create SelectOption');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SelectOption $selectoption): bool
    {
        return $user->checkPermissionTo('update SelectOption');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SelectOption $selectoption): bool
    {
        return $user->checkPermissionTo('delete SelectOption');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SelectOption $selectoption): bool
    {
        return $user->checkPermissionTo('restore SelectOption');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SelectOption $selectoption): bool
    {
        return $user->checkPermissionTo('force-delete SelectOption');
    }
}
