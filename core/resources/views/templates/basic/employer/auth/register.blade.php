@extends('Template::layouts.app')
@if (gs('employer_registration'))
    @php
        $registerContent = getContent('employer_register.content', true);
    @endphp
    @section('panel')
        <section class="account">
            <div class="account-inner">
                <div class="account-inner__left">
                    <div class="account-thumb">
                        <img src="{{ frontendImage('employer_register', @$registerContent->data_values->image, '1055x945') }}"
                             alt="register-image">
                    </div>
                </div>
                <div class="account-inner__right">
                    <div class="account-form-wrapper">
                        <a href="{{ route('home') }}" class="account-form__logo">
                            <img src="{{ siteLogo('dark') }}" alt="logo">
                        </a>
                        <div class="account-form__content">
                            <h4 class="account-form__title">{{ __(@$registerContent->data_values->heading) }}</h4>
                            <p class="account-form__desc mb-4">{{ __(@$registerContent->data_values->subheading) }}</p>
                        </div>
                        <form action="{{ route('employer.register') }}" method="POST"
                              class="disableSubmission verify-gcaptcha w-100">
                            @csrf
                            <div class="account-form">
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label class="form--label">@lang('First Name')</label>
                                        <input type="text" class="form--control" name="firstname"
                                               value="{{ old('firstname') }}" required>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label class="form--label">@lang('Last Name')</label>
                                        <input type="text" class="form--control" name="lastname"
                                               value="{{ old('lastname') }}" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="form--label">@lang('Email')</label>
                                        <input type="email" class="form--control checkUser" name="email"
                                               value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="password" class="form--label">@lang('Password')</label>
                                        <div class="position-relative">
                                            <input id="password" type="password" name="password"
                                                   class="form--control @if (gs('secure_password')) secure-password @endif"
                                                   value="{{ old('password') }}" required>
                                            <span class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                                  id="#password"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="password_confirmation" class="form--label">@lang('Confirm Password')</label>
                                        <div class="position-relative">
                                            <input id="password_confirmation" type="password" name="password_confirmation"
                                                   class="form--control" value="{{ old('password_confirmation') }}" required>
                                            <div class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                                 id="#password_confirmation"></div>
                                        </div>
                                    </div>
                                    <x-captcha labelClass="form--label" />
                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', orderById: true);
                                        @endphp
                                        <div class="col-sm-12 form-group">
                                            <div class="form--check">
                                                <input class="form-check-input" type="checkbox" id="agree"
                                                       @checked(old('agree')) name="agree" required>
                                                <label class="form-check-label" for="agree">
                                                    @lang('I agree with')
                                                    @foreach ($policyPages as $policy)
                                                        <a href="{{ route('policy.pages', $policy->slug) }}"
                                                           target="_blank">
                                                            {{ __($policy->data_values->title) }}
                                                        </a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-12 form-group">
                                        <button type="submit" class="btn btn--base btn--lg w-100">
                                            @lang('Submit')
                                        </button>
                                    </div>
                                </div>
                                <p class="account-form__text">
                                    @lang('Already have an account?')
                                    <a href="{{ route('employer.login') }}" class="text--base">@lang('Login')</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade custom--modal fade-in-scale" id="existModalCenter">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">@lang('You are with us')</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center m-0">@lang('You already have an account please Login ')</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary btn--md" data-bs-dismiss="modal">
                            @lang('Close')
                        </button>
                        <a href="{{ route('user.login') }}" class="btn btn--base btn--md">
                            @lang('Login')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @if (gs('secure_password'))
        @push('script-lib')
            <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
        @endpush
    @endif

    @push('script')
        <script>
            (function($) {
                "use strict";

                $('.checkUser').on('focusout', function(e) {
                    var url = '{{ route('employer.checkEmployer') }}';
                    var value = $(this).val();
                    var token = '{{ csrf_token() }}';
                    var data = {
                        _token: token,
                        email: value
                    };
                    $.post(url, data, function(response) {
                        if (response.data != false) {
                            $('#existModalCenter').modal('show');
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
@else
    @section('panel')
        @include('Template::partials.frontend.registration_disabled')
    @endsection
@endif
