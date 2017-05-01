@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('laralum_event::general.create_event'))
@section('subtitle', __('laralum_event::general.create_event_desc'))
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
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
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
                                    <label class="uk-form-label">@lang('laralum_events::general.color')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('color') }}" name="color" class="uk-input" type="text" placeholder="@lang('laralum_events::general.color_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.description')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('description') }}" name="description" class="uk-input" type="text" placeholder="@lang('laralum_events::general.description_ph')">
                                    </div>
                                </div>

                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_events::general.price')</label>
                                    <div class="uk-form-controls">
                                        <input value="" name="price" class="uk-input" type="number" placeholder="@lang('laralum_events::general.title_ph')">
                                    </div>
                                </div>


                                <div class="uk-margin uk-grid-small uk-child-width-auto" uk-grid>
                                    <label><input class="uk-checkbox" type="checkbox" name="public" {{ old('public') }}> @lang('laralum_events::general.public')</label>
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
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
        </div>
    </div>
@endsection
