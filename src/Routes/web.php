<?php

if (\Illuminate\Support\Facades\Schema::hasTable('laralum_events_settings')) {
    $public_url = \Laralum\Events\Models\Settings::first()->public_url;
} else {
    $public_url = 'events';
}
Route::group([
        'middleware' => [
            'web', 'laralum.base',
            'auth', 'can:publicAccess,Laralum\Events\Models\Event',
        ],
        'namespace' => 'Laralum\Events\Controllers',
        'as'        => 'laralum_public::events.',
    ], function () use ($public_url) {
        Route::post($public_url.'/{event}/join', 'PublicEventController@join')->name('join');
        Route::post($public_url.'/{event}/leave', 'PublicEventController@leave')->name('leave');

        Route::resource($public_url, 'PublicEventController', [
            'parameters' => [
                $public_url => 'event'
            ],
            'names' => [
                'index'   => 'index',
                'create'  => 'create',
                'store'   => 'store',
                'show'    => 'show',
                'edit'    => 'edit',
                'update'  => 'update',
                'destroy' => 'destroy',
            ]
        ]);
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Events\Models\Event',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Events\Controllers',
        'as'        => 'laralum::',
    ], function () {
        Route::get('events/{event}/delete', 'EventController@confirmDestroy')->name('events.destroy.confirm');
        Route::post('events/{event}/join', 'EventController@join')->name('events.join');
        Route::post('events/{event}/leave', 'EventController@leave')->name('events.leave');
        Route::resource('events', 'EventController');
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Events\Models\Settings',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Events\Controllers',
        'as'        => 'laralum::events.',
    ], function () {
        Route::post('/events/settings', 'SettingsController@update')->name('settings.update');
    });
