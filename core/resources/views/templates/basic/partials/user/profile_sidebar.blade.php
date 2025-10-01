@php
    $totalApply = App\Models\JobApply::where('user_id', $activeUser->id)->count();
@endphp
<div class="profile-sidebar">
    <span class="profile-sidebar__close"><i class="las la-times"></i></span>
    <div class="profile-sidebar__top">
        <div class="profile-details">
            <a href="{{ route('user.home') }}" class="profile-details__link">
                <img src="{{ getProfileImage($activeUser->image) }}" alt="image">
            </a>
        </div>
        <div class="profile-info">
            <h5 class="profile-info__title">{{ $activeUser->fullname }}</h5>
            <span class="profile-info__subtitle">
                @if ($activeUser->work_status == Status::WORK_STATUS_EXPERIENCE)
                    {{ __($activeUser->designation) }}
                @elseif($activeUser->work_status == Status::WORK_STATUS_FRESHER)
                    @lang('Fresher')
                @else
                    @lang('Not mentioned')
                @endif
            </span>
            <a href="{{ route('user.profile.setting') }}" class="profile-info__link">
                @lang('View & Update Profile')
            </a>
        </div>
    </div>
    <div class="performance">
        <div class="performance__text">
            <h6 class="title">@lang('Your profile performance')</h6>
        </div>
        <div class="performance__wrapper">
            <div class="performance-card">
                <span class="performance-card__count">{{ $activeUser->resume_download }}</span>
                <p class="performance-card__label">@lang('Total CV download')</p>
            </div>
            <div class="performance-card">
                <span class="performance-card__count">{{ $totalApply }}</span>
                <p class="performance-card__label">@lang('Total Apply')</p>
            </div>
            <div class="performance-card">
                <span class="performance-card__count">{{ $activeUser->profile_update_percent }}%</span>
                <p class="performance-card__label">@lang('Profile Complete')</p>
            </div>
            <div class="performance-card">
                <span class="performance-card__count">{{ $activeUser->total_email }}</span>
                <p class="performance-card__label">@lang('Total Email')</p>
            </div>
        </div>
        <ul class="menu-list">
            <li class="menu-list__item">
                <a href="{{ route('user.home') }}" class="menu-list__link {{ menuActive('user.home') }}">
                    <span class="icon"><i class="las la-home"></i></span>
                    @lang('Dashboard')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('candidate.profile') }}"
                   class="menu-list__link {{ menuActive('candidate.profile') }}">
                    <span class="icon"><i class="las la-user"></i></span>
                    @lang('Profile Setting')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('user.change.password') }}"
                   class="menu-list__link {{ menuActive('user.change.password') }}">
                    <span class="icon"><i class="las la-key"></i></span>
                    @lang('Change Password')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('user.twofactor') }}" class="menu-list__link {{ menuActive('user.twofactor') }}">
                    <span class="icon"><i class="las la-user-shield"></i></span>
                    @lang('2FA Security')
                </a>
            </li>
            <li class="menu-list__item">
                <a href="{{ route('user.logout') }}" class="menu-list__link">
                    <span class="icon"> <i class="las la-sign-out-alt"></i> </span>
                    @lang('Logout')
                </a>
            </li>
        </ul>
    </div>
</div>
