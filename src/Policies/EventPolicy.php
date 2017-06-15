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
        if ($event->creator->id == $user->id) {
            return true;
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
        if ($event->creator->id == $user->id) {
            return true;
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
        if ($event->creator->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::events.delete');
    }

    /**
     * Determine if the current user can publish events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publish($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.publish');
    }

    /**
     * Determine if the current user can join events.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function join($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.join');
    }

    /**
     * Determine if the current user can access events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicAccess($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.access-public');
    }

    /**
     * Determine if the current user can create events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicCreate($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.create-public');
    }

    /**
     * Determine if the current user can view events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicView($user, Event $event)
    {
        if ($event->creator->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::events.view-public');
    }

    /**
     * Determine if the current user can update events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicUpdate($user, Event $event)
    {
        if ($event->creator->id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::events.update-public');
        }

        return false;
    }

    /**
     * Determine if the current user can delete events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicDelete($user, Event $event)
    {
        if ($event->creator->id == $user->id) {
            return User::findOrFail($user->id)->hasPermission('laralum::events.delete-public');
        }

        return false;
    }

    /**
     * Determine if the current user can publish events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicPublish($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.publish-public');
    }

    /**
     * Determine if the current user can join events on public views.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function publicJoin($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::events.join-public');
    }
}
