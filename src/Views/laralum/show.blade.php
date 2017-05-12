@extends('laralum::layouts.master')
@section('icon', 'ion-calendar')
@section('title', $event->title)
@section('subtitle', __('laralum_events::general.event_desc', ['event_id' => $event->id]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><a href="{{ route('laralum::events.index') }}">@lang('laralum_events::general.events_list')</a></li>
        <li><span>@lang('laralum_events::general.event_title')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-5@l uk-width-1-1@m"></div>
            <div class="uk-width-3-5@l uk-width-1-1@m">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_events::general.events_list')
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-text-lead uk-text-center uk-margin-medium-bottom">@lang('laralum_events::general.time_left')</div>
                        {{-- <div id="countdown" class="uk-grid-small uk-child-width-auto uk-text-center uk-flex-center" uk-grid uk-countdown="date: {{ $event->date .'T'. $event->time}}"> --}}
                        @php
                            $date = explode('-', $event->date);
                            $time = explode(':', $event->time);
                            $datetime = \Carbon\Carbon::create($date[0], $date[1], $date[2], $time[0], $time[1]);
                        @endphp
                        @if($datetime->isFuture())
                        <div id="countdown" class="uk-grid-small uk-child-width-auto uk-text-center uk-flex-center sticky" uk-grid uk-countdown="date: {{$datetime->subHours(2)->toAtomString() }}">
                            <div>
                                <div class="uk-countdown-number uk-countdown-days"></div>
                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.days')</div>
                            </div>
                            <div class="uk-countdown-separator">:</div>
                            <div>
                                <div class="uk-countdown-number uk-countdown-hours"></div>
                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.hours')</div>
                            </div>
                            <div class="uk-countdown-separator">:</div>
                            <div>
                                <div class="uk-countdown-number uk-countdown-minutes"></div>
                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.minutes')</div>
                            </div>
                            <div class="uk-countdown-separator">:</div>
                            <div>
                                <div class="uk-countdown-number uk-countdown-seconds"></div>
                                <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.seconds')</div>
                            </div>
                        </div>
                        @else
                            <div class="uk-alert-danger uk-text-center" uk-alert>
                                <p>@lang('laralum_events::general.event_celebrated')</p>
                            </div>
                        @endif
                        <br><br>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-5@l uk-width-1-1@m"></div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $( function () {
            UIkit.countdown($('#countdown'));
        });

    </script>
@endsection
