<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WhatsappGroup;
use Illuminate\Auth\Access\Response;

class WhatsappGroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WhatsappGroup $whatsappGroup): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WhatsappGroup $whatsappGroup): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WhatsappGroup $whatsappGroup): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WhatsappGroup $whatsappGroup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WhatsappGroup $whatsappGroup): bool
    {
        return false;
    }
}
