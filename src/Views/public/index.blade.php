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
        <h1>@lang('laralum_events::general.events_list')</h1>
        <table>
            <a href="{{ route('laralum_public::events.create') }}"><b>@lang('laralum_events::general.create_event')</b></a>
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('laralum_events::general.title')</th>
                    <th>@lang('laralum_events::general.author')</th>
                    <th>@lang('laralum_events::general.users')</th>
                    <th>@lang('laralum_events::general.actions')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td style="color:{{ $event->color }}">{{ $event->title }}</td>
                        <td>{{ $event->creator->name }}</td>
                        <td>{{ $event->users->count() }}</td>
                        <td>
                            <div>
                                <a href="{{ route('laralum_public::events.show', ['event' => $event->id]) }}">
                                    @lang('laralum_events::general.view')
                                </a>
                                @can('update', $event)
                                    <a href="{{ route('laralum_public::events.edit', ['event' => $event->id]) }}">
                                        @lang('laralum_events::general.edit')
                                    </a>
                                @endcan
                                @can('join', $event)
                                    @if ($event->hasUser(Auth::user()))
                                        <form id="leave-form-{{$event->id}}" action="{{ route('laralum_public::events.leave', ['id' => $event->id]) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <a class="uk-button uk-button-default uk-button-small" onclick="event.preventDefault(); document.getElementById('leave-form-{{$event->id}}').submit();">
                                            @lang('laralum_events::general.leave')
                                        </a>
                                    @else
                                        <form id="join-form-{{$event->id}}" action="{{ route('laralum_public::events.join', ['id' => $event->id]) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <a onclick="event.preventDefault(); document.getElementById('join-form-{{$event->id}}').submit();">
                                            @lang('laralum_events::general.join')
                                        </a>
                                    @endif
                                @endcan
                                @can('delete', $event)
                                    <form id="delete-form-{{$event->id}}" action="{{ route('laralum_public::events.destroy', ['id' => $event->id]) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <a onclick="event.preventDefault(); document.getElementById('delete-form-{{$event->id}}').submit();">
                                        @lang('laralum_events::general.delete')
                                    </a>

                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </body>
</html>
