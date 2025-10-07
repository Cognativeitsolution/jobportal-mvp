<div class="dashboard-header">
    <div class="dashboard-header__inner flex-between">
        <div class="dashboard-header__left">
            <div class="dashboard-body__bar d-lg-none d-block">
                <span class="dashboard-body__bar-icon"><i class="fa-solid fa-bars-staggered"></i></span>
            </div>
            <form action="{{ route('employer.job.index') }}" autocomplete="off" class="search-box-wrapper">
                <div class="header-search-box">
                    <input type="text" class="form--control" placeholder="@lang('Find jobs')" name="search"
                        value="{{ request('search') }}">
                    <button type="button" class="header-search-box__button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="dashboard-header__right flex-align">
            <div class="dropdown-box header-profile-dropdown">
                <div class="dropdown-box__wrapper">
                    <div class="dropdown-box__thumb">
                        <img src="{{ getProfileImage($activeUser->image, 'employer') }}" alt="user-thumb">
                    </div>
                    <div class="dropdown-box__content">
                        <h6 class="name">{{ __(@$activeUser->company_name) ?? @$activeUser->fullname }}</h6>
                        <p class="text">{{ __(@$activeUser->industry->name) ?? __(@$activeUser->country_name) }}</p>
                    </div>
                </div>
                <ul class="dropdown-box__menu">
                    <li class="dropdown-box__item">
                        <a href="{{ route('employer.ticket.index') }}" class="dropdown-box__link">
                            <span class="dropdown-box__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-headset-icon lucide-headset">
                                    <path
                                        d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
                                    <path d="M21 16v2a4 4 0 0 1-4 4h-5" />
                                </svg>
                            </span>
                            @lang('Support Tickets')
                        </a>
                    </li>
                    <li class="dropdown-box__item">
                        <a href="{{ route('employer.change.password') }}" class="dropdown-box__link">
                            <span class="dropdown-box__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-file-lock2-icon lucide-file-lock-2">
                                    <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v1" />
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                    <rect width="8" height="5" x="2" y="13" rx="1" />
                                    <path d="M8 13v-2a2 2 0 1 0-4 0v2" />
                                </svg>
                            </span>
                            @lang('Change Password')
                        </a>
                    </li>
                    <li class="dropdown-box__item">
                        <a href="{{ route('employer.twofactor') }}" class="dropdown-box__link">
                            <span class="dropdown-box__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-shield-check-icon lucide-shield-check">
                                    <path
                                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                            </span>
                            @lang('2FA Security')
                        </a>
                    </li>
                    <li class="dropdown-box__item">
                        <a href="{{ route('employer.logout') }}" class="dropdown-box__link">
                            <span class="dropdown-box__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-log-out-icon lucide-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" x2="9" y1="12" y2="12" />
                                </svg>
                            </span>
                            @lang('Logout')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
