@extends('Template::employer.layouts.master')
@php
    if ($appliedJobs->count()) {
        $userAppliedJob = $userAppliedJob ?? @$appliedJobs[0];
        $user = @$userAppliedJob->user;
    }
@endphp
@section('content')
    <div class="container-fluid px-0">
        <div class="body-top">
            <div class="body-top__left">
                <h5 class="body-top__title">{{ __($job->title) }}</h5>
                <ul class="category-job-list">
                    <li class="category-job-list__item">
                        <span class="category-job-list__link">
                            @lang('Vacancy'): <span class="fw-bold"> {{ __($job->vacancy) }}</span>
                        </span>
                    </li>
                    @if ($appliedJobs->count())
                        <li class="category-job-list__item">
                            <span class="category-job-list__link">
                                @lang('Salary'):
                                <span class="salary-range">
                                    <span class="fw-bold">
                                        {{ $job->salary_amount }}
                                    </span>
                                </span>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="body-top__right">
                @if ($appliedJobs->count())
                    <a class="btn btn--base exportBtn" href="{{ route('employer.job.export', [$job->id, @$scope]) }}">
                        <span class="btn-icon"><i class="fas fa-file-export"></i></span>@lang('Export Applicants')
                    </a>
                @endif
            </div>
        </div>

        <ul class="nav nav-tabs tab--style">
            <li class="nav-item">
                <a class="nav-link {{ menuActive('employer.job.applicants.all') }}"
                    href="{{ route('employer.job.applicants.all', $job->id) }}">
                    @lang('All') ({{ $data['total_applicants'] }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ menuActive('employer.job.applicants.selected') }}"
                    href="{{ route('employer.job.applicants.selected', $job->id) }}">
                    @lang('Selected')
                    ({{ $data['total_approved'] }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ menuActive('employer.job.applicants.draft') }}"
                    href="{{ route('employer.job.applicants.draft', $job->id) }}">
                    @lang('Draft') ({{ $data['total_draft'] }})
                </a>
            </li>
        </ul>

        @if ($appliedJobs->count())
            <div class="company-category__wrapper">
                <div class="category-sidebar">
                    <h6 class="category-sidebar__title">@lang('Applicants')</h6>
                    <div class="header-search-box mb-4">
                        <input class="form--control" id="search" name="search" type="text" value=""
                            placeholder="@lang('Search Applicant')" autocomplete="off">
                        <button class="header-search-box__button" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="side_bar_applicant__list">
                        <div class="category-check-wrapper">
                            @foreach ($appliedJobs as $key => $appliedJob)
                                <div class="category-check-item profileViewBtn {{ $appliedJob->user_id == $user->id ? 'active' : '' }}"
                                    data-action="{{ route('employer.job.applicants.profile', [$appliedJob->user_id, $appliedJob->id]) }}"
                                    data-approve="{{ route('employer.job.application.approve', $appliedJob->id) }}"
                                    data-draft="{{ route('employer.job.application.draft', $appliedJob->id) }}"
                                    data-job_application="{{ $appliedJob }}">
                                    <div class="content">
                                        <div class="thumb">
                                            <img src="{{ getProfileImage(@$appliedJob->user->image) }}"
                                                alt="applicant-image">
                                        </div>
                                        <div>
                                            <p class="name">{{ @$appliedJob->user->fullname }}</p>
                                            <span class="label-text">
                                                @if (@$appliedJob->user->designation)
                                                    {{ __(@$appliedJob->user->designation) }}
                                                @else
                                                    @lang('Fresher')
                                                @endif
                                            </span>
                                            @if ($appliedJob->status == Status::JOB_APPLY_APPROVED)
                                                <span class="badge badge--success">@lang('Selected')</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="company-category__content profileContainer">
                    @include('Template::partials.applicant_profile', [
                        'user' => $user,
                        'userAppliedJob' => $userAppliedJob,
                    ])
                </div>
            </div>
        @else
            <div class="mt-5">
                @include('Template::partials.empty', ['message' => 'No applicant found'])
            </div>
        @endif
    </div>

    @include('Template::partials.modal.confirmation_modal')
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';

            $("[name=search]").on("input", function(e) {
                e.preventDefault();
                let searchValue = $(this).val().toLowerCase();

                let anyMatch = false;

                $.each($(".category-check-item"), function() {
                    let text = $(this).find(".name").text().toLowerCase();
                    if (text.includes(searchValue)) {
                        $(this).show();
                        anyMatch = true;
                    } else {
                        $(this).hide();
                    }
                });
            });

            $(document).ready(function() {
                function checkHeight() {
                    var $categoryWrapper = $('.category-check-wrapper');
                    if ($categoryWrapper.outerHeight() > 500) {
                        $categoryWrapper.css('padding-right', '10px');
                    } else {
                        $categoryWrapper.css('padding-right', '0px');
                    }
                }

                checkHeight();
                $(window).on('resize', checkHeight);
                $(document).on('DOMSubtreeModified', checkHeight);
            });

            let action = '';
            @if ($appliedJobs->count())
                let approveUrl = `{{ route('employer.job.application.approve', @$userAppliedJob->id) }}`;
                let draftUrl = `{{ route('employer.job.application.draft', @$userAppliedJob->id) }}`;
            @endif
            let modal = $('#customConfirmationModal');
            let jobApplication = '';

            $(document).on('click', '.approveBtn', function() {
                modal.find('form').attr('action', approveUrl);
                modal.find('.modalQuestion').text($(this).data('question'));
                modal.modal('show');
            });

            $(document).on('click', '.draftBtn', function() {
                modal.find('form').attr('action', draftUrl);
                modal.find('.modalQuestion').text($(this).data('question'));
                modal.modal('show');
            });

            $('.profileViewBtn').on('click', function() {
                action = $(this).data('action');
                approveUrl = $(this).data('approve');
                draftUrl = $(this).data('draft');
                $('.category-check-item').removeClass('active');
                $(this).closest('.category-check-item').addClass('active');
                jobApplication = $(this).data('job_application');
                $('.expected_salary').text(jobApplication.expected_salary);
                @if (request()->routeIs(['employer.job.applicants.all']))
                    if (jobApplication.status == 0) {
                        $('.approveBtn').removeClass('d-none');
                        $('.draftBtn').removeClass('d-none');
                    } else {
                        $('.approveBtn').addClass('d-none');
                        $('.draftBtn').addClass('d-none');
                    }
                @endif
                getApplicant();
            });

            function getApplicant() {
                $.ajax({
                    url: action,
                    type: 'GET',
                    success: function(response) {
                        $('.profileContainer').html(response.view);
                    },
                    error: function() {
                        alert('Failed to load profile. Please try again.');
                    }
                });
            }

            $('.filter-btn').on('click', function() {
                $(".responsive-filter-form").addClass("show");
            });
            $('.close-filter-btn').on('click', function() {
                $(".responsive-filter-form").removeClass('show');
            })
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .dashboard .header-search-box {
            position: relative;
        }

        .dashboard .header-search-box .form--control {
            -webkit-box-shadow: 0px 1px 2px 0px #1018280D;
            box-shadow: 0px 1px 2px 0px #1018280D;
            padding-left: 35px;
            border-radius: 8px;
        }

        .dashboard .header-search-box__button {
            position: absolute;
            left: 11px;
            top: 54%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            color: hsl(var(--text-color));
        }

        .category-check-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid hsl(var(--border-color));
            border-radius: 8px;
            cursor: pointer;
        }

        .category-check-item.active {
            background-color: #f6f7f9;
            border-color: hsl(var(--black) / .1);
        }

        .category-job-list__item:not(:last-child) {
            border-right: 1px solid hsl(var(--text-color)/.3);
            padding-right: 20px;
        }

        @media (max-width: 575px) {
            .category-job-list__item:not(:last-child) {
                padding-right: 10px
            }

            .category-job-list {
                gap: 10px;
            }

            .body-top {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 424px) {
            .category-job-list__link {
                font-size: 12px;
            }
        }

        .category-check-item.active .icon {
            background: hsl(var(--white)/0.5);
        }

        .category-check-item .content .label-text {
            font-size: 14px;
        }

        .side_bar_applicant__list {
            max-height: 500px;
            overflow-y: auto;
        }


        .side_bar_applicant__list::-webkit-scrollbar {
            width: 3px;
        }

        .side_bar_applicant__list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .side_bar_applicant__list::-webkit-scrollbar-thumb {
            background: hsl(var(--base) / .4);
            border-radius: 5px;
        }

        .category-check-wrapper {
            padding-right: 10px;
        }
    </style>
@endpush
