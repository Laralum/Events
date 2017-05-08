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
        return view('laralum_events::laralum.index', ['events' => Event::paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->validate($request, [
            'title' => 'required|max:191',
            'color' => 'required|max:191',
            'description' => 'required|max:2500',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        Event::create([
            'title'   => $request->title,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'color' => $request->color,
            'time' => $request->time,
            'date' => $request->date,
            'price' => $request->price,
            'public' => $request->has('public'),
            'title' => $request->title,
        ]);

        return redirect()->route('laralum::events.index')->with('success', __('laralum_events::general.event_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
