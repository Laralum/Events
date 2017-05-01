<?php

namespace Laralum\Events\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Users\Models\User;

class SettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can edit the events settings.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function update($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.settings');
    }
}
