@extends('Template::layouts.app')
@section('panel')
    @include('Template::partials.frontend.header')
    <main>
        @yield('main-content')
    </main>
    @include('Template::partials.frontend.footer')
@endsection
