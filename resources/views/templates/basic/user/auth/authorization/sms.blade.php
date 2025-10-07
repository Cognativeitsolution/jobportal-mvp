@extends('Template::layouts.frontend')
@section('content')
    <div class="container my-120">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h5 class="m-0">@lang('Verify Your Mobile')</h5>
                    </div>
                    <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form">
                        @csrf
                        <p class="pb-3">
                            @lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber($activeUser->mobileNumber) }}
                        </p>
                        @include('Template::partials.verification_code')
                        <div class="mb-3">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                        <p>
                            @lang('If you don\'t get any code'),
                            <span class="countdown-wrapper d-inline">
                                @lang('try again after')
                                <span id="countdown" class="fw-bold">--</span>
                                @lang('seconds')
                            </span>
                            <a href="{{ route('user.send.verify.code', 'sms') }}" class="try-again-link d-none text--base">
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
        var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
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
