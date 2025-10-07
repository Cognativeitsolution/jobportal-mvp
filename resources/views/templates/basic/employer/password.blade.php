@extends('Template::employer.layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-item">
                <div class="card-item__header">
                    <h6 class="card-item__title">@lang('Change Password')</h6>
                </div>
                <div class="card-item__inner">
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Current Password')</label>
                                    <div class="position-relative">
                                        <input type="password" name="current_password" id="current_password"
                                               class="form-control form--control" autocomplete="current-password" required>
                                        <span class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                              id="#current_password"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Password')</label>
                                    <div class="position-relative">
                                        <input id="password" type="password" name="password" required
                                               class="form-control form--control @if (gs('secure_password')) secure-password @endif">
                                        <span class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                              id="#password"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Confirm Password')</label>
                                    <div class="position-relative">
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                               class="form-control form--control" required>
                                        <div class="password-show-hide fa-solid fa-eye-slash toggle-password"
                                             id="#password_confirmation"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
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
