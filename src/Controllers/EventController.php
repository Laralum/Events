<?php

namespace Laralum\Events\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laralum\Events\Models\Event;
use Laralum\Events\Models\Settings;
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

        return view('laralum_events::laralum.index', [
            'events' => Event::orderBy('id', 'desc')->paginate(50),
        ]);
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
     * Get Carbon start datetime and end datemime.
     *
     * @param mixed $object
     *
     * @return array
     */
    private function getDatetime($datein, $timein)
    {
        $date = explode('-', $datein);
        $time = explode(':', $timein);
        $datetime = Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1]);

        return $datetime;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

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
            'title'       => 'required|max:191',
            'description' => 'required|max:2500',
            'color'       => 'max:191',
            'place'       => 'max:191',
            'price'       => 'required|numeric|max:999999999.99',
        ]);

        $start_datetime = self::getDatetime($request->start_date, $request->start_time);
        $end_datetime = self::getDatetime($request->end_date, $request->end_time);

        if ($end_datetime->lte($start_datetime)) {
            $validator->errors()->add('end_date', __('laralum_events::general.end_date_after_start_date'));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(Auth::id());

        if (Settings::first()->text_editor == 'markdown') {
            $desc = Markdown::convertToHtml($request->description);
        } else {
            $desc = htmlentities($request->description);
        }

        Event::create([
            'title'       => $request->title,
            'start_date'  => $request->start_date,
            'start_time'  => $request->start_time,
            'end_date'    => $request->end_date,
            'end_time'    => $request->end_time,
            'user_id'     => Auth::id(),
            'description' => $desc,
            'color'       => $request->color,
            'place'       => $request->place,
            'price'       => $request->price,
            'public'      => $user->can('publish', Event::class) ? $request->has('public') : false,
        ]);

        return redirect()->route('laralum::events.index')->with('success', __('laralum_events::general.event_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param \Laralum\Events\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return view('laralum_events::laralum.show', [
            'event' => $event,
            'users' => $event->users()->paginate(50),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Laralum\Events\Models\Event $event
     *
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
     * @param \Illuminate\Http\Request     $request
     * @param \Laralum\Events\Models\Event $event
     *
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
            'title'       => 'required|max:191',
            'description' => 'required|max:2500',
            'color'       => 'max:191',
            'place'       => 'max:191',
            'price'       => 'required|numeric|max:999999999.99',
        ]);

        $start_datetime = self::getDatetime($request->start_date, $request->start_time);
        $end_datetime = self::getDatetime($request->end_date, $request->end_time);

        if ($end_datetime->lte($start_datetime)) {
            $validator->errors()->add('end_date', __('laralum_events::general.end_date_after_start_date'));

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(Auth::id());

        if (Settings::first()->text_editor == 'markdown') {
            $desc = Markdown::convertToHtml($request->description);
        } else {
            $desc = htmlentities($request->description);
        }

        $event->update([
            'title'       => $request->title,
            'start_date'  => $request->start_date,
            'start_time'  => $request->start_time,
            'end_date'    => $request->end_date,
            'end_time'    => $request->end_time,
            'description' => $desc,
            'color'       => $request->color,
            'place'       => $request->place,
            'price'       => $request->price,
            'public'      => $user->can('publish', Event::class) ? $request->has('public') : false,
        ]);

        $event->touch();

        return redirect()->route('laralum::events.index')->with('success', __('laralum_events::general.event_updated', ['id' => $event->id]));
    }

    /**
     * confirm destroy of the specified resource from storage.
     *
     * @param \Laralum\Events\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request, Event $event)
    {
        $this->authorize('delete', $event);

        return view('laralum::pages.confirmation', [
            'method'  => 'DELETE',
            'message' => __('laralum_events::general.sure_del_event', ['event' => $event->title]),
            'action'  => route('laralum::events.destroy', ['event' => $event->id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Laralum\Events\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->deleteUsers($event->users);
        $event->delete();

        return redirect()->route('laralum::events.index')
            ->with('success', __('laralum_events::general.event_deleted', ['id' => $event->id]));
    }

    /**
     * Join to the specified resource from storage.
     *
     * @param \Laralum\Events\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function join(Event $event)
    {
        $this->authorize('join', Event::class);
        $event->addUser(User::findOrfail(Auth::id()));

        return redirect()->route('laralum::events.index')
            ->with('success', __('laralum_events::general.joined_event', ['id' => $event->id]));
    }

    /**
     * Leave from the specified resource from storage.
     *
     * @param \Laralum\Events\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function leave(Event $event)
    {
        $this->authorize('join', Event::class);
        $event->deleteUser(User::findOrfail(Auth::id()));

        return redirect()->route('laralum::events.index')
            ->with('success', __('laralum_events::general.left_event', ['id' => $event->id]));
    }

    /**
     * Make author of to the specified resource from storage.
     *
     * @param \Laralum\Events\Models\Event $event
     * @param \Laralum\Users\Models\User   $user
     *
     * @return \Illuminate\Http\Response
     */
    public function makeResponsible(Event $event, User $user)
    {
        $this->authorize('update', $event);
        $event->addResponsible($user);

        return redirect()->route('laralum::events.show', ['event' => $event->id])
            ->with('success', __('laralum_events::general.responsible_added', ['event_id' => $event->id, 'user_id' => $user->id]));
    }

    /**
     * Undo author from the specified resource from storage.
     *
     * @param \Laralum\Events\Models\Event $event
     * @param \Laralum\Users\Models\User   $user
     *
     * @return \Illuminate\Http\Response
     */
    public function undoResponsible(Event $event, User $user)
    {
        $this->authorize('update', $event);
        $event->deleteResponsible($user);

        return redirect()->route('laralum::events.show', ['event' => $event->id])
            ->with('success', __('laralum_events::general.responsible_deleted', ['event_id' => $event->id, 'user_id' => $user->id]));
    }
}
