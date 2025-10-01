@extends('Template::layouts.app')
@section('panel')
    <div class="dashboard position-relative">
        <div class="dashboard__inner flex-wrap">
            @include('Template::partials.employer.sidenav')
            <div class="dashboard__right">
                @include('Template::partials.employer.header')
                <div class="dashboard-body">
                    @if (request()->routeIs('employer.transactions') || request()->routeIs('employer.applications.list'))
                        <div class="body-top">
                            <div class="show-filter text-end w-100">
                                <button type="button" class="btn btn-outline--gray btn--md showFilterBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" x="0" y="0" viewBox="0 0 20 20" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g fill="#000"><path d="M0 5a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1zM3 10a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1zM8 14a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2z" fill="#000000" opacity="1" data-original="#000000"></path></g></g></svg>
                                  Filter
                                </button>
                            </div>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endsection
