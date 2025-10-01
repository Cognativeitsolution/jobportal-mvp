@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="user-profile-body__wrapper">
        <div class="profile-item-wrapper">
            <div class="card-item__inner p-0">
                <h5 class="m-0">@lang('Change Password')</h5>
            </div>
            <div class="card-item__inner p-0">
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form--label">@lang('Current Password')</label>
                        <div class="position-relative">
                            <input type="password" class="form--control" name="current_password" required
                                autocomplete="current-password">
                            <span class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                id="#current_password"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form--label">@lang('Password')</label>
                        <div class="position-relative">
                            <input type="password"
                                class="form-control form--control @if (gs('secure_password')) secure-password @endif "
                                name="password" required autocomplete="current-password">
                            <span class="password-show-hide fa-solid fa-eye-slash toggle-password" id="#password"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form--label">@lang('Confirm Password')</label>
                        <div class="position-relative">
                            <input type="password" class="form-control form--control" name="password_confirmation" required
                                autocomplete="current-password">
                            <span class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                id="#password_confirmation"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
