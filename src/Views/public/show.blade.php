<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_events::general.events_list') - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
        <link rel="stylesheet" href="https://gitcdn.xyz/repo/24aitor/CLMaterial/master/src/css/clmaterial.min.css">
    </head>
    <body>
        <h1>{{ $event->title }}</h1>
        @if($start_datetime->isFuture())
            @lang('laralum_events::general.time_left_starts')
            <br>
            {{ $start_datetime->diffForHumans() }}
        @elseif ($end_datetime->isFuture())
            @lang('laralum_events::general.time_left_ends')
            <br>
            {{ $end_datetime->diffForHumans() }}
        @else
            @lang('laralum_events::general.event_celebrated')
        @endif

        <hr>
        <dl>
            <dt>@lang('laralum_events::general.description')</dt>
            <dd>{{ $event->description }}</dd>
            <dt>@lang('laralum_events::general.duration')</dt>
            <dd>{{ $end_datetime->diffForHumans($start_datetime, true) }}</dd>
            <dt>@lang('laralum_events::general.place')</dt>
            <dd>{{ $event->place }}</dd>
            <dt>@lang('laralum_events::general.status')</dt>
            <dd>
                @if ($event->public)
                    @lang('laralum_events::general.published')
                @else
                    @lang('laralum_events::general.unpublished')
                @endif
            </dd>
            <dt>@lang('laralum_events::general.start_date')</dt>
            <dd>{{ $start_datetime->toCookieString() }}</dd>
            <dt>@lang('laralum_events::general.end_date')</dt>
            <dd>{{ $end_datetime->toCookieString() }}</dd>
        </dl>

    </body>
</html>
