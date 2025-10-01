@extends('Template::employer.layouts.master')
@section('content')
    <div class="container my-120">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5>@lang('Verify Your Email')</h5>
                    </div>
                    <form action="{{ route('employer.verify.email') }}" method="POST" class="submit-form disableSubmission">
                        @csrf
                        <p class="mb-3">
                            @lang('A 6 digit verification code sent to your email address'):
                            {{ showEmailAddress(authUser('employer')->email) }}
                        </p>
                        @include('Template::partials.verification_code')
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        <p class="mt-3">
                            @lang('If you don\'t get any code'),
                            <span class="countdown-wrapper d-inline">
                                @lang('try again after')
                                <span id="countdown" class="fw-bold">--</span>
                                @lang('seconds')
                            </span>
                            <a href="{{ route('employer.send.verify.code', 'email') }}"
                                class="try-again-link d-none text--base">
                                @lang('Try again')
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var distance = Number("{{ @$employer->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush

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
