<form action="{{ route('user.login') }}" method="POST" class="disableSubmission w-100 verify-gcaptcha">
    @csrf
    <div class="form-group">
        <label class="form--label">@lang('Email or Username')</label>
        <input type="text" class="form--control" name="username" value="{{ old('username') }}" required>
    </div>
    <div class="form-group">
        <label for="password" class="form--label">@lang('Password')</label>
        <div class="position-relative">
            <input id="password" type="password" class="form--control" name="password" value="{{ old('password') }}" required>
            <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
        </div>
    </div>
    <div class="form-group">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="form--check align-items-center">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                <label class="form-check-label" for="remember">@lang('Remember Me')</label>
            </div>
            <a href="{{ route('user.password.request') }}" class="have-account__link text--base">
                @lang('Forgot Your Password?')
            </a>
        </div>
    </div>
    <x-captcha labelClass="form--label" />
    <div class="form-group">
        <button type="submit" class="btn btn--base w-100"> @lang('Submit')</button>
    </div>
    @if (gs('registration'))
        <div class="have-account text-center">
            <p class="have-account__text">
                @lang('Don\'t Have An Account?')
                <a href="{{ route('user.register') }}" class="have-account__link text--base">
                    @lang('Create Account')
                </a>
            </p>
        </div>
    @endif
</form>
