@extends('Template::layouts.app')
@php
    $loginContent = getContent('login.content', true);
@endphp
@section('panel')
    <section class="account">
        <div class="account-inner">
            <div class="account-inner__left">
                <div class="account-thumb">
                    <img src="{{ frontendImage('login', @$loginContent->data_values->image, '1055x945') }}" alt="login-image">
                </div>
            </div>
            <div class="account-inner__right">
                <div class="account-form-wrapper">
                    <a href="{{ route('home') }}" class="account-form__logo">
                        <img src="{{ siteLogo('dark') }}" alt="logo">
                    </a>
                    <div class="account-form__content">
                        <h4 class="account-form__title">
                            {{ __(@$loginContent->data_values->heading) }}
                        </h4>

                        <p class="account-form__desc">
                            {{ __(@$loginContent->data_values->subheading) }}
                        </p>
                    </div>
                    @include('Template::partials.frontend.social_login')
                    @include('Template::partials.frontend.login_form')
                </div>
            </div>
        </div>
    </section>
@endsection
