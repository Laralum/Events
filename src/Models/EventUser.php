<?php

namespace Laralum\Events\Models;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_event_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_id', 'user_id'];
}
