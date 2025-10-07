<div class="sidebar-menu">
    <div class="sidebar-menu__inner">
        <span class="sidebar-menu__close d-lg-none d-block"><i class="fas fa-times"></i></span>
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="sidebar-logo__link">
                <img src="{{ siteLogo('dark') }}" alt="logo">
            </a>
        </div>
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__title">
                @lang('MAIN MENU')
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.home') }}">
                <a href="{{ route('employer.home') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-layout-panel-left-icon lucide-layout-panel-left">
                            <rect width="7" height="18" x="3" y="3" rx="1" />
                            <rect width="7" height="7" x="14" y="3" rx="1" />
                            <rect width="7" height="7" x="14" y="14" rx="1" />
                        </svg>
                    </span>
                    <span class="text">@lang('Dashboard')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.profile.setting') }}">
                <a href="{{ route('employer.profile.setting') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    <span class="text">@lang('Profile Update')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive(['employer.job.create']) }}">
                <a href="{{ route('employer.job.create') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path
                                  d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                        </svg>
                    </span>
                    <span class="text">@lang('Create Job')</span>
                </a>
            </li>
            <li
                class="sidebar-menu-list__item {{ menuActive(['employer.job.index', 'employer.job.applied', 'employer.job.edit', 'employer.job.applicants.all', 'employer.job.applicants.pending', 'employer.job.applicants.selected', 'employer.job.applicants.rejected', 'employer.job.applicants.draft']) }}">
                <a href="{{ route('employer.job.index') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-briefcase-business-icon lucide-briefcase-business">
                            <path d="M12 12h.01" />
                            <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                            <path d="M22 13a18.15 18.15 0 0 1-20 0" />
                            <rect width="20" height="14" x="2" y="6" rx="2" />
                        </svg>
                    </span>
                    <span class="text">@lang('Manage Jobs')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.applications.list') }}">
                <a href="{{ route('employer.applications.list') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-scroll-text-icon lucide-scroll-text">
                            <path d="M15 12h-5" />
                            <path d="M15 8h-5" />
                            <path d="M19 17V5a2 2 0 0 0-2-2H4" />
                            <path
                                  d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3" />
                        </svg>
                    </span>
                    <span class="text">@lang('All Applications')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.plan.index') }}">
                <a href="{{ route('employer.plan.index') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-receipt-icon lucide-receipt">
                            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z" />
                            <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                            <path d="M12 17.5v-11" />
                        </svg>
                    </span>
                    <span class="text">@lang('Buy Plan')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.deposit.history') }}">
                <a href="{{ route('employer.deposit.history') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-file-clock-icon lucide-file-clock">
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3" />
                            <path d="M8 14v2.2l1.6 1" />
                            <circle cx="8" cy="16" r="6" />
                        </svg>
                    </span>
                    <span class="text">@lang('Payment History')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.transactions') }}">
                <a href="{{ route('employer.transactions') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round"
                             class="lucide lucide-arrow-right-left-icon lucide-arrow-right-left">
                            <path d="m16 3 4 4-4 4" />
                            <path d="M20 7H4" />
                            <path d="m8 21-4-4 4-4" />
                            <path d="M4 17h16" />
                        </svg>
                    </span>
                    <span class="text">@lang('Transactions')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__divider">

            </li>
            <li class="sidebar-menu-list__title">
                @lang('SETTINGS')
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.ticket.*') }}">
                <a href="{{ route('employer.ticket.index') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-headset-icon lucide-headset">
                            <path
                                  d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
                            <path d="M21 16v2a4 4 0 0 1-4 4h-5" />
                        </svg>
                    </span>
                    <span class="text">@lang('Support Tickets')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.change.password') }}">
                <a href="{{ route('employer.change.password') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-file-lock2-icon lucide-file-lock-2">
                            <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v1" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <rect width="8" height="5" x="2" y="13" rx="1" />
                            <path d="M8 13v-2a2 2 0 1 0-4 0v2" />
                        </svg>
                    </span>
                    <span class="text">@lang('Change Password')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('employer.twofactor') }}">
                <a href="{{ route('employer.twofactor') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="lucide lucide-shield-check-icon lucide-shield-check">
                            <path
                                  d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                    </span>
                    <span class="text">@lang('2FA Security')</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-menu__bottom w-100">
        <a href="{{ route('employer.logout') }}" class="sidebar-menu-list__logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                <path d="m16 17 5-5-5-5" />
                <path d="M21 12H9" />
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            </svg>
            Logout
        </a>
    </div>
</div>
