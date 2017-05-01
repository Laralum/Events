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
        'prefix'    => $public_url,
        'as'        => 'laralum_public::events.',
    ], function () use ($public_url) {
        Route::get('/', 'PublicEventController@index')->name('index');
        Route::get('/{event}', 'PublicEventController@show')->name('show');
        Route::get('/create', 'PublicEventController@create')->name('create');
        Route::post('/', 'PublicEventController@store')->name('store');
        Route::get('/{event}/edit', 'PublicEventController@edit')->name('edit');
        Route::patch('/{event}', 'PublicEventController@update')->name('update');
        Route::delete('/{event}', 'PublicEventController@destroy')->name('destroy');
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Events\Models\Event',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Events\Controllers',
        'as'        => 'laralum::events.',
    ], function () {
        Route::get('events/{event}/delete', 'EventController@confirmDestroy')->name('destroy.confirm');
        Route::resource('events', 'CategoryController');
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
