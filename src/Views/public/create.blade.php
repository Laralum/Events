@php
    $settings = \Laralum\Events\Models\Settings::first();
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_events::general.events_list') - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
        <link rel="stylesheet" href="{{ \Laralum\Laralum\Packages::css() }}">
    </head>
    <body>
        <h1>@lang('laralum_events::general.create_event')</h1>
        @if(Session::has('success'))
            <hr>
            <p style="color:green">
                {{Session::get('success')}}
            </p>
            <hr>
        @endif
        @if(Session::has('info'))
            <hr>
            <p style="color:blue">
                {{Session::get('info')}}
            </p>
            <hr>
        @endif
        @if(Session::has('error'))
            <hr>
            <p style="color:red">
                {{Session::get('error')}}
            </p>
            <hr>
        @endif
        @if(count($errors->all()))
            <hr>
            <p style="color:red">
                @foreach($errors->all() as $error) {{$error}}<br/>@endforeach
            </p>
            <hr>
        @endif
        <form  method="POST" action="{{ route('laralum_public::events.store') }}">
            {{ csrf_field() }}

            <label>@lang('laralum_events::general.title')</label>
            <input value="{{ old('title') }}" name="title" type="text" placeholder="@lang('laralum_events::general.title_ph')">

            <label>@lang('laralum_events::general.start_date')</label>
            <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="date"  placeholder="@lang('laralum_events::general.start_date_ph')">

            <label>@lang('laralum_events::general.start_time')</label>
            <input value="{{ old('start_time') }}" id="start_time" name="start_time" type="time" placeholder="@lang('laralum_events::general.start_time_ph')">

            <label>@lang('laralum_events::general.end_date')</label>
            <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="date" placeholder="@lang('laralum_events::general.end_date_ph')">

            <label>@lang('laralum_events::general.end_time')</label>
            <input value="{{ old('end_time') }}" id="end_time" name="end_time" type="time" placeholder="@lang('laralum_events::general.end_time_ph')">

            <label>@lang('laralum_events::general.color')</label>
            <input value="{{ old('color') }}" id="color" name="color" type="text" placeholder="@lang('laralum_events::general.color_ph')">

            <label>@lang('laralum_events::general.place')</label>
            <input value="{{ old('place') }}" name="place" type="text" placeholder="@lang('laralum_events::general.place_ph')">
            @php
            $text = old('description');
            if ($settings->text_editor == 'markdown') {
                $converter = new League\HTMLToMarkdown\HtmlConverter();
                $text = $converter->convert($text);
            }
            @endphp
            <label>@lang('laralum_events::general.description')</label>
            <textarea name="description" rows="15" placeholder="{{ __('laralum_events::general.description_ph') }}">{{ $text }}</textarea>
            @if ($settings->text_editor == 'markdown')
                <i>@lang('laralum_events::general.markdown')</i>
            @else
                <i>@lang('laralum_events::general.plain_text')</i>
            @endif
            <br><br>
            <label>@lang('laralum_events::general.price')</label>
            <input value="{{ old('price') }}" name="price" type="number" step="0.01" placeholder="@lang('laralum_events::general.price_ph')">

            <input type="checkbox" name="public" {{ !old('public') ?: 'checked'}} @cannot('publish', \Laralum\Events\Models\Event::class) disabled @endcannot><label>@lang('laralum_events::general.public')</label>
            <br><br><br>

            <button type="submit">
                @lang('laralum_events::general.create_event')
            </button>
        </form>
    </body>
</html>
