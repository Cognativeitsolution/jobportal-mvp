@extends('Template::layouts.master')
@php
    $profileSettingContent = getContent('user_profile_setting.content', true);
@endphp
@section('main-content')
    <div class="profile-dashboard my-120">
        <div class="container">
            <div class="d-xl-none d-block">
                <button class="profile-dashboard__body-icon">
                    <i class="fa-solid fa-list-ul"></i>
                </button>
            </div>
            <div class="profile-dashboard__header">
                <div class="profile-header-left">
                    <div class="account__header-thumb">
                        <div class="percent">
                            <svg>
                                <circle cx="60" cy="60" r="55"></circle>
                                <circle cx="60" cy="60" r="55"
                                    style="--percent: {{ $activeUser->profile_update_percent }}"></circle>
                            </svg>
                        </div>
                        <form action="{{ route('user.image.store') }}" method="POST" id="imageForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="file-upload">
                                <label class="edit" for="profile-image" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="@lang('Recommended'): {{ getFileSize('userProfile') }}px">
                                    <i class="las la-camera"></i>
                                </label>
                                <input type="file" name="image" class="form-control form--control" id="profile-image"
                                    hidden="" accept=".jpg, .jpeg, .png">
                            </div>
                        </form>
                        <div class="thumb">
                            <img src="{{ getProfileImage($activeUser->image) }}" alt="Profile Image">
                            <div class="percentag">
                                {{ $activeUser->profile_update_percent }}%
                            </div>
                        </div>
                    </div>
                    <div class="profile-header-left__content">
                        <div class="content-top  wow fadeInUp" data-wow-duration="2s">
                            <h4 class="name">
                                {{ $activeUser->fullname }}
                                <button class="edit-text" data-bs-toggle="modal" data-bs-target="#basicDetailModal">
                                    <i class="las la-pen"></i>
                                </button>
                            </h4>
                            <span class="text">
                                @lang('Last updated')
                                -
                                <span class="time">{{ showDateTime($activeUser->updated_at, 'd M, Y') }}</span>
                            </span>
                        </div>
                        <ul class="profile-info-list">
                            <li class="profile-info__item  wow fadeInUp" data-wow-duration="2s">
                                <span class="profile-info-list__link">
                                    <span class="icon"><i class="las la-map-marker-alt"></i></span>
                                    {{ __($activeUser->city) }}, {{ __($activeUser->country_name) }}
                                </span>
                            </li>
                            <li class="profile-info__item  wow fadeInUp" data-wow-duration="2s">
                                <span class="profile-info-list__link">
                                    <span class="icon"><i class="las la-phone"></i></span>
                                    {{ $activeUser->mobileNumber }}
                                </span>
                            </li>
                            <li class="profile-info__item  wow fadeInUp" data-wow-duration="2s">
                                <span class="profile-info-list__link">
                                    <span class="icon"><i class="las la-briefcase"></i></span>
                                    @if (!$activeUser->work_status)
                                        @lang('Update Work Status')
                                    @else
                                        {{ __($activeUser->workStatusValue) }}
                                    @endif

                                </span>
                            </li>
                            <li class="profile-info__item  wow fadeInUp" data-wow-duration="2s">
                                <span class="profile-info-list__link">
                                    <span class="icon"><i class="las la-paper-plane"></i></span>
                                    {{ $activeUser->email }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                @if (count($activeUser->profile_update_percent_list))
                    <div class="profile-header-right">
                        <ul class="details-list">
                            @php $count = 0; @endphp
                            @foreach ($activeUser->profile_update_percent_list ?? [] as $key => $value)
                                @php $count++; @endphp
                                @if ($count <= 3)
                                    <li class="details-list__item  wow fadeInUp" data-wow-duration="2s">
                                        <div class="details-list__link">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="icon"><i class="las la-long-arrow-alt-right"></i></span>
                                                <span class="text">{{ __(keyToTitle($key)) }}</span>
                                            </div>
                                            <span class="details-list__rate">
                                                <i class="las la-arrow-up"></i>
                                                {{ $value }}%
                                            </span>
                                            </duv>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="profile-header-right__btn  wow fadeInUp" data-wow-duration="2s">
                            <div class="profile-header-right__info pill">
                                @lang('Add') {{ $count }} @lang('missing details')
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="profile-dashboard-wrapper">
                <div class="profile-dashboard__sidebar">
                    <div class="d-xl-none d-block">
                        <span class="close-icon"> <i class="las la-times"></i> </span>
                    </div>
                    <h5 class="title  wow fadeInUp" data-wow-duration="2s">@lang('Quick Links')</h5>
                    <ul class="collection-list" id="portfolio-tab">
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading1" class="collection-list__link">
                                <span class="collection-list__text">@lang('Resume')</span>
                                @if (@$activeUser->profile_update_percent_list['resume'])
                                    <span class="collection-list__text-right">@lang('Upload')</span>
                                @endif
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading2" class="collection-list__link">
                                <span class="collection-list__text">@lang('Headline')</span>
                                @if (@$activeUser->profile_update_percent_list['resume_headline'])
                                    <span class="collection-list__text-right">@lang('Add')</span>
                                @endif
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading3" class="collection-list__link">
                                <span class="collection-list__text">@lang('Skills')</span>
                                @if (@$activeUser->profile_update_percent_list['skill'])
                                    <span class="collection-list__text-right">@lang('Add')</span>
                                @endif
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading4" class="collection-list__link">
                                <span class="collection-list__text">@lang('Employment')</span>
                                @if (@$activeUser->profile_update_percent_list['company_job_title'])
                                    <span class="collection-list__text-right">@lang('Add')</span>
                                @endif
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading5" class="collection-list__link">
                                <span class="collection-list__text">@lang('Education')</span>
                                @if (@$activeUser->profile_update_percent_list['education'])
                                    <span class="collection-list__text-right">@lang('Add')</span>
                                @endif
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading6" class="collection-list__link">
                                <span class="collection-list__text">@lang('IT Skills')</span>
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading7" class="collection-list__link">
                                <span class="collection-list__text">@lang('Projects')</span>
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading8" class="collection-list__link">
                                <span class="collection-list__text">@lang('Profile Summary')</span>
                                @if (@$activeUser->profile_update_percent_list['summary'])
                                    <span class="collection-list__text-right">@lang('Add')</span>
                                @endif
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading9" class="collection-list__link">
                                <span class="collection-list__text">@lang('Accomplishments')</span>
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading10" class="collection-list__link">
                                <span class="collection-list__text">@lang('Career')</span>
                            </a>
                        </li>
                        <li class="collection-list__item  wow fadeInUp" data-wow-duration="2s">
                            <a href="#scrollspyHeading11" class="collection-list__link">
                                <span class="collection-list__text">@lang('Personal Details')</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="main-body">
                    @include('Template::partials.user.resume')
                    @include('Template::partials.user.headline')
                    @include('Template::partials.user.skills')
                    @include('Template::partials.user.employment')
                    @include('Template::partials.user.education')
                    @include('Template::partials.user.it_skill')
                    @include('Template::partials.user.projects')
                    @include('Template::partials.user.profile_summary')
                    <div class="accomplishment-card">
                        <h6 class="accomplishment-card__title wow fadeInUp" data-wow-duration="2s">
                            @lang('Accomplishments')
                        </h6>
                        <p class="text wow fadeInUp" data-wow-duration="2s">
                            @lang('Showcase your credentials by adding relevant certifications, work samples, online profiles, etc.')
                        </p>
                    </div>
                    @include('Template::partials.user.online_profile')
                    @include('Template::partials.user.publication')
                    @include('Template::partials.user.presentation')
                    @include('Template::partials.user.patent')
                    @include('Template::partials.user.certification')

                    @include('Template::partials.user.career_profile')
                    @include('Template::partials.user.permanent_address')
                    @include('Template::partials.user.present_address')
                    @include('Template::partials.user.personal_details')
                    @include('Template::partials.user.language')
                </div>
            </div>
        </div>
    </div>

    @include('Template::partials.modal.user.basic_information_modal')
    @include('Template::partials.modal.confirmation_modal')
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.select2').select2();

            $('[name="image"]').on('change', function() {
                $('#imageForm').submit();
            });

            $.each($('.select2-auto-tokenize'), function() {
                $(this)
                    .wrap(`<div class="position-relative"></div>`)
                    .select2({
                        tags: true,
                        tokenSeparators: [','],
                        dropdownParent: $(this).parent()
                    });
            });

            $('.date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD',
                },
                minYear: 1901,
                maxDate: moment()
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .select2-container--default .select2-selection--multiple {
            border-color: #e5e5e5 !important;
        }

        .custom--modal .modal-form__title {
            font-size: 14px;
            font-weight: 400;
            line-height: 120%;
            margin-bottom: 12px;
        }

        .plan-confirm-text {
            border-radius: 8px;
            margin: 0 auto;
            border-left: 2px solid hsl(var(--base));
            padding: 10px;
            text-align: left !important;
            background: hsl(var(--base) / 0.08);
            margin-bottom: 16px;
            font-weight: 400;
        }

        .custom--modal .modal-form__title span {
            color: hsl(var(--base));
            line-height: 1.5;
        }

        .profile-header-right__info {
            color: hsl(var(--white)) !important;
            font-weight: 500;
            padding: 13px 24px;
            border-radius: 40px;
            position: relative;
            z-index: 1;
            border: 1px solid transparent;
            font-family: var(--body-font);
            font-size: 1rem;
            line-height: 1;
            background-color: hsl(var(--danger)) !important;
            margin-top: 15px;
        }
    </style>
@endpush
