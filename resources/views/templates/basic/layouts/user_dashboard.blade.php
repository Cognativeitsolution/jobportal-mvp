@extends('Template::layouts.master')
@section('main-content')
    <div class="user-profile-section my-60">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    @include('Template::partials.user.sidebar')
                </div>
                <div class="col-xl-9">
                    <div class="user-profile-body">
                        <div class="d-xl-none d-block">
                            <span class="user-sidebar-button">
                                <i class="las la-cog"></i>
                            </span>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
