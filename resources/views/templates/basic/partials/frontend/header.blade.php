@php
    $filterIndustries = App\Models\Industry::active()->withCount('jobs')->orderByDesc('jobs_count')->take(6)->get();
    $filterCities = App\Models\Employer::active()->where('profile_complete', Status::YES)->distinct()->where('city', '!=', null)->withCount('jobs')->orderByDesc('jobs_count')->take(6)->pluck('city')->toArray();
@endphp
<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}">
                <img src="{{ siteLogo('dark') }}" alt="logo">
            </a>
            @if (authCheck())
                <div class="profile-candidate-header__right">
                    <div class="profile-header-wrapper">
                        <button class="profile-header-wrapper__icon">
                            <span><i class="las la-bars"></i></span>
                            <span><i class="las la-user"></i></span>
                        </button>
                    </div>
                </div>
            @else
                <div class="d-lg-none d-block ms-auto">
                    <button class="btn--base btn pill login-button">@lang('Login')</button>
                </div>
            @endif
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse position-relative" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu align-items-lg-center">
                    <li class="nav-item d-block d-lg-none">
                        <div class="top-button d-flex flex-wrap justify-content-between align-items-center">
                            <ul class="login-registration-list">
                                @if (!authCheck())
                                    <li>
                                        <a href="{{ route('employer.login') }}" class="btn btn-outline--base pill">
                                            @lang('Employer Login')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            @include('Template::partials.frontend.language')
                        </div>
                    </li>
                    <li class="nav-item {{ menuActive('home') }}">
                        <a class="nav-link" aria-current="page" href="{{ route('home') }}">
                            @lang('Home')
                        </a>
                    </li>
                    <li class="nav-item  has-mega-menu">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            @lang('Companies')
                            <span class="nav-item__icon"><i class="fa-solid fa-caret-down"></i></span>
                        </a>
                        <div class="mega-menu">
                            <div class="mega-menu__inner">
                                <ul class="mega-menu-list flex-grow-1">
                                    <li class="mega-menu-list__item">
                                        <a href="{{ route('company.list') }}" class="mega-menu-list__link title">
                                            @lang('Explore by industry')
                                        </a>
                                    </li>
                                    @foreach ($filterIndustries as $filterIndustry)
                                        <li class="mega-menu-list__item">
                                            <a href="{{ route('company.list.industry', $filterIndustry->id) }}"
                                               class="mega-menu-list__link">
                                                {{ __($filterIndustry->name) }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="mega-menu-list__item">
                                        <a href="{{ route('company.list') }}" class="mega-menu-list__link">
                                            @lang('See all')
                                        </a>
                                    </li>
                                </ul>
                                <ul class="mega-menu-list flex-grow-1">
                                    <li class="mega-menu-list__item">
                                        <a href="{{ route('company.list') }}" class="mega-menu-list__link title">
                                            @lang('Explore by Location')
                                        </a>
                                    </li>
                                    @php
                                        $uniqueCities = collect($filterCities ?? [])
                                            ->map(fn($city) => ucfirst(strtolower(trim($city)))) // normalize case
                                            ->unique()
                                            ->values()
                                            ->all();
                                    @endphp
                                    
                                    @foreach ($uniqueCities as $filterCity)
                                        <li class="mega-menu-list__item">
                                            <a href="{{ route('company.list.location', $filterCity) }}" class="mega-menu-list__link">
                                                {{ __($filterCity) }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="mega-menu-list__item">
                                        <a href="{{ route('company.list') }}" class="mega-menu-list__link">
                                            @lang('See all')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item {{ menuActive('job') }}">
                        <a class="nav-link" href="{{ route('job') }}">
                            @lang('Jobs')
                        </a>
                    </li>
                    @foreach ($pages as $data)
                        <li class="nav-item {{ menuActive('pages', null, $data->slug) }}">
                            <a class="nav-link" href="{{ route('pages', [$data->slug]) }}">
                                {{ __($data->name) }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item {{ menuActive('blog*') }}">
                        <a class="nav-link" href="{{ route('blog') }}">
                            @lang('Blog')
                        </a>
                    </li>
                    <li class="nav-item {{ menuActive('contact') }}">
                        <a class="nav-link" href="{{ route('contact') }}">
                            @lang('Contact')
                        </a>
                    </li>
                </ul>
            </div>
            <div class="d-lg-block d-none">
                <div class="top-button d-flex flex-wrap justify-content-between align-items-center">
                    @include('Template::partials.frontend.language')
                    @if (!authCheck())
                        <ul class="login-registration-list d-flex flex-wrap justify-content-between align-items-center">
                            <li>
                                <button class="btn--base btn pill login-button">@lang('Login')</button>
                            </li>
                            <li>
                                <a href="{{ route('employer.login') }}" class="btn btn-outline--base pill">
                                    @lang('Employer Login')
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</header>
@if (auth()->check())
    @include('Template::partials.user.profile_sidebar')
@elseif(auth()->guard('employer')->check())
    @include('Template::partials.employer.profile_sidebar')
@else
    @include('Template::partials.frontend.login_sidebar')
@endif
