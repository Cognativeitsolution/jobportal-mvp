@extends('Template::employer.layouts.master')
@section('content')
    @if (!@$activeUser->ts)
        <div class="row">
            <div class="col-md-6">
                <div class="card-item">
                    <div class="card-item__header">
                        <h6 class="card-item__title">@lang('Add Your Account')</h6>
                    </div>
                    <div class="card-item__inner">
                        <h6 class="mb-3 text--base">
                            @lang('Use the QR code or setup key on your Google Authenticator app to add your account. ')
                        </h6>
                        <div class="form-group mx-auto text-center">
                            <img class="mx-auto" src="{{ $qrCodeUrl }}">
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Setup Key')</label>
                            <div class="input-group">
                                <input type="text" name="key" value="{{ $secret }}"
                                       class="form-control form--control referralURL" readonly>
                                <button type="button" class="input-group-text copytext" id="copyBoard">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <label class="form--label">
                            <i class="fa fa-info-circle"></i> @lang('Help')
                        </label>
                        <p>
                            @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                               class="text--base" target="_blank">
                                @lang('Download')
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-item">
                    <div class="card-item__header">
                        <h6 class="card-item__title">@lang('Enable 2FA Security')</h6>
                    </div>
                    <div class="card-item__inner">
                        <form action="{{ route('employer.twofactor.enable') }}" method="POST">
                            @csrf
                            <input type="hidden" name="key" value="{{ $secret }}">
                            <div class="form-group">
                                <label class="form--label">@lang('Google Authenticator OTP')</label>
                                <input type="text" class="form--control" name="code" required>
                            </div>
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@$activeUser->ts)
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-item wow fadeInUp" data-wow-duration="2s">
                    <div class="card-item__header">
                        <h4 class="card-item__title">@lang('Disable 2FA Security')</h4>
                    </div>
                    <div class="card-item__inner">
                        <form action="{{ route('employer.twofactor.disable') }}" method="POST">
                            @csrf
                            <input type="hidden" name="key" value="{{ $secret }}">
                            <div class="form-group">
                                <label class="form--label">@lang('Google Authenticator OTP')</label>
                                <input type="text" class="form--control" name="code" required>
                            </div>
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('style')
    <style>
        .copied::after {
            background-color: #{{ gs('base_color') }}
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').on('click', function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
