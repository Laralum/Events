<?php

namespace Laralum\Events\Traits;

use Laralum\Events\Models\Event;

trait Events {
    public function joinedEvents() {
        return $this->belongsToMany(Event::class, 'laralum_event_user')->withPivot('responsible');
    }

    public function responsibleEvents () {
        return $this->joinedEvents()->wherePivot('responsible', true)->get();
    }
}
