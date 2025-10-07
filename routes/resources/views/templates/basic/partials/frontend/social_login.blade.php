@if (@gs('socialite_credentials')->linkedin->status || @gs('socialite_credentials')->facebook->status || @gs('socialite_credentials')->google->status)
    <div class="social-link-wrapper w-100">
        @if (@gs('socialite_credentials')->google->status)
            <div class="continue-facebook flex-grow-1">
                <a href="{{ route('user.social.login', 'google') }}" class="btn w-100 social-login-btn">
                    <span class="facebook-icon">
                        <img src="{{ asset($activeTemplateTrue . 'images/google.svg') }}" alt="google">
                    </span>
                    @lang('Google')
                </a>
            </div>
        @endif
        @if (@gs('socialite_credentials')->facebook->status)
            <div class="continue-google flex-grow-1">
                <a href="{{ route('user.social.login', 'facebook') }}" class="btn w-100 social-login-btn">
                    <span class="google-icon">
                        <img src="{{ asset($activeTemplateTrue . 'images/facebook.svg') }}" alt="facebook">
                    </span>
                    @lang('Facebook')
                </a>
            </div>
        @endif
        @if (@gs('socialite_credentials')->linkedin->status)
            <div class="continue-google flex-grow-1">
                <a href="{{ route('user.social.login', 'linkedin') }}" class="btn w-100 social-login-btn">
                    <span class="google-icon">
                        <img src="{{ asset($activeTemplateTrue . 'images/linkedin.svg') }}" alt="linkedin">
                    </span>
                    @lang('LinkedIn')
                </a>
            </div>
        @endif
    </div>
    <div class="another-login two">
        <span class="text">@lang('OR')</span>
    </div>
@endif
