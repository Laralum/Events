<?php

namespace Laralum\Events\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Events\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', Settings::class);

        $this->validate($request, [
            'text_editor' => 'required|in:plain-text,markdown,wysiwyg',
            'public_url'  => 'required|max:255',
        ]);

        Settings::first()->update([
            'text_editor' => $request->input('text_editor'),
            'public_url'  => $request->input('public_url'),
        ]);

        return redirect()->route('laralum::settings.index', ['p' => 'Events'])->with('success', __('laralum_events::general.events_settings_updated'));
    }
}
