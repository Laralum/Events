@extends('laralum::layouts.master')
@section('icon', 'ion-calendar')
@section('title', __('laralum_events::general.events_list'))
@section('subtitle', __('laralum_events::general.events_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><span>@lang('laralum_events::general.events_list')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid class="uk-child-width-1-1">
            <div>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('laralum_events::general.events_list')
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-overflow-auto">
                            <table class="uk-table uk-table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('laralum_events::general.title')</th>
                                        <th>@lang('laralum_events::general.status')</th>
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
                                            <td><span class="uk-label {{ ($event->public) ? "uk-label-success" : "uk-label-warning" }}">{{($event->public) ? __('laralum_events::general.published') : __('laralum_events::general.unpublished') }}</span></td>

                                            <td>{{ $event->creator->name }}</td>
                                            <td>{{ $event->users->count() }}</td>
                                            <td class="uk-table-shrink">
                                                <div class="uk-button-group">
                                                    <a class="uk-button uk-button-default uk-button-small" href="{{ route('laralum::events.show', ['id' => $event->id]) }}">
                                                        @lang('laralum_events::general.view')
                                                    </a>
                                                    @can('update', $event)
                                                        <a class="uk-button uk-button-default uk-button-small" href="{{ route('laralum::events.edit', ['id' => $event->id]) }}">
                                                            @lang('laralum_events::general.edit')
                                                        </a>
                                                    @else
                                                        <button disabled class="uk-button uk-button-default uk-button-small">
                                                            @lang('laralum_events::general.update')
                                                        </button>
                                                    @endcan
                                                    @can('join', $event)
                                                        @if ($event->hasUser(Auth::user()))
                                                            <form id="leave-form-{{ $event->id }}" action="{{ route('laralum::events.leave', ['id' => $event->id]) }}" method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                            <a class="uk-button uk-button-default uk-button-small" onclick="event.preventDefault(); document.getElementById('leave-form-{{$event->id}}').submit();">
                                                                @lang('laralum_events::general.leave')
                                                            </a>
                                                        @else
                                                            <form id="join-form-{{ $event->id }}" action="{{ route('laralum::events.join', ['id' => $event->id]) }}" method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                            <a class="uk-button uk-button-default uk-button-small" onclick="event.preventDefault(); document.getElementById('join-form-{{$event->id}}').submit();">
                                                                @lang('laralum_events::general.join')
                                                            </a>
                                                        @endif
                                                    @else
                                                        <button disabled class="uk-button uk-button-default uk-button-small">
                                                            @lang('laralum_events::general.join')
                                                        </button>
                                                    @endcan
                                                    @can('delete', $event)
                                                        <a class="uk-button uk-button-small uk-button-danger" href="{{ route('laralum::events.destroy.confirm', ['id' => $event->id]) }}">
                                                            @lang('laralum_events::general.delete')
                                                        </a>
                                                    @else
                                                        <button disabled class="uk-button uk-button-small uk-button-danger">
                                                            @lang('laralum_events::general.delete')
                                                        </button>
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
                        </div>
                        {{ $events->links('laralum::layouts.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
