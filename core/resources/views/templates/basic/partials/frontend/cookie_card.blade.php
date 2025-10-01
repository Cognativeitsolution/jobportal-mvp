@php
    $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
@endphp
@if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
    <div class="cookies-card">
        <div class="cookies-card__icon"><i class="las la-cookie-bite"></i></div>
        <p class="cookies-card__content">
            {{ __($cookie->data_values->short_desc) }}
            <a class="text--base" href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a>
        </p>
        <div class="cookies-card__btn mt-3 d-flex gap-2">
            <button class="btn btn--base policy w-100">@lang('Allow')</button>
        </div>
    </div>
@endif
