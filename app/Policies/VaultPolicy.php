<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vault;

class VaultPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vault $vault): bool
    {
        if ($vault->owner_id === $user->id) {
            return true;
        }
        return $vault->roleAssignments()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     * NOTE: Only the owner or the admin can edit Vault
     */
    public function update(User $user, Vault $vault): bool
    {
        return $vault->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vault $vault): bool
    {
        return $vault->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vault $vault): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vault $vault): bool
    {
        return false;
    }
}
