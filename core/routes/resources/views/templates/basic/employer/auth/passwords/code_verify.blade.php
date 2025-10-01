@extends('Template::layouts.frontend')
@section('content')
    <div class="container my-120">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="d-flex justify-content-center">
                    <div class="verification-code-wrapper">
                        <div class="verification-area">
                            <h5 class="mb-2">{{ __($pageTitle) }}</h5>
                            <p class="pb-3">
                                @lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}
                            </p>
                            <form action="{{ route('employer.password.verify.code') }}" method="POST"
                                  class="submit-form disableSubmission">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">

                                @include('Template::partials.verification_code')

                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                                <p>
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .verification-code-wrapper {
            border-radius: 40px;
            border: 1px solid hsl(var(--black)/0.07);
        }

        .verification-code span {
            border: 1px solid hsl(var(--border-color));
            background: hsl(var(--white));
            border-radius: 5px !important;
        }
    </style>
@endpush
