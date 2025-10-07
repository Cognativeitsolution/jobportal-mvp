@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="user-profile-body__wrapper">
        <div class="profile-item-wrapper m-0">
            @if (authUser()->ts)
                <div class="card-item__inner">
                    <h5 class="m-0">@lang('Disable 2FA Security')</h5>
                </div>
                <div class="card-item__inner">
                    <form action="{{ route('user.twofactor.disable') }}" method="POST">
                        <div class="card-body">
                            @csrf
                            <input type="hidden" name="key" value="{{ $secret }}">
                            <div class="form-group">
                                <label class="form--label">@lang('Google Authenticatior OTP')</label>
                                <input type="text" class="form--control" name="code" required>
                            </div>
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-item__inner d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="m-0">@lang('Enable 2FA Security')</h5>
                    <button type="button" class="btn btn-outline--base" id="qrBtn">@lang('Scan QR Code')</button>
                </div>
                <div class="card-item__inner">
                    <form action="{{ route('user.twofactor.enable') }}" method="POST">
                        <div class="card-body">
                            @csrf
                            <input type="hidden" name="key" value="{{ $secret }}">
                            <div class="form-group">
                                <label class="form--label">@lang('Google Authenticatior OTP')</label>
                                <input type="text" class="form--control" name="code" required>
                            </div>
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @if (!authUser()->ts)
        <div class="modal fade custom--modal fade-in-scale" id="qrModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">@lang('Add Your Account')</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="modal-form__title plan-confirm-text">
                            @lang('Use the QR code or setup key on your Google Authenticator app to add your account.')
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
                        <label class="form--label"><i class="fa fa-info-circle"></i> @lang('Help')</label>
                        <p>
                            @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                            <a class="text--base"
                               href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                               target="_blank">
                                @lang('Download')
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

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

            $('#qrBtn').on('click', function() {
                $('#qrModal').modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .copied::after {
            background-color: #{{ gs('base_color') }}
        }
    </style>
@endpush
