<?php

namespace Laralum\Events\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Events\Models\Event;
use Laralum\Users\Models\User;

class EventPolicy
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
     * Determine if the current user can access events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.access');
    }

    /**
     * Determine if the current user can create events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.create');
    }

    /**
     * Determine if the current user can view events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function view($user, Event $event)
    {
        if ($event->user->id == $user->id) {
            return True;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::events.view');
    }

    /**
     * Determine if the current user can update events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function update($user, Event $event)
    {
        if ($event->user->id == $user->id) {
            return True;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::events.update');
    }

    /**
     * Determine if the current user can delete events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function delete($user, Event $event)
    {
        if ($event->user->id == $user->id) {
            return True;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::events.delete');
    }

    /**
     * Determine if the current user can publish events.
     *
     * @param mixed                        $user
     * @param \Laralum\Events\Models\Event $event
     *
     * @return bool
     */
    public function publish($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.publish');
    }
}
