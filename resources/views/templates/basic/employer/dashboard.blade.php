@extends('Template::employer.layouts.master')
@section('content')
    <div class="notice"></div>
    @if ($employer->balance)
        <div class="alert mb-4 alert--base align-items-center" role="alert">
            <span class="alert__icon">
                <i class="fas fa-info"></i>
            </span>
            <div class="alert__content">
                <p class="alert__title mb-0">
                    @lang('You have balance')
                    {{ showAmount($employer->balance) }}. @lang('You can use this to post job.')
                </p>
            </div>
        </div>
    @endif

    <div class="row g-3 g-xxl-4 justify-content-center">
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.job.index') }}" class="dashboard-widget widget--style-1">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-briefcase-business-icon lucide-briefcase-business">
                        <path d="M12 12h.01"></path>
                        <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path>
                        <path d="M22 13a18.15 18.15 0 0 1-20 0"></path>
                        <rect width="20" height="14" x="2" y="6" rx="2"></rect>
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="16" height="16" x="0" y="0" viewBox="0 0 24 24"
                         style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Jobs')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['total_job'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-briefcase-business-icon lucide-briefcase-business">
                        <path d="M12 12h.01"></path>
                        <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path>
                        <path d="M22 13a18.15 18.15 0 0 1-20 0"></path>
                        <rect width="20" height="14" x="2" y="6" rx="2"></rect>
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.job.index') }}"class="dashboard-widget widget--style-2">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-loader-icon lucide-loader">
                        <path d="M12 2v4" />
                        <path d="m16.2 7.8 2.9-2.9" />
                        <path d="M18 12h4" />
                        <path d="m16.2 16.2 2.9 2.9" />
                        <path d="M12 18v4" />
                        <path d="m4.9 19.1 2.9-2.9" />
                        <path d="M2 12h4" />
                        <path d="m4.9 4.9 2.9 2.9" />
                    </svg>
                </span>
                <button class="btn btn--view">
                    @lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="16" height="16" x="0" y="0" viewBox="0 0 24 24"
                         style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Pending Jobs')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['pending_job'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-loader-icon lucide-loader">
                        <path d="M12 2v4" />
                        <path d="m16.2 7.8 2.9-2.9" />
                        <path d="M18 12h4" />
                        <path d="m16.2 16.2 2.9 2.9" />
                        <path d="M12 18v4" />
                        <path d="m4.9 19.1 2.9-2.9" />
                        <path d="M2 12h4" />
                        <path d="m4.9 4.9 2.9 2.9" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.job.index') }}" class="dashboard-widget widget--style-3">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check">
                        <path
                              d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0"
                         viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                         class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Approved Jobs')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['approved_job'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check">
                        <path
                              d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.job.index') }}" class="dashboard-widget widget--style-4">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m4.9 4.9 14.2 14.2" />
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0"
                         viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                         class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg></button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Rejected Jobs')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['rejected_job'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m4.9 4.9 14.2 14.2" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.applications.list') }}" class="dashboard-widget widget--style-5">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0"
                         viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                         class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>

                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Applications')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['total_applicants'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.job.index') }}" class="dashboard-widget widget--style-6">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-wallet-minimal-icon lucide-wallet-minimal">
                        <path d="M17 14h.01" />
                        <path d="M7 7h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14" />
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0"
                         viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                         class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg></button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Remaining Job Posts')</span>
                    <h3 class="dashboard-widget__number">{{ $employer->job_post_count }}</h3>
                </div>

                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-wallet-minimal-icon lucide-wallet-minimal">
                        <path d="M17 14h.01" />
                        <path d="M7 7h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.transactions') }}" class="dashboard-widget widget--style-7">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-arrow-right-left-icon lucide-arrow-right-left">
                        <path d="m16 3 4 4-4 4" />
                        <path d="M20 7H4" />
                        <path d="m8 21-4-4 4-4" />
                        <path d="M4 17h16" />
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0"
                         viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                         class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg></button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Transactions')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['total_transactions'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="lucide lucide-arrow-right-left-icon lucide-arrow-right-left">
                        <path d="m16 3 4 4-4 4" />
                        <path d="M20 7H4" />
                        <path d="m8 21-4-4 4-4" />
                        <path d="M4 17h16" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <a href="{{ route('employer.job.index') }}" class="dashboard-widget widget--style-8">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="lucide lucide-arrow-up-narrow-wide-icon lucide-arrow-up-narrow-wide">
                        <path d="m3 8 4-4 4 4" />
                        <path d="M7 4v16" />
                        <path d="M11 12h4" />
                        <path d="M11 16h7" />
                        <path d="M11 20h10" />
                    </svg>
                </span>
                <button class="btn btn--view">@lang('View')<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0"
                         viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                         class="">
                        <g>
                            <clipPath id="a">
                                <path d="M0 0h24v24H0z" fill="currentColor" opacity="1" data-original="currentColor"
                                      class=""></path>
                            </clipPath>
                            <g fill="currentColor" fill-rule="evenodd" clip-path="url(#a)" clip-rule="evenodd">
                                <path
                                      d="M23.707 5.293a1 1 0 0 1 0 1.414l-9.5 9.5a1 1 0 0 1-1.414 0L8.5 11.914l-6.793 6.793a1 1 0 0 1-1.414-1.414l7.5-7.5a1 1 0 0 1 1.414 0l4.293 4.293 8.793-8.793a1 1 0 0 1 1.414 0z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                                <path d="M16 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0V7h-5a1 1 0 0 1-1-1z"
                                      fill="currentColor" opacity="1" data-original="currentColor" class="">
                                </path>
                            </g>
                        </g>
                    </svg></button>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Visitors')</span>
                    <h3 class="dashboard-widget__number">{{ $widget['total_visitor'] }}</h3>
                </div>
                <span class="shadow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="lucide lucide-arrow-up-narrow-wide-icon lucide-arrow-up-narrow-wide">
                        <path d="m3 8 4-4 4 4" />
                        <path d="M7 4v16" />
                        <path d="M11 12h4" />
                        <path d="M11 16h7" />
                        <path d="M11 20h10" />
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <div class="row g-3 g-xxl-4 mt-1">
        <div class="col-xxl-6 flex-grow-1">
            <div class="chart-box">
                <div class="chart-box__header">
                    <h5 class="chart-box__title mb-0">@lang('Visitor vs Date Statistics')</h5>
                    @if ($jobs->count())
                        <select class="form--control job_filter select2" data-minimum-results-for-search="-1">
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}">
                                    {{ __($job->title) }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="chart-box__body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        @if ($recentApplicants->count())
            <div class="col-xxl-6">
                <div class="card-item h-100">
                    <div class="card-item__header">
                        <h6 class="card-item__title mb-0">
                            @lang('Recent Applicants')
                        </h6>
                    </div>
                    <div class="card-item__inner">
                        <div class="profile-item-wrapper is-scrollbar">
                            @foreach ($recentApplicants as $applicant)
                                <div class="profile-item">
                                    <div class="profile-item__thumb">
                                        <img src="{{ getProfileImage($applicant->user->image) }}" alt="applicant-image">
                                    </div>
                                    <div class="profile-item__content">
                                        <div class="inner-content">
                                            <h6 class="profile-item__title">
                                                {{ $applicant->user->full_name }}
                                            </h6>
                                            <a href="{{ route('employer.job.applicants.all', $applicant->job->id) }}">
                                                {{ __($applicant->job->title) }}
                                            </a>
                                            <ul class="text-list">
                                                <li class="text-list__item">
                                                    @if ($applicant->user->designation)
                                                        {{ __($applicant->user->designation) }}
                                                    @else
                                                        @lang('Fresher')
                                                    @endif
                                                </li>
                                                <li class="text-list__item">
                                                    <span class="text-list__icon">
                                                        <i class="las la-map-marker"></i>
                                                    </span>
                                                    {{ __($applicant->user->country_name) }}
                                                </li>
                                                <li class="text-list__item">
                                                    <span class="text-list__icon">
                                                        <i class="las la-money-bill"></i>
                                                    </span>
                                                    @lang('Expect')
                                                    {{ gs('cur_sym') . showAmount($applicant->expected_salary, 0, kFormat: true, currencyFormat: false) }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                <a href="{{ route('candidate.profile', $applicant->user->id) }}"
                                                   class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-title="@lang('Applicant Details')" target="_blank">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.select2').select2();

            $('.job_filter').on('change', function() {
                updateOptions($(this).val());
            });

            updateOptions($('.job_filter').val());

            function updateOptions(id) {
                const data = {
                    id: id
                };
                const url = @json(route('employer.chart.visitor'));
                $.get(url, data,
                    function(response, status) {
                        if (status == 'success') {
                            chart.updateOptions({
                                xaxis: {
                                    categories: response.categories
                                },
                                series: [{
                                    data: response.values[0].data
                                }]
                            });
                        }
                    }
                );
            }

            var options = {
                chart: {
                    type: 'area',
                    height: 350
                },
                series: [{
                    name: 'Visitors',
                    data: []
                }],
                xaxis: {
                    categories: [],
                    title: {
                        text: 'Date'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Visitors (in number)'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .select2-dropdown {
            border: 0 !important;
            box-shadow: 0px 5px 30px hsl(var(--black) / .1) !important;
            min-width: 200px !important;
        }

        .select2-results__option {
            padding: 10px 10px;
            font-size: 0.875rem;
        }
    </style>
@endpush
