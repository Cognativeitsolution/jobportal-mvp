@extends('Template::layouts.frontend')
@section('content')
    <div class="container my-120">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="custom--card">
                    <div class="card-header py-3">
                        <h5 class="mb-2">{{ __($pageTitle) }}</h5>
                        <p>
                            @lang('To recover your account please provide your email or username to find your account.')
                        </p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.password.email') }}" class="disableSubmission">
                            @csrf
                            <div class="form-group">
                                <label class="form--label">@lang('Email or Username')</label>
                                <input type="text" class="form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                            </div>
                            <x-captcha labelClass="form--label" />
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
