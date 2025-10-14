@extends('Template::employer.layouts.master')
@section('content')
    <div class="company-profile-wrapper">
        <div class="card-item w-100 p-0">
            <div class="card-item__header list-header">
                <h5 class="card-item__title">{{ __($pageTitle) }}</h5>
                <div class=" list-content d-flex align-items-center gap-2 flex-wrap">
                    <form id="statusForm">
                        <select name="status" class="form--control select2" data-minimum-results-for-search="-1">
                            <option value="" selected>@lang('All')</option>
                            <option value="{{ Status::JOB_PENDING }}" @selected(Status::JOB_PENDING == request('status'))>
                                @lang('Pending')
                            </option>
                            <option value="{{ Status::JOB_APPROVED }}" @selected(Status::JOB_APPROVED == request('status'))>
                                @lang('Approved')
                            </option>
                            <option value="{{ Status::JOB_REJECTED }}" @selected(Status::JOB_REJECTED == request('status'))>
                                @lang('Reject')
                            </option>
                        </select>
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by job title" class="form--control form-control">
                            <button class="input-group-text"><i class="las la-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-item__inner p-0">
                @if ($jobs->count())
                    <table class="table table--responsive--lg border-0">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Created & Expired')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td>
                                        <div class="company flex-align">
                                            <div class="company__content w-100">
                                                <h6 class="company__name">{{ __($job->title) }}</h6>
                                                <ul class="text-list mb-0">
                                                    <li class="text-list__item">
                                                        <span class="text-list__icon text--info">
                                                            <i class="lar la-clock"></i>
                                                        </span>
                                                        {{ __(@$job->type->name) }}
                                                    </li>
                                                    <li class="text-list__item">
                                                        <span class="text-list__icon text--success">
                                                            <i class="las la-user-tie"></i>
                                                        </span>
                                                        {{ $job->total_apply }} @lang('Applications')
                                                    </li>
                                                    <li class="text-list__item">
                                                        <span class="text-list__icon text--secondary">
                                                            <i class="las la-bookmark"></i>
                                                        </span>
                                                        @lang('Favorites'): {{ $job->total_favorite }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ __(@$job->category->name) }}</td>
                                    <td>
                                        <div>
                                            <div class="text">{{ showDateTime($job->created_at, 'M d, Y') }}</div>
                                            <div class="text">{{ showDateTime($job->deadline, 'M d, Y') }}</div>
                                        </div>
                                    </td>
                                    <td>@php echo $job->statusBadge; @endphp</td>
                                    <td>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                @if (in_array($job->status, [Status::JOB_PENDING, Status::JOB_INCOMPLETE]))
                                                    <a href="{{ route('employer.job.edit', $job->id) }}" class="action-btn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="@lang('Edit')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($job->status == Status::JOB_REJECTED && $job->reject_reason)
                                                    <button class="action-btn rejectBtn" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="@lang('Reject Reason')"
                                                        data-reason="{{ __($job->reject_reason) }}">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @endif
                                                @if ($job->status == Status::JOB_APPROVED || $job->status == Status::JOB_EXPIRED)
                                                    <a href="{{ route('employer.job.applicants.all', $job->id) }}"
                                                        class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="@lang('Applicants')">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                @endif
                                                @if ($job->status != Status::JOB_EXPIRED && $job->status != Status::JOB_REJECTED)
                                                    @if ($job->featured)
                                                        <button
                                                            class="dropdown-item confirmationBtn btn-outline--success px-2 py-1 w-auto"
                                                            data-action="{{ route('employer.job.featured', $job->id) }}"
                                                            data-question="@lang('Are you sure to unfeatured this job?')">
                                                            <i class="las la-star-of-life"></i>
                                                            @lang('Unfeatured It')
                                                        </button>
                                                    @else
                                                        <button
                                                            class="dropdown-item confirmationBtn btn-outline--success px-2 py-1 w-auto"
                                                            data-action="{{ route('employer.job.featured', $job->id) }}"
                                                            data-question="@lang('Are you sure to featured this job?')">
                                                            <i class="las la-star-of-life"></i>
                                                            @lang('Featured It')
                                                        </button>
                                                    @endif
                                                @endif
                                                <a href="{{ route('employer.job.clone', $job->id) }}" class="action-btn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="@lang('Clone Job')" target="_blank">
                                                    <i class="fa-regular fa-copy"></i>
                                                </a>
                                                <a href="{{ route('employer.job.preview', $job->id) }}" class="action-btn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="@lang('Job Preview')" target="_blank">
                                                    <i class="fa-regular fa-eye"></i>
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
                        'message' => 'No job listings have been created yet.',
                    ])
                @endif
            </div>
            @if ($jobs->hasPages())
                <div class="card-item__footer">
                    {{ paginateLinks($jobs) }}
                </div>
            @endif
        </div>
    </div>



    <div class="modal fade custom--modal fade-in-scale" id="rejectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Reject Reason')</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="modal-form__title plan-confirm-text">
                        <span class="reason"></span>
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    {{-- <div class="modal fade custom--modal fade-in-scale" id="confirmationModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" class="confirmationForm">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title">@lang('Confirmation')</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="question-text mb-0"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger"
                            data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST" class="confirmationForm">
                    @csrf
                    <div class="modal-body">
                        <p class="question-text mb-0"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.select2').select2();

            $('.rejectBtn').on('click', function() {
                let modal = $('#rejectModal');
                modal.find('.reason').html($(this).data('reason'));
                modal.modal('show');
            })

            $('[name="status"]').on('change', function() {
                $('#statusForm').submit();
            });
        })(jQuery)
    </script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.select2').select2();

            $('.rejectBtn').on('click', function() {
                let modal = $('#rejectModal');
                modal.find('.reason').html($(this).data('reason'));
                modal.modal('show');
            });

            $('[name="status"]').on('change', function() {
                $('#statusForm').submit();
            });

            $('.confirmationBtn').on('click', function(e) {
                e.preventDefault();
                let action = $(this).data('action');
                let question = $(this).data('question');

                let modal = $('#confirmationModal');
                modal.find('.question-text').text(question);
                modal.find('form.confirmationForm').attr('action', action);
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .dropdown-item {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .dropdown-menu {
            padding: 0;
        }

        .btn-outline--success {
            --color: #28c76f;
            color: var(--color) !important;
            border: 1px solid var(--color) !important;
            border-radius: 3px;
            transition: all 0.3s ease-in-out;
        }

        .btn-outline--success:hover {
            background-color: var(--color) !important;
            color: #fff !important;
            transition: all 0.3s ease-in-out;
        }

        .btn--primary {
            --color: #4634ff;
            background-color: var(--color) !important;
            border: 1px solid var(--color) !important;
            color: white !important;
        }

        .btn--dark {
            --color: #10163a;
            background-color: var(--color) !important;
            border: 1px solid var(--color) !important;
            color: white !important;
        }
    </style>
@endpush

@push('style')
    <style>
        .company__content {
            padding-left: 0px;
        }

        .list-header .card-item__title {
            width: 200px;
            margin-bottom: 0;
        }

        .list-header {
            flex-wrap: nowrap !important;
            gap: 15px;
        }

        .list-header .list-content {
            width: calc(100% - 200px);
            justify-content: flex-end;
        }

        #statusForm select {
            flex-grow: 1;
            width: 100% !important;
        }

        #statusForm {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 500px;
        }

        @media (max-width:575px) {
            .list-header .list-content {
                width: 100%;
                justify-content: center;
            }

            .list-header .card-item__title {
                width: 100%;
            }

            #statusForm {
                max-width: 100%;
            }

            .list-header {
                flex-direction: column;
            }
        }

        @media (max-width:424px) {
            #statusForm {
                flex-direction: column;
            }
        }
    </style>
@endpush
