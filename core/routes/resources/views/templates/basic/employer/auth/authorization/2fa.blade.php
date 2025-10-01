@extends('Template::employer.layouts.master')
@section('content')
    <div class="container my-120">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5>@lang('2FA Verification')</h5>
                    </div>
                    <form action="{{ route('employer.go2fa.verify') }}" method="POST" class="submit-form disableSubmission">
                        @csrf
                        @include('Template::partials.verification_code')
                        <div class="form--group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
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
