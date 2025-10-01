@extends('Template::layouts.frontend')
@section('content')
    <div class="card-details-section my-120">
        <div class="container">
            <div class="main-wrapper">
                <div class="card-details">
                    <div class="card-details__header wow fadeInUp" data-wow-duration="2s">
                        <div class="d-flex justify-content-between  gap-3">
                            <div>
                                <h5 class="card-details__header-title">
                                    {{ __($job->title) }}
                                </h5>
                                <a href="{{ route('company.profile', @$job->employer->slug) }}"
                                   class="card-details__header-name">
                                    {{ __(@$job->employer->company_name) }}
                                </a>
                            </div>
                            <button data-action="{{ route('user.favorite.item', $job->id) }}" type="button"
                                    class="card-icon favoriteBtn">
                                @if (@$job->favoriteItems->count())
                                    <i class="fas fa-bookmark"></i>
                                @else
                                    <i class="far fa-bookmark"></i>
                                @endif
                            </button>
                        </div>
                        <ul class="text-list">
                            <li class="text-list__item">
                                <span class="text-list__icon">
                                    <i class="las la-map-marker"></i>
                                </span>
                                {{ __(@$job->location->name) }}, {{ __(@$job->city->name) }}
                            </li>
                            <li class="text-list__item">
                                <span class="text-list__icon">
                                    <i class="las la-briefcase"></i>
                                </span>
                                @php echo $job->jobLocationName(); @endphp
                            </li>
                            <li class="text-list__item">
                                <span class="text-list__icon">
                                    <i class="las la-money-bill"></i>
                                </span>
                                {{ $job->salary_amount }}
                            </li>
                        </ul>
                        <div class="card-details__header-badge">
                            <span class="badge badge--success">{{ __(@$job->type->name) }}</span>
                            <span class="badge badge--danger">
                                @lang('Deadline'): {{ showDateTime($job->deadline, 'd M, Y') }}
                            </span>
                        </div>
                        <div class="header-bottom">
                            <ul class="apply-card-list @if (@$applied) my-3 @endif">
                                <li class="apply-card-list__item">
                                    @lang('Posted'):
                                    <span class="apply-card-list__item-label">
                                        {{ diffForHumans($job->created_at) }}
                                    </span>
                                </li>
                                <li class="apply-card-list__item">
                                    @lang('Vacancy'):
                                    <span class="apply-card-list__item-label">
                                        {{ $job->vacancy }}
                                    </span>
                                </li>
                                <li class="apply-card-list__item">
                                    @lang('Applicants'):
                                    <span class="apply-card-list__item-label">
                                        {{ $job->job_application_count }}
                                    </span>
                                </li>
                                @if ($job->gender != Status::ANY_GENDER)
                                    <li class="apply-card-list__item">
                                        @lang('Gender'):
                                        <span class="apply-card-list__item-label">
                                            {{ $job->getGender() }}
                                        </span>
                                    </li>
                                @endif
                            </ul>
                            <div class="header-bottom__btn gap-2 d-flex flex-wrap">
                                @if (!@$preview && !auth()->guard('employer')->check())
                                    @if (!authCheck())
                                        <a href="{{ route('user.login') }}" type="button" class="btn btn--base pill">
                                            @lang('Apply Now')
                                        </a>
                                    @else
                                        @if (!$applied)
                                            <button type="button" class="btn btn--base pill applyBtn">
                                                @lang('Apply Now')
                                            </button>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-details-wrapper">
                        @php echo $job->description; @endphp
                    </div>
                </div>
                <div class="card-details__sidebar">
                    <div class="card-details__profile">
                        <div class="profile-top  wow fadeInUp" data-wow-duration="2s">
                            <a href="{{ route('company.profile', @$job->employer->slug) }}" class="profile-top__thumb">
                                <img src="{{ getImage(getFilePath('employer') . '/' . @$job->employer->image, getFileSize('employer')) }}"
                                     alt="employer-image">
                            </a>
                            <div class="profile-top__content">
                                <h6 class="profile-top__title">
                                    <a href="{{ route('company.profile', @$job->employer->slug) }}">
                                        {{ __(@$job->employer->company_name) }}
                                    </a>
                                </h6>
                                <a href="{{ route('company.profile', @$job->employer->slug) }}" class="profile-top__text">
                                    <span class="icon"><i class="las la-id-card"></i></span>
                                    @lang('View company profile')
                                </a>
                            </div>
                        </div>
                        <ul class="info-list">
                            <li class="info-list__item wow fadeInUp" data-wow-duration="2s">
                                <span class="info-list__text">@lang('Category'):</span>
                                <span class="info-list__name">{{ __(@$job->employer->industry->name) }}</span>
                            </li>
                            <li class="info-list__item wow fadeInUp" data-wow-duration="2s">
                                <span class="info-list__text">@lang('Employees'):</span>
                                <span class="info-list__name">{{ __(@$job->employer->numberOfEmployee->employees) }}</span>
                            </li>
                            <li class="info-list__item wow fadeInUp" data-wow-duration="2s">
                                <span class="info-list__text">@lang('Founded'):</span>
                                <span class="info-list__name">
                                    {{ showDateTime(@$job->employer->founding_date, 'M d, Y') }}
                                </span>
                            </li>
                            <li class="info-list__item wow fadeInUp" data-wow-duration="2s">
                                <span class="info-list__text">@lang('Phone'):</span>
                                <span class="info-list__name">{{ @$job->employer->mobileNumber }}</span>
                            </li>
                            <li class="info-list__item wow fadeInUp" data-wow-duration="2s">
                                <span class="info-list__text">@lang('Email'):</span>
                                <span class="info-list__name">{{ @$job->employer->email }}</span>
                            </li>
                            <li class="info-list__item wow fadeInUp" data-wow-duration="2s">
                                <span class="info-list__text">@lang('Location'):</span>
                                <span class="info-list__name">
                                    {{ __(@$job->employer->city) }}, {{ __(@$job->employer->country_name) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    @if (@$relatedJobs && @$relatedJobs->count())
                        <div class="job-wrapper">
                            <h6 class="job-wrapper__title">@lang('Jobs you might be interested')</h6>
                            @foreach ($relatedJobs ?? [] as $relatedJob)
                                <div class="job-wrapper-item wow fadeInUp" data-wow-duration="2s">
                                    <div class="d-flex justify-content-between gap-2 align-items-start">
                                        <div>
                                            <h6 class="job-wrapper-item__title">
                                                <a href="{{ route('job.details', $relatedJob->id) }}">
                                                    {{ __($relatedJob->title) }}
                                                </a>
                                            </h6>
                                            <span class="job-wrapper-item__name">
                                                {{ __($relatedJob->employer->company_name) }}
                                            </span>
                                        </div>
                                        <span class="job-wrapper-item__time">
                                            {{ diffForHumans($relatedJob->created_at) }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between gap-2 align-items-end">
                                        <ul class="text-list">
                                            <li class="text-list__item">
                                                <span class="text-list__icon"><i class="las la-map-marker"></i></span>
                                                {{ __($relatedJob->city->name) }}
                                            </li>
                                            <li class="text-list__item">
                                                <span class="text-list__icon"><i class="las la-briefcase"></i></span>
                                                @php echo $relatedJob->jobLocationName(); @endphp
                                            </li>
                                            <li class="text-list__item">
                                                <span class="text-list__icon"><i class="las la-money-bill"></i></span>
                                                @if ($relatedJob->salary_type == Status::RANGE)
                                                    {{ gs('cur_sym') . showAmount($relatedJob->salary_from, 0, kFormat: true, currencyFormat: false) }}
                                                    -
                                                    {{ gs('cur_sym') . showAmount($relatedJob->salary_to, 0, kFormat: true, currencyFormat: false) }}
                                                @else
                                                    @lang('Negotiable')
                                                @endif
                                            </li>
                                        </ul>
                                        <button data-action="{{ route('user.favorite.item', $relatedJob->id) }}"
                                                type="button" class="card-icon favoriteBtn">
                                            @if ($relatedJob->favoriteItems->count())
                                                <i class="fas fa-bookmark"></i>
                                            @else
                                                <i class="far fa-bookmark"></i>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @include('Template::partials.frontend.keywords', ['keywords' => $job->keywords])
                    @if (!@$preview)
                        @include('Template::partials.frontend.social_share_card', [
                            'title' => @$job->title,
                            'description' => strLimit(@$job->short_description, 200),
                            'image' => getImage(getFilePath('employer') . '/' . @$job->employer->image, getFileSize('employer')),
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('Template::partials.modal.user.job_apply_modal')
@endsection
