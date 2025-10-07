<div class="user-profile-sidebar">
    <span class="user-profile-sidebar__close-icon d-xl-none d-block"><i class="las la-times"></i></span>
    <div class="user-profile-sidebar__top  wow fadeInUp" data-wow-duration="2s">
        <a href="{{ route('user.home') }}" class="profile-thumb">
            <img src="{{ getProfileImage($activeUser->image) }}" alt="profile-image">
        </a>
        <div class="right-side">
            <h6 class="profile-title">{{ $activeUser->fullname }}</h6>
            <div class="user-profile-sidebar__top-btn">
                <a href="{{ route('user.profile.setting') }}" class="btn btn-outline--base btn--sm">
                    @if ($activeUser->profile_update_percent_list)
                        @lang('Complete profile')
                    @else
                        @lang('Update profile')
                    @endif
                </a>
            </div>
        </div>
    </div>
    <ul class="menu-list  wow fadeInUp" data-wow-duration="2s">
        <li class="menu-list__item">
            <a href="{{ route('user.home') }}" class="menu-list__link {{ menuActive('user.home') }}">
                <span class="icon"><i class="las la-home"></i></span>
                @lang('Dashboard')
            </a>
        </li>
        <li class="menu-list__item">
            <a href="{{ route('user.employment.index') }}"
                class="menu-list__link {{ menuActive('user.employment.index') }}">
                <span class="icon"><i class="las la-landmark"></i></span>
                @lang('Employment')
            </a>
        </li>
        <li class="menu-list__item">
            <a href="{{ route('user.education.index') }}"
                class="menu-list__link {{ menuActive('user.education.index') }}">
                <span class="icon"><i class="las la-graduation-cap"></i></span>
                @lang('Education')
            </a>
        </li>
        <li class="menu-list__item">
            <a href="{{ route('user.job.application') }}"
                class="menu-list__link {{ menuActive('user.job.application') }}">
                <span class="icon"><i class="las la-briefcase"></i></span>
                @lang('Applications')
            </a>
        </li>
        <li class="menu-list__item">
            <a href="{{ route('user.favorite.jobs') }}"
                class="menu-list__link {{ menuActive('user.favorite.jobs') }}">
                <span class="icon"><i class="lar la-bookmark"></i></span>
                @lang('Favorite Jobs')
            </a>
        </li>
        <li class="menu-list__item">
            <a href="{{ route('ticket.index') }}" class="menu-list__link {{ menuActive('ticket.*') }}">
                <span class="icon"><i class="las la-headset"></i></span>
                @lang('Support Tickets')
            </a>
        </li>
        <li class="menu-list__item">
            <a href="{{ route('user.logout') }}" class="menu-list__link">
                <span class="icon"> <i class="las la-sign-out-alt"></i> </span>
                @lang('Logout')
            </a>
        </li>
    </ul>
    @if ($activeUser->profile_update_percent < 100)
        <div class="user-profile-sidebar__skill  wow fadeInUp" data-wow-duration="2s">
            <h6 class="title">@lang('Skills Percentage')</h6>
            <p class="text">
                `@lang('Put value for Cover Image field to increase your skill up to') {{ 100 - $activeUser->profile_update_percent }}%`
            </p>
            <div class="progress progress--base">
                <div class="progress-bar" role="progressbar" aria-label="Success example"
                    style="width: {{ $activeUser->profile_update_percent }}%"
                    aria-valuenow="{{ $activeUser->profile_update_percent }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            <div class="profile-status">
                <a href="{{ route('user.profile.setting') }}" class="profile-status__upgrade">
                    @lang('Profile Upgrade')
                </a>
            </div>
        </div>
    @endif
</div>
