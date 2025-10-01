@extends('admin.layouts.app')
@section('panel')
    <div class="job-details-container">
        <div class="row gy-4">
            <div class="col-xxl-3 col-xl-4">
                <div class="sticky-style">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="company-info">
                                <div class="company-info-wrapper">
                                    <div class="company-info-thumb">
                                        <img src="{{ getImage(getFilePath('employer') . '/' . @$job->employer->image, getFileSize('employer')) }}"
                                             alt="employer logo">
                                    </div>
                                    <div class="company-info-content">
                                        <p class="company-info-item">
                                            <span class="title">@lang('Company') </span>
                                            <span class="divide">:</span>
                                            {{ __(@$job->employer->company_name) }}
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Username')</span>
                                            <span class="divide">:</span>
                                            <a href="{{ route('admin.employers.detail', @$job->employer_id) }}">
                                                <span>@</span>{{ @$job->employer->username }}
                                            </a>
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Email')</span>
                                            <span class="divide">:</span>
                                            <a href="mailto:{{ @$job->employer->email }}">
                                                {{ @$job->employer->email }}
                                            </a>
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Mobile')</span>
                                            <span class="divide">:</span>
                                            <a href="tel:{{ @$job->employer->mobileNumber }}">
                                                {{ @$job->employer->mobileNumber }}
                                            </a>
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Industry')</span>
                                            <span class="divide">:</span>
                                            {{ __(@$job->employer->industry->name) }}
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Website')</span>
                                            <span class="divide">:</span>
                                            <a href="{{ @$job->employer->website }}" target="_blank">
                                                {{ @$job->employer->website }}
                                            </a>
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('City')</span>
                                            <span class="divide">:</span>
                                            {{ __(@$job->employer->city) }}
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Country')</span>
                                            <span class="divide">:</span>
                                            {{ __(@$job->employer->country_name) }}
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Founded')</span>
                                            <span class="divide">:</span>
                                            {{ showDateTime(@$job->employer->founding_date, 'd M, Y') }}
                                        </p>
                                        <p class="company-info-item">
                                            <span class="title">@lang('Employees')</span>
                                            <span class="divide">:</span>
                                            {{ __(@$job->employer->numberOfEmployee->employees) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $jobPayment = true;
                        if ($job->deposit_id && $job->deposit->status == Status::PAYMENT_PENDING) {
                            $jobPayment = false;
                        }
                    @endphp
                    @if ($job->status == Status::JOB_PENDING && $jobPayment)
                        <div class="card custom--card mt-4">
                            <div class="card-body">
                                <h5 class="mb-4">@lang('Take Action')</h5>
                                <div class="d-flex align-items-center flex-wrap gap-3">
                                    <button class="btn btn-outline--primary btn-lg flex-grow-1 confirmationBtn"
                                            data-action="{{ route('admin.jobs.approve', $job->id) }}"
                                            data-question="@lang('Are you sure to approve this job?')">
                                        <i class="las la-check"></i> @lang('Approve')
                                    </button>
                                    <button class="btn btn-outline--danger btn-lg flex-grow-1 rejectBtn"
                                            data-action="{{ route('admin.jobs.reject', $job->id) }}"
                                            data-question="@lang('Are you sure to reject this job?')">
                                        <i class="las la-ban"></i> @lang('Reject')
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xxl-9 col-xl-8">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="job-post-top">
                            <h3 class="mb-3">{{ __($job->title) }}</h3>
                            <ul class="job-post-list mb-2">
                                <li>
                                    <span>@lang('Category'):</span>
                                    <span class="fw-bold">{{ __(@$job->category->name) }}</span>
                                </li>
                                <li>
                                    <span>@lang('Role'):</span>
                                    <span class="fw-bold">{{ __(@$job->role->name) }}</span>
                                </li>
                                <li>
                                    <span>@lang('Vacancy'):</span>
                                    <span class="fw-bold">{{ __($job->vacancy) }}</span>
                                </li>
                                <li>
                                    <span>@lang('Deadline'):</span>
                                    <span class="fw-bold">{{ showDateTime($job->deadline, 'd M Y') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="job-details">
                            <h4 class="mb-3">@lang('Job Information')</h4>
                            <p class="job-details-item">
                                <span class="title">@lang('Job Type')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->type->name) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Job Location Type')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->jobLocationName()) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Location')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->city->name) }}, {{ __(@$job->location->name) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Experience')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->experience->name) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Gender')</span>
                                <span class="divide">:</span>
                                {{ @$job->getGender() }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Shift')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->shift->name) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Salary Period')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->salaryPeriod->name) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Salary')</span>
                                <span class="divide">:</span>
                                @if ($job->salary_type == 1)
                                    @lang('Negotiation')
                                @elseif($job->salary_type == 2)
                                    {{ showAmount($job->salary_from) }} - {{ showAmount($job->salary_to) }}
                                @endif
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Age Limit')</span>
                                <span class="divide">:</span>
                                {{ @$job->min_age }} @lang('years to') {{ @$job->max_age }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Skills')</span>
                                <span class="divide">:</span>
                                @foreach ($job->skills ?? [] as $skill)
                                    {{ __($skill) }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Short Description')</span>
                                <span class="divide">:</span>
                                {{ __(@$job->short_description) }}
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Keywords')</span>
                                <span class="divide">:</span>
                                @foreach ($job->jobKeywords ?? [] as $keyword)
                                    {{ __($keyword->keyword) }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                            <p class="job-details-item">
                                <span class="title">@lang('Status'):</span>
                                <span class="divide">:</span>
                                @php echo $job->statusBadge; @endphp
                            </p>
                        </div>

                        <h4 class="mb-3">@lang('Job Description')</h4>
                        <p>@php echo $job->description; @endphp</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Reason')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <h6 class="question mb-3"></h6>
                        <div class="form-group">
                            <label>@lang('Reject Reason')</label>
                            <textarea name="reject_reason" class="form-control" rows="4" required>{{ old('reject_reason') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.jobs.index') }}" />
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.rejectBtn').on('click', function() {
                let modal = $('#rejectModal');
                modal.find('form').attr('action', $(this).data('action'));
                modal.find('.question').text($(this).data('question'));
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        :root {
            --border-color: #e8e9e9;
        }

        .sticky-style {
            position: sticky;
            top: 20px;
        }

        .job-post-top,
        .job-details {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .company-info-wrapper {
            display: flex;
            gap: 16px;
            flex-direction: column;
        }

        .company-info-thumb {
            max-width: 100px;
            width: 100%;
            border: 1px solid rgb(0 0 0 / 6%);
            border-radius: 6px;
        }

        .company-info-thumb img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .company-info-item,
        .job-details-item {
            display: flex;
            color: rgb(0, 0, 0, 60%);
            gap: 12px;
        }

        .job-details-item:not(:last-child) {
            margin-bottom: 8px;
        }

        @media (max-width: 1199px) {
            .sticky-style {
                position: unset !important;
            }
        }

        @media (max-width: 424px) {
            .job-details-item {
                flex-direction: column;
                gap: 0px;
            }

            .job-details-item .divide {
                display: none;
            }

            .job-details-item:not(:last-child) {
                margin-bottom: 12px;
            }
        }


        .company-info-item .title,
        .job-details-item .title {
            min-width: 80px;
            font-weight: 500;
            color: rgb(0, 0, 0, 100%);
        }

        .job-details-item .title {
            min-width: 150px;
        }

        .badge {
            line-height: 1.5 !important;
        }

        .job-post-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px 0;
        }

        .job-post-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            line-height: .9;
        }

        .job-post-list li:not(:last-child) {
            margin-right: 12px;
            padding-right: 12px;
            border-right: 1px solid #ccc;
        }

        .job-post-list li>span {
            font-weight: 400;
        }

        .company-info-content {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
@endpush
