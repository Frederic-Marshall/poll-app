<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Vote;
use App\Models\User;

class VotePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Vote');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vote $vote): bool
    {
        return $user->checkPermissionTo('view Vote');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Vote');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vote $vote): bool
    {
        return $user->checkPermissionTo('update Vote');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vote $vote): bool
    {
        return $user->checkPermissionTo('delete Vote');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Vote');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vote $vote): bool
    {
        return $user->checkPermissionTo('restore Vote');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Vote');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Vote $vote): bool
    {
        return $user->checkPermissionTo('replicate Vote');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Vote');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vote $vote): bool
    {
        return $user->checkPermissionTo('force-delete Vote');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Vote');
    }
}
