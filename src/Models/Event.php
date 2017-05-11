<?php

namespace Laralum\Events\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_events';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'user_id', 'description', 'time', 'date', 'price', 'color', 'public'];

    /**
     * Return the event author.
     */
    public function user()
    {
        return $this->belongsTo('\Laralum\Users\Models\User');
    }

    /**
     * Return all the event users.
     */
    public function users()
    {
        return $this->belongsToMany('\Laralum\Users\Models\User', 'laralum_event_user');
    }

    /**
     * Returns true if the event have the specified user.
     *
     * @param mixed $user
     */
    public function hasUser($user)
    {
        return EventUser::where(
                ['event_id' => $this->id, 'user_id' => $user->id]
            )->first();
    }

    /**
     * Adds a user into the event.
     *
     * @param mixed $user
     */
    public function addUser($user)
    {
        if (!$this->hasUser($user)) {
            return EventUser::create(['event_id' => $this->id, 'user_id' => $user->id]);
        }

        return false;
    }

    /**
     * Adds users into the event.
     *
     * @param array $users
     */
    public function addUsers($users)
    {
        foreach ($users as $user) {
            $this->addUser($user);
        }

        return true;
    }

    /**
     * Deletes the specified event user.
     *
     * @param mixed $user
     */
    public function deleteUser($user)
    {
        if ($this->hasUser($user)) {
            return EventUser::where(
                    ['event_id' => $this->id, 'user_id' => $user->id]
                )->first()->delete();
        }

        return false;
    }

    /**
     * Deletes the specified role users.
     *
     * @param array $users
     */
    public function deleteUsers($users)
    {
        foreach ($users as $user) {
            $this->deleteUser($user);
        }

        return true;
    }
}
