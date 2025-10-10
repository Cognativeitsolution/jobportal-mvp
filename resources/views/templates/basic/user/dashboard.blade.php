@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="notice"></div>
    <div class="user-profile-body__wrapper">

        @if ($recommendedJobs->count())
            <div class="profile-item-wrapper">
                <div class="profile-item-wrapper__top m-0 wow fadeInUp" data-wow-duration="2s">
                    <h6 class="title">@lang('Recommended jobs')</h6>
                    <a href="{{ route('job') }}" class="text--base link">@lang('All Jobs')</a>
                </div>
                <div class="feature-slider wow fadeInUp" data-wow-duration="2s">
                    @foreach ($recommendedJobs ?? [] as $recommendedJob)
                        <div class="feature-item item-two">
                            <div class="d-flex justify-content-between  align-items-start gap-2">
                                <a href="{{ route('company.profile', @$recommendedJob->employer->slug) }}"
                                    class="feature-item__thumb">
                                    <img src="{{ getImage(getFilePath('employer') . '/' . @$recommendedJob->employer->image, getFileSize('employer')) }}"
                                        alt="employer-image">
                                </a>
                                <span class="feature-item__time">{{ __(@$recommendedJob->type->name) }}</span>
                            </div>
                            <div class="feature-item__content">
                                <a href="{{ route('company.profile', @$recommendedJob->employer->slug) }}"
                                    class="feature-item__name">
                                    {{ __(@$recommendedJob->employer->company_name) }}
                                </a>
                                <h6 class="feature-item__title m-0">
                                    <a href="{{ route('job.details', $recommendedJob->id) }}">
                                        {{ strLimit(__($recommendedJob->title), 20) }}
                                    </a>
                                </h6>
                                <span class="feature-item__role">
                                    {{ __(@$recommendedJob->role->name) }}
                                </span>
                                <span class="sponsor-item__location mt-2">
                                    <span class="icon"><i class="las la-map-marker"></i></span>
                                    {{ __(@$recommendedJob->location->name) }}, {{ __(@$recommendedJob->city->name) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($topCompanies->count())
            <div class="profile-item-wrapper mt-4">
                <div class="profile-item-wrapper__top m-0  wow fadeInUp" data-wow-duration="2s">
                    <h6 class="title">@lang('Top Companies')</h6>
                    <a href="{{ route('company.list') }}" class="text--base link">@lang('All Companies')</a>
                </div>
                <div class="sponsor-item-slider dashboardSlider  wow fadeInUp" data-wow-duration="2s">
                    @foreach ($topCompanies as $company)
                        @if (@$company->slug != null)
                            <div class="sponsor-card">
                                <div class="sponsor-item">
                                    <a href="{{ route('company.profile', @$company->slug) }}" class="sponsor-item__thumb">
                                        <img src="{{ getImage(getFilePath('employer') . '/' . @$company->image, getFileSize('employer')) }}"
                                            alt="employer-image">
                                    </a>
                                    <div class="sponsor-item__content">
                                        <h6 class="sponsor-item__title">
                                            <a href="{{ route('company.profile', $company->slug) }}">
                                                {{ __($company->company_name) }}
                                            </a>
                                        </h6>
                                        <p class="sponsor-item__location">
                                            <span class="icon">
                                                <i class="las la-map-marker"></i>
                                            </span>
                                            {{ __($company->city) }}, {{ __($company->country_name) }}
                                        </p>
                                        <a href="{{ route('company.jobs', $company->slug) }}"
                                            class="btn sponsor-item__btn">
                                            @lang('View Jobs')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="profile-item-wrapper mt-4">
            <div class="profile-item-wrapper__top m-0 wow fadeInUp" data-wow-duration="2s">
                <h6 class="title">@lang('Stay updated with our blogs')</h6>
                <a href="{{ route('blog') }}" class="text--base link">
                    @lang('All Blogs')
                </a>
            </div>
            <div class="blog-slider  wow fadeInUp" data-wow-duration="2s">
                @foreach ($blogs ?? [] as $blog)
                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <a href="{{ route('blog.details', @$blog->slug) }}" class="blog-item__thumb-link">
                                <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '400x280') }}"
                                    class="fit-image" alt="blog-image">
                            </a>
                        </div>
                        <div class="blog-item__content">
                            <ul class="text-list flex-align gap-3">
                                <li class="text-list__item">{{ __(@$blog->data_values->category) }}</li>
                            </ul>
                            <h5 class="blog-item__title">
                                <a href="{{ route('blog.details', @$blog->slug) }}" class="blog-item__title-link ">
                                    <span class="border-effect">
                                        {{ __(@$blog->data_values->title) }}
                                    </span>
                                </a>
                            </h5>
                            <a class="blog-item__btn" href="{{ route('blog.details', @$blog->slug) }}">
                                @lang('Read More')
                                <span class="btn-icon">
                                    <i class="las la-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.sponsor-item-slider').slick({
                dots: false,
                arrows: true,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 1,
                prevArrow: '<button type="button" class="slick-prev"> <i class="las la-angle-left"></i> </button>',
                nextArrow: '<button type="button" class="slick-next"> <i class="las la-angle-right"></i> </button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .feature-item__role {
            font-size: 14px;
            font-weight: 600;
            color: hsl(var(--text-color-two));
        }
    </style>
@endpush
