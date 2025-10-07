@php
    $loginContent = getContent('login.content', true);
@endphp
<div class="login-sidebar">
    <span class="login-sidebar__close"> <i class="las la-times"></i> </span>
    <div class="account-form left-sidebar">
        <div class="account-form__content mb-4">
            <h4 class="account-form__title mb-2">
                {{ __(@$loginContent->data_values->heading) }}
            </h4>
            <p class="account-form__desc">
                {{ __(@$loginContent->data_values->subheading) }}
            </p>
        </div>
        @include('Template::partials.frontend.social_login')
        @include('Template::partials.frontend.login_form')
    </div>
</div>
