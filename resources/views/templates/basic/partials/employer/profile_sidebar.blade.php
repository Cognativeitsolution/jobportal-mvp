@php
    $totalJobs = App\Models\Job::where('employer_id', $activeUser->id)->count();
    $totalApplications = App\Models\JobApply::employerTotalApplicants($activeUser->id);
    $totalVisitors = App\Models\Visitor::employerVisitor($activeUser->id)->sum('count');
@endphp
<div class="profile-sidebar">
    <span class="profile-sidebar__close"><i class="las la-times"></i></span>
    <div class="profile-sidebar__top">
        <div class="profile-details">
            <a href="{{ route('employer.home') }}" class="profile-details__link">
                <img src="{{ getProfileImage(@$activeUser->image, 'employer') }}" alt="image">
            </a>
        </div>
        <div class="profile-info">
            <h5 class="profile-info__title">{{ $activeUser->fullname }}</h5>
            <span class="profile-info__subtitle">
                @if (@$activeUser->industry)
                    {{ __(@$activeUser->industry->name) }}
                @else
                    @lang('Not mentioned')
                @endif
            </span>
        </div>
    </div>
    <div class="performance">
        <div class="performance__text">
            <h6 class="title">@lang('Basic Information')</h6>
        </div>
        <div class="performance__wrapper">
            <div class="performance-card">
                <span class="performance-card__count">
                    {{ @$activeUser->plan ? __(@$activeUser->plan->name) : trans('N/A') }}
                </span>
                <p class="performance-card__label">@lang('Subscription')</p>
            </div>
            <div class="performance-card">
                <span class="performance-card__count">{{ @$totalVisitors }}</span>
                <p class="performance-card__label">@lang('Total Visitors')</p>
            </div>
            <div class="performance-card">
                <span class="performance-card__count">{{ $totalJobs }}</span>
                <p class="performance-card__label">@lang('Total Jobs')</p>
            </div>
            <div class="performance-card">
                <span class="performance-card__count">{{ $totalApplications }}</span>
                <p class="performance-card__label">@lang('Total Applications')</p>
            </div>
        </div>
        <ul class="menu-list">
            <li class="menu-list__item">
                <a href="{{ route('employer.home') }}" class="menu-list__link">
                    <span class="icon"><i class="las la-home"></i></span>
                    @lang('Dashboard')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('employer.profile.setting') }}" class="menu-list__link">
                    <span class="icon"><i class="las la-user"></i></span>
                    @lang('Profile Update')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('employer.change.password') }}" class="menu-list__link">
                    <span class="icon"><i class="las la-key"></i></span>
                    @lang('Change Password')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('employer.twofactor') }}" class="menu-list__link">
                    <span class="icon"><i class="las la-user-shield"></i></span>
                    @lang('2FA Security')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('employer.logout') }}" class="menu-list__link">
                    <span class="icon"> <i class="las la-sign-out-alt"></i> </span>
                    @lang('Logout')
                </a>
            </li>
        </ul>
    </div>
</div>
