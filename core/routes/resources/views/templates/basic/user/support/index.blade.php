@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="table-wrapper">
        <div class="flex-between gap-2 table-wrapper-header">
            <h5 class="m-0">{{ __($pageTitle) }}</h5>
            <a href="{{ route('ticket.open') }}" class="btn btn--base emp-btn">
                <i class="las la-plus"></i> @lang('Open New Ticket')
            </a>
        </div>
        @if ($supports->count())
            <table class="table table--responsive--xl rounded-0">
                <thead>
                    <tr>
                        <th>@lang('Subject')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Priority')</th>
                        <th>@lang('Last Reply')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supports ?? [] as $support)
                        <tr>
                            <td>
                                <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold">
                                    [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                </a>
                            </td>
                            <td>@php echo $support->statusBadge; @endphp</td>
                            <td>@php echo $support->priorityBadge;@endphp</td>
                            <td>{{ diffForHumans($support->last_reply) }}</td>
                            <td>
                                <div class="action-btn-wrapper">
                                    <div class="action-buttons">
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="action-btn"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Details">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($supports->hasPages())
                <div class="mt-3">
                    {{ paginateLinks($supports) }}
                </div>
            @endif
        @else
            @include('Template::partials.empty', ['message' => 'Support ticket not found!'])
        @endif
    </div>
@endsection
