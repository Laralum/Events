@php
    $settings = \Laralum\Events\Models\Settings::first();
@endphp
@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('laralum_events::general.create_event'))
@section('subtitle', __('laralum_events::general.create_event_desc'))
@section('css')
    <link rel="stylesheet" href="https://gitcdn.xyz/cdn/Laralum/Events/7012bae7372a1e9a670b6f2ac1364b94c77245fb/src/Assets/laralum-date.css">
    <link rel="stylesheet" type="text/css" href="https://gitcdn.xyz/cdn/24aitor/Datedropper3/2da8e76e9646141710b48acce0757b6ab6f29354/datedropper.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/timedropper/1.0/timedropper.css">
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><a href="{{ route('laralum::events.index') }}">@lang('laralum_events::general.events_list')</a></li>
        <li><span>@lang('laralum_events::general.create_event')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ __('laralum_events::general.create_event') }}
                    </div>
                    <div class="uk-card-body">
                        <form class="uk-form-stacked" method="POST" action="{{ route('laralum::events.store') }}">
                            {{ csrf_field() }}
                            <fieldset class="uk-fieldset">


                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.title')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('title') }}" name="title" class="uk-input" type="text" placeholder="@lang('laralum_events::general.title_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.start_date')</label>
                                    <div class="uk-form-controls">
                                        <input id="start_date" value="{{ old('start_date') }}" name="start_date" class="uk-input" type="text" data-large-mode="true" data-large-default="true" data-init-set="false" data-theme="laralum-date" data-format="Y-m-d" data-lang="{{ App::getLocale() }}" placeholder="@lang('laralum_events::general.start_date_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.start_time')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('start_time', "00:00") }}" id="start_time" name="start_time" class="uk-input" type="text" placeholder="@lang('laralum_events::general.start_time_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.end_date')</label>
                                    <div class="uk-form-controls">
                                        <input id="end_date" value="{{ old('end_date') }}" name="end_date" class="uk-input" type="text" data-large-mode="true" data-large-default="true" data-init-set="false" data-theme="laralum-date" data-format="Y-m-d" data-lang="{{ App::getLocale() }}" placeholder="@lang('laralum_events::general.end_date_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.end_time')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('end_time', "00:00") }}" id="end_time" name="end_time" class="uk-input" type="text" placeholder="@lang('laralum_events::general.end_time_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.color')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('color') }}" id="color" name="color" class="uk-input" type="text" placeholder="@lang('laralum_events::general.color_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.place')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('place') }}" name="place" class="uk-input" type="text" placeholder="@lang('laralum_events::general.place_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.description')</label>
                                        @php
                                        $text = old('description');
                                        if ($settings->text_editor == 'markdown') {
                                            $converter = new League\HTMLToMarkdown\HtmlConverter();
                                            $text = $converter->convert($text);
                                        }
                                        @endphp
                                        <textarea name="description" class="uk-textarea" rows="15" placeholder="{{ __('laralum_events::general.description_ph') }}">{{ $text }}</textarea>
                                        @if ($settings->text_editor == 'markdown')
                                            <i>@lang('laralum_events::general.markdown')</i>
                                        @else
                                            <i>@lang('laralum_events::general.plain_text')</i>
                                        @endif
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.price')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('price') }}" name="price" class="uk-input" type="number" step="0.01" placeholder="@lang('laralum_events::general.price_ph')">
                                    </div>
                                </div>


                                <div class="uk-margin uk-grid-small uk-child-width-auto" uk-grid>
                                    <label><input class="uk-checkbox" type="checkbox" name="public" @can('publish', \Laralum\Events\Models\Event::class) {{ !old('public') ?: 'checked'}} @else disabled @endif> @lang('laralum_events::general.public')</label>
                                </div>

                                <div class="uk-margin">
                                    <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                        <span class="ion-forward"></span>&nbsp; {{ __('laralum_events::general.create_event') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-3-5@l"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://gitcdn.xyz/cdn/24aitor/Datedropper3/2da8e76e9646141710b48acce0757b6ab6f29354/datedropper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timedropper/1.0/timedropper.js"></script>

    <script>
        $( "#start_date" ).dateDropper();
        $( "#end_date" ).dateDropper();
        $( "#start_time" ).timeDropper({'format':'HH:mm', 'setCurrentTime':false});
        $( "#end_time" ).timeDropper({'format':'HH:mm', 'setCurrentTime':false});
    </script>

    <script>
        $("#color").keyup(function(){
            $("#color").css({"color":$(this).val()});
        });
    </script>
@endsection
