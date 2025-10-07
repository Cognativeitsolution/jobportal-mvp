@extends('Template::employer.layouts.master')
@section('content')
    <div class="company-profile-wrapper">
        <div class="card-item w-100 p-0">
            <div class="card-item__header list-header">
                <h6 class="card-item__title">{{ __($pageTitle) }}</h6>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('employer.ticket.open') }}" class="btn btn--md btn--base">
                        <i class="las la-plus"></i> @lang('New Ticket')
                    </a>
                </div>
            </div>
            <div class="card-item__inner p-0">
                @if ($supports->count())
                    <table class="table table--responsive--lg border-0">
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
                            @foreach ($supports as $support)
                                <tr>
                                    <td>
                                        <a href="{{ route('employer.ticket.view', $support->ticket) }}" class="fw-bold">
                                            [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                        </a>
                                    </td>
                                    <td>@php echo $support->statusBadge; @endphp </td>
                                    <td>@php echo $support->priorityBadge;@endphp</td>
                                    <td>{{ diffForHumans($support->last_reply) }}</td>
                                    <td>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                <a href="{{ route('employer.ticket.view', $support->ticket) }}"
                                                   class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-title="@lang('Details')">
                                                    <i class="la-lg las la-desktop"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @include('Template::partials.empty', [
                        'message' => 'No tickets found.',
                    ])
                @endif
            </div>
            @if ($supports->hasPages())
                <div class="card-item__footer">
                    {{ paginateLinks($supports) }}
                </div>
            @endif
        </div>
    </div>
@endsection
