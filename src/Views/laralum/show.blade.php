@extends('laralum::layouts.master')
@section('icon', 'ion-calendar')
@section('title', $event->title)
@section('subtitle', __('laralum_events::general.events_desc', ['event_id' => $event->id]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><a href="{{ route('laralum::events.index') }}">@lang('laralum_events::general.events_list')</a></li>
        <li><span>{{ $event->title }}</span></li>
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
                        <div class="uk-text-lead uk-text-center uk-margin-medium-bottom">
                            @if($start_datetime->isFuture())
                            @lang('laralum_events::general.time_left_starts')
                            @elseif ($end_datetime->isFuture())
                            @lang('laralum_events::general.time_left_ends')
                            @else
                            @lang('laralum_events::general.you_were_late')
                            @endif
                        </div>
                        @if($end_datetime->isFuture())

                        <div id="countdown" class="uk-grid-small uk-child-width-auto uk-text-center uk-flex-center sticky {{ ($start_datetime->isPast()) ? 'uk-text-primary' : 'uk-text-success' }}" uk-grid uk-countdown="date: {{ $start_datetime->isFuture() ? $start_datetime->toAtomString() : $end_datetime->toAtomString() }}">
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
                        <br>
                        <hr class="uk-divider-icon">
                        <dl class="uk-description-list uk-description-list-divider">
                            <dt>@lang('laralum_events::general.description')</dt>
                            <dd class="uk-margin-small-top">{{ $event->description }}</dd>
                            <dt>@lang('laralum_events::general.duration')</dt>
                            <dd class="uk-margin-small-top">{{ $end_datetime->diffForHumans($start_datetime, true) }}</dd>
                            <dt>@lang('laralum_events::general.place')</dt>
                            <dd class="uk-margin-small-top">{{ $event->place }}</dd>
                            <dt>@lang('laralum_events::general.status')</dt>
                            <dd class="uk-margin-small-top">
                                @if ($event->public)
                                <span class="uk-label uk-label-success">@lang('laralum_events::general.published')</span>
                                @else
                                <span class="uk-label uk-label-warning">@lang('laralum_events::general.unpublished')</span>
                                @endif
                            </dd>
                            <dt>@lang('laralum_events::general.start_date')</dt>
                            <dd class="uk-margin-small-top">{{ $start_datetime->toCookieString() }}</dd>
                            <dt>@lang('laralum_events::general.end_date')</dt>
                            <dd class="uk-margin-small-top">{{ $end_datetime->toCookieString() }}</dd>
                        </dl>
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
