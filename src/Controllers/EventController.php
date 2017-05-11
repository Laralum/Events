<?php

namespace Laralum\Events\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laralum\Events\Models\Event;
use Laralum\Events\Models\EventUser;
use Laralum\Users\Models\User;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $this->validate($request, [
            'title' => 'required|max:191',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'description' => 'required|max:2500',
            'color' => 'required|max:191',
            'price' => 'required|numeric|max:999999999.99'
        ]);

        Event::create([
            'title'   => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'color' => $request->color,
            'price' => $request->price,
            'public' => $request->has('public'),
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

        return view('laralum_events::laralum.edit', ['event' => $event]);
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

        $event->touch();
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
