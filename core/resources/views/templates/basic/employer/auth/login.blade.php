@extends('Template::layouts.app')
@php
    $loginContent = getContent('employer_login.content', true);
@endphp
@section('panel')
    <section class="account">
        <div class="account-inner">
            <div class="account-inner__left">
                <div class="account-thumb">
                    <img src="{{ frontendImage('employer_login', @$loginContent->data_values->image, '1055x945') }}"
                        alt="login-image">
                </div>
            </div>
            <div class="account-inner__right">
                <div class="account-form-wrapper">
                    <a href="{{ route('home') }}" class="account-form__logo">
                        <img src="{{ siteLogo('dark') }}" alt="logo">
                    </a>
                    <div class="account-form__content">
                        <h4 class="account-form__title">{{ __(@$loginContent->data_values->heading) }}</h4>
                        <p class="account-form__desc mb-4">{{ __(@$loginContent->data_values->subheading) }}</p>
                    </div>
                    <form action="{{ route('employer.login') }}" method="POST"
                        class="disableSubmission verify-gcaptcha w-100">
                        @csrf
                        <div class="account-form">

                            <div class="form-group">
                                <label class="form--label">@lang('Email / Username')</label>
                                <input type="text" class="form--control" name="username" value="{{ old('username') }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label class="form--label">@lang('Password')</label>
                                <div class="position-relative">
                                    <input id="password" type="password" class="form--control form-two" name="password"
                                        value="{{ old('password') }}" required>
                                    <span
                                        class="password-show-hide fa-solid fa-eye-slash toggle-password"id="#password"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="form--check align-items-center">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            @checked(old('remember'))>
                                        <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                    </div>
                                    <a href="{{ route('employer.password.request') }}" class="forgot-password text--base">
                                        @lang('Forgot Your Password?')
                                    </a>
                                </div>
                            </div>

                            <x-captcha labelClass="form--label" />

                            <div class="form-group">
                                <button type="submit" class="btn btn--base btn--lg w-100">@lang('Submit')</button>
                            </div>
                            @if (gs('employer_registration'))
                                <p class="account-form__text">
                                    @lang('Don\'t Have An Account?')
                                    <a href="{{ route('employer.register') }}" class="have-account__link text--base">
                                        @lang('Create Account')
                                    </a>
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
