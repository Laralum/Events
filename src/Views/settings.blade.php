@php
    $settings = \Laralum\Events\Models\Settings::first();
@endphp
<div uk-grid>
    @can('update', \Laralum\Events\Models\Settings::class)
    <div class="uk-width-1-1@s uk-width-1-5@l"></div>
    <div class="uk-width-1-1@s uk-width-3-5@l">
        <form class="uk-form-horizontal" method="POST" action="{{ route('laralum::events.settings.update') }}">
            {{ csrf_field() }}
            <fieldset class="uk-fieldset">

            <div class="uk-margin">
                <label class="uk-form-label">@lang('laralum_events::general.text_editor')</label>
                <div class="uk-form-controls">
                    <select name="text_editor" class="uk-select">
                        <option value="" @if(!$settings->text_editor) selected @endif disabled>@lang('laralum_events::general.select_editor')</option>
                        <option @if($settings->text_editor == 'plain-text') selected @endif value="plain-text">@lang('laralum_events::general.plain_text')</option>
                        <option @if($settings->text_editor == 'markdown') selected @endif value="markdown">@lang('laralum_events::general.markdown')</option>
                    </select>
                    <small class="uk-text-meta">@lang('laralum_events::general.text_editor_desc')</small>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">@lang('laralum_events::general.public_url')</label>
                <div class="uk-form-controls">
                    <input value="{{ old('navbar_color', $settings->public_url) }}" name="public_url" class="uk-input" type="text" placeholder="@lang('laralum_events::general.public_url')">
                    <small class="uk-text-meta">@lang('laralum_events::general.public_url')</small>
                </div>
            </div>

                <div class="uk-margin uk-align-right">
                    <button type="submit" class="uk-button uk-button-primary">
                        <span class="ion-forward"></span>&nbsp; @lang('laralum_events::general.save_settings')
                    </button>
                </div>

            </fieldset>
        </form>
    </div>
    <div class="uk-width-1-1@s uk-width-1-5@l"></div>
    @else
        <div class="uk-width-1-1">
            <div class="content-background">
                <div class="uk-section uk-section-small uk-section-default">
                    <div class="uk-container uk-text-center">
                        <h3>
                            <span class="ion-minus-circled"></span>
                            @lang('laralum_events::general.unauthorized_action')
                        </h3>
                        <p>
                            @lang('laralum_events::general.unauthorized_desc')
                        </p>
                        <p class="uk-text-meta">
                            @lang('laralum_events::general.contact_webmaster')
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
