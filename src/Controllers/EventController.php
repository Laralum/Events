<?php

namespace Laralum\Events\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laralum\Events\Models\Event;
use Laralum\Events\Models\EventUser;
use Laralum\Users\Models\User;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Event::class);

        return view('laralum_events::laralum.index', ['events' => Event::orderBy('id', 'desc')->paginate(50)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('laralum_events::laralum.create');
    }

    private function getDates($object)
    {
        $date = explode('-', $object->start_date);
        $time = explode(':', $object->start_time);
        $start_datetime = Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1]);

        $date = explode('-', $object->end_date);
        $time = explode(':', $object->end_time);
        $end_datetime = Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1]);

        return [$start_datetime, $end_datetime];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        // Check dates
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check others
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'description' => 'required|max:2500',
            'color' => 'max:191',
            'place' => 'max:191',
            'price' => 'required|numeric|max:999999999.99'
        ]);

        [$start_datetime, $end_datetime] = self::getDates($request);

        if ($end_datetime->lte($start_datetime)) {
            $validator->errors()->add('end_date', __('laralum_events::general.end_date_after_start_date'));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(Auth::id());

        Event::create([
            'title'   => $request->title,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'user_id'  => Auth::id(),
            'description' => $request->description,
            'color'  => $request->color,
            'place'  => $request->place,
            'price'  => $request->price,
            'public' => $user->can('publish', Event::class) ? $request->has('public') : false,
        ]);

        return redirect()->route('laralum::events.index')->with('success', __('laralum_events::general.event_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Laralum\Events\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        [$start_datetime, $end_datetime] = self::getDates($event);

        return view('laralum_events::laralum.show', [
            'event'          => $event,
            'start_datetime' => $start_datetime,
            'end_datetime'   => $end_datetime
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Laralum\Events\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('laralum_events::laralum.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Events\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        // Check dates
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date'   => 'required|date',
            'end_time'   => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check others
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'description' => 'required|max:2500',
            'color' => 'max:191',
            'place' => 'max:191',
            'price' => 'required|numeric|max:999999999.99'
        ]);

        [$start_datetime, $end_datetime] = self::getDates($request);

        if ($end_datetime->lte($start_datetime)) {
            $validator->errors()->add('end_date', __('laralum_events::general.end_date_after_start_date'));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(Auth::id());

        $event->update([
            'title'   => $request->title,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'color'  => $request->color,
            'place'  => $request->place,
            'price'  => $request->price,
            'public' => $user->can('publish', Event::class) ? $request->has('public') : false,
        ]);

        $event->touch();

        return redirect()->route('laralum::events.index')->with('success', __('laralum_events::general.event_updated', ['id' => $event->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laralum\Events\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
    }
}
