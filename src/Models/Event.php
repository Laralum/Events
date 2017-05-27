<?php

namespace Laralum\Events\Models;

use Carbon\Carbon;
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'user_id', 'description',
        'start_date', 'start_time', 'end_date',
        'end_time', 'price', 'color',
        'place', 'public',
    ];

    /**
     * Return the event creator.
     */
    public function creator()
    {
        return $this->belongsTo('\Laralum\Users\Models\User');
    }

    /**
     * Return all the event users.
     */
    public function users()
    {
        return $this->belongsToMany('\Laralum\Users\Models\User', 'laralum_event_user')->withPivot('responsible');
    }

    /**
     * Returns all the events responsibles.
     */
    public function responsibles()
    {
        return $this->users()->wherePivot('responsible', true)->get();
    }

    /**
     * Returns true if the event have the specified user as responsible.
     *
     * @param mixed $user
     */
    public function hasResponsible($user)
    {
        return $this->users()->where('user_id', $user->id)->first()->pivot->responsible;
    }

    /**
     * Adds a responsible into the event.
     *
     * @param mixed $user
     */
    public function addResponsible($user)
    {
        return $this->users()->UpdateExistingPivot($user->id, ['responsible' => true]);
    }

    /**
     * Deletes a responsible from the event.
     *
     * @param mixed $user
     */
    public function deleteResponsible($user)
    {
        return $this->users()->UpdateExistingPivot($user->id, ['responsible' => false]);
    }

    /**
     * Returns true if the event have the specified user.
     *
     * @param mixed $user
     */
    public function hasUser($user)
    {
        return $this->users()->where('user_id', $user->id)->first();
        // return EventUser::where([
        //     'event_id' => $this->id,
        //     'user_id'  => $user->id,
        // ])->first();
    }

    /**
     * Adds a user into the event.
     *
     * @param mixed $user
     */
    public function addUser($user)
    {
        return $this->users()->attach($user->id);
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
        return $this->users()->detach($user->id);
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

    /**
     * Get Carbon start datetime.
     *
     * @return \Carbon\Carbon
     */
    public function startDatetime()
    {
        $date = explode('-', $this->start_date);
        $time = explode(':', $this->start_time);
        $start_datetime = Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1]);

        return $start_datetime;
    }

    /**
     * Get Carbon end datetime.
     *
     * @return \Carbon\Carbon
     */
    public function endDatetime()
    {
        $date = explode('-', $this->end_date);
        $time = explode(':', $this->end_time);
        $end_datetime = Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1]);

        return $end_datetime;
    }

    /**
     * Returns true if event has started or passed.
     *
     * @return bool
     */
    public function started()
    {
        return $this->startDatetime()->isPast();
    }

    /**
     * Returns true if event has finished.
     *
     * @return bool
     */
    public function finished()
    {
        return $this->endDatetime()->isPast();
    }

    /**
     * Returns the duration as a human readable string.
     *
     * @return bool
     */
    public function duration()
    {
        return $this->endDatetime()->diffForHumans($this->startDatetime(), true);
    }
}
