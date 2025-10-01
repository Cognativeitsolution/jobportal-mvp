@extends('Template::layouts.frontend')
@php
    $jobStatus = session()->has('JOB_STATUS') ? session()->get('JOB_STATUS') : false;
    session()->forget('JOB_STATUS');
@endphp
@section('content')
    <div class="candidate-profile-section my-120">
        <div class="container">
            <div class="company-details-wrapper">
                <div class="profile-wrapper">
                    <div class="profile mb-5">
                        <div class="profile__thumb">
                            <img src="{{ getProfileImage(@$employer->image, 'employer') }}" alt="company-image">
                        </div>
                        <div class="profile-content">
                            <div>
                                <h5 class="profile-content__name">
                                    {{ __(@$employer->company_name) }}
                                </h5>
                                <ul class="text-list mb-0">
                                    <li class="text-list__item">
                                        <span class="text-list__icon"><i class="las la-industry"></i></span>
                                        {{ __(@$employer->industry->name) }}
                                    </li>
                                    <li class="text-list__item">
                                        <span class="text-list__icon"><i class="las la-map-marker"></i></span>
                                        {{ __(@$employer->city) }}, {{ __(@$employer->country_name) }}
                                    </li>
                                    <li class="text-list__item">
                                        <span class="text-list__icon"><i class="las la-clock"></i></span>
                                        @lang('Since') {{ showDateTime(@$employer->founding_date, 'd M, Y') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-pills custom--tab tab-three mb-0" id="pills-tab" role="tablist">
                        <li class="tab-bar"></li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !@$jobStatus ? 'active' : '' }}" id="pills-overview-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab"
                                aria-controls="pills-overview" aria-selected="true">
                                @lang('Overview')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ @$jobStatus ? 'active' : '' }}" id="pills-job-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-job" type="button" role="tab"
                                aria-controls="pills-job" aria-selected="false">
                                @lang('Jobs')
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade {{ !@$jobStatus ? 'active show' : '' }}" id="pills-overview" role="tabpanel"
                        aria-labelledby="pills-overview-tab" tabindex="0">
                        <div class="candidate-profile">
                            <div class="candidate-profile__left">
                                <div class="about">
                                    <h6 class="about__title">@lang('Description')</h6>
                                    <p class="about__desc">
                                        @php echo @$employer->description;@endphp
                                    </p>
                                </div>
                                @if (@$employer->map)
                                    <div class="about mt-4">
                                        <h6 class="about__title">
                                            @lang('Location of') {{ __(@$employer->company_name) }}</h6>
                                        <div class="map">
                                            @php echo @$employer->map; @endphp
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="candidate-profile__right right-two caption-list">
                                <div class="overview-item ">

                                    <h6 class="overview-item__title">
                                        <span class="overview-item__icon">
                                            <i class="las la-envelope"></i>
                                        </span>
                                        @lang('Email')
                                    </h6>
                                    <div class="overview-item__content">
                                        <span class="overview-item__text">
                                            <a href="mailto:{{ @$employer->email }}">
                                                {{ @$employer->email }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="overview-item ">
                                    <h6 class="overview-item__title">
                                        <span class="overview-item__icon">
                                            <i class="las la-phone-volume"></i>
                                        </span>
                                        @lang('Mobile')
                                    </h6>
                                    <div class="overview-item__content">
                                        <span class="overview-item__text">
                                            <a href="tel:{{ @$employer->mobileNumber }}">
                                                {{ @$employer->mobileNumber }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                @if (@$employer->fax)
                                    <div class="overview-item ">
                                        <h6 class="overview-item__title">
                                            <span class="overview-item__icon">
                                                <i class="las la-fax"></i>
                                            </span>
                                            @lang('Fax')
                                        </h6>
                                        <div class="overview-item__content">
                                            <span class="overview-item__text">
                                                {{ @$employer->fax }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if (@$employer->website)
                                    <div class="overview-item ">
                                        <h6 class="overview-item__title">
                                            <span class="overview-item__icon">
                                                <i class="las la-globe"></i>
                                            </span>
                                            @lang('Website')
                                        </h6>
                                        <div class="overview-item__content">
                                            <span class="overview-item__text">
                                                <a href="{{ @$employer->website }}" target="_blank">
                                                    {{ @$employer->website }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if (@$employer->numberOfEmployee)
                                    <div class="overview-item ">
                                        <h6 class="overview-item__title">
                                            <span class="overview-item__icon">
                                                <i class="las la-users"></i>
                                            </span>
                                            @lang('Employees')
                                        </h6>
                                        <div class="overview-item__content">
                                            <span class="overview-item__text">
                                                {{ __(@$employer->numberOfEmployee->employees) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if (@$employer->address)
                                    <div class="overview-item ">
                                        <h6 class="overview-item__title">
                                            <span class="overview-item__icon">
                                                <i class="las la-map-marker-alt"></i>
                                            </span>
                                            @lang('Address')
                                        </h6>
                                        <div class="overview-item__content">
                                            <span class="overview-item__text">
                                                {{ __(@$employer->address) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="about mt-4">
                                    <h6 class="about__title">
                                        @lang('Connect with') {{ __(@$employer->company_name) }}
                                    </h6>
                                    <ul class="d-flex align-items-center gap-3">
                                        @foreach ($employer->social_media ?? [] as $key => $socialMedia)
                                            @if ($socialMedia)
                                                <li class="contact-list">
                                                    <a href="{{ $socialMedia }}" class="overview-item__icon"
                                                        target="_blank">
                                                        <i class="lab la-{{ $key }}"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ @$jobStatus ? 'active show' : '' }}" id="pills-job" role="tabpanel"
                        aria-labelledby="pills-job-tab" tabindex="0">
                        <div class="candidate-profile">
                            <div class="candidate-profile__left">
                                <div class="job-list-wrapper">
                                    <h4 class="title">
                                        @lang('Job opening at') {{ __(@$employer->company_name) }}
                                    </h4>
                                    @if (@$jobs->count())
                                        @foreach ($jobs ?? [] as $job)
                                            <div class="job-info-item">
                                                <div class="job-info-item__container">
                                                    <h6 class="job-info-item__title">
                                                        <a href="{{ route('job.details', $job->id) }}">
                                                            {{ __($job->title) }}
                                                        </a>
                                                    </h6>
                                                    <ul class="text-list-wrapper">
                                                        <li class=" text">
                                                            <i class="las la-briefcase"></i>
                                                            {{ diffForHumans($job->created_at) }}
                                                            <span class="separator"></span>
                                                        </li>
                                                        <li class=" text">
                                                            {{ $job->salary_amount }}
                                                            <span class="separator"></span>
                                                        </li>
                                                        <li class="text">
                                                            <i class="las la-map-marker"></i>
                                                            {{ __(@$job->location->name) }}, {{ __(@$job->city->name) }}
                                                        </li>
                                                    </ul>
                                                    <p class="description">
                                                        {{ __(@$job->short_description) }}
                                                    </p>
                                                    <div class="job-info-item__bottom">
                                                        <span class="badge badge--danger">
                                                            @lang('Deadline:')
                                                            {{ showDateTime($job->deadline, 'd M, Y') }}
                                                        </span>
                                                        <button data-action="{{ route('user.favorite.item', $job->id) }}"
                                                            type="button" class="card-icon favoriteBtn">
                                                            @if (@$job->favoriteItems->count())
                                                                <i class="fas fa-bookmark"></i>
                                                            @else
                                                                <i class="far fa-bookmark"></i>
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @include('Template::partials.empty', [
                                            'message' => 'No jobs found.',
                                        ])
                                    @endif
                                </div>
                            </div>
                            <div class="candidate-profile__right">
                                <div class="contact-wrapper w-100">
                                    <span class="contact-wrapper__subtitle ">
                                        @lang('Get in Touch')
                                    </span>
                                    <h4 class="contact-wrapper__title">
                                        @lang('Let\'s Chat with') {{ __($employer->company_name) }}
                                    </h4>
                                    <form action="{{ route('contact.with.company', $employer->id) }}" method="POST"
                                        class="contact-form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <label class="form--label">@lang('Name')</label>
                                                <input type="text" class="form--control" name="name"
                                                    value="{{ old('name') }}" required>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label class="form--label">@lang('Email')</label>
                                                <input type="email" class="form--control" name="email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                            <div class="col-sm-12 form-group">
                                                <label class="form--label">@lang('Message')</label>
                                                <textarea class="form--control" name="message" required>{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="contact-form__btn m-0">
                                            <button type="submit" class="btn--base btn">@lang('Send message')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';

            function updateBar(navItem) {
                var width = navItem.outerWidth();
                var position = navItem.position().left;
                $('.tab-bar').css({
                    'width': width + 'px',
                    'left': position + 'px'
                });
            }
            $('.tab-three .nav-link').on('click', function() {
                updateBar($(this))
            });
            var activeNavItem = $('.tab-three .nav-link.active');
            if (activeNavItem) {
                updateBar(activeNavItem)
            }
        })(jQuery)
    </script>
@endpush
