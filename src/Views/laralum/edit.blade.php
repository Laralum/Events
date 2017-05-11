@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('laralum_events::general.edit_event'))
@section('subtitle', __('laralum_events::general.edit_event_desc'))
@section('css')
    <link rel="stylesheet" href="https://gitcdn.xyz/cdn/Laralum/Events/7012bae7372a1e9a670b6f2ac1364b94c77245fb/src/Assets/laralum-date.css">
    <link rel="stylesheet" type="text/css" href="https://gitcdn.xyz/cdn/felicegattuso/Datedropper3/60df15d8f657f50b059972bb1c4061f91c1976b8/datedropper.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/timedropper/1.0/timedropper.css">
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><a href="{{ route('laralum::events.index') }}">@lang('laralum_events::general.events_list')</a></li>
        <li><span>@lang('laralum_events::general.edit_event')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ __('laralum_events::general.edit_event') }}
                    </div>
                    <div class="uk-card-body">
                        <form class="uk-form-stacked" method="POST" action="{{ route('laralum::events.update', ['event' => $event]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <fieldset class="uk-fieldset">

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.title')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('title', $event->title) }}" name="title" class="uk-input" type="text" placeholder="@lang('laralum_events::general.title_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.date')</label>
                                    <div class="uk-form-controls">
                                        <input id="date" value="{{ old('date', $event->date) }}" name="date" class="uk-input" type="text" data-large-mode="true" data-large-default="true" data-init-set="false" data-theme="laralum-date" data-format="Y-m-d" data-lang="{{ App::getLocale() }}" placeholder="@lang('laralum_events::general.date_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.time')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('time', $event->time) }}" id="time" name="time" class="uk-input" type="text" placeholder="@lang('laralum_events::general.time_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.color')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('color', $event->color) }}" name="color" class="uk-input" type="text" placeholder="@lang('laralum_events::general.color_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.description')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('description', $event->description) }}" name="description" class="uk-input" type="text" placeholder="@lang('laralum_events::general.description_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.price')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('price', $event->price) }}" name="price" class="uk-input" type="number" step="0.01" placeholder="@lang('laralum_events::general.price_ph')">
                                    </div>
                                </div>


                                <div class="uk-margin uk-grid-small uk-child-width-auto" uk-grid>
                                    <label><input class="uk-checkbox" type="checkbox" name="public" {{ old('public', $event->time) ?:'disabled' }}> @lang('laralum_events::general.public')</label>
                                </div>

                                <div class="uk-margin">
                                    <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                        <span class="ion-forward"></span>&nbsp; {{ __('laralum_events::general.edit_event') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://gitcdn.xyz/cdn/24aitor/Datedropper3/2da8e76e9646141710b48acce0757b6ab6f29354/datedropper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timedropper/1.0/timedropper.js"></script>

    <script>
    $( "#date" ).dateDropper();
    $( "#time" ).timeDropper({'format':'HH:mm', 'setCurrentTime':false});
    </script>
@endsection
