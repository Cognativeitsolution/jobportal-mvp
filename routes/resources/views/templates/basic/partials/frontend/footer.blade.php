@php
    $footerContent = getContent('footer.content', true);
    $policies = getContent('policy_pages.element', false, orderById: true);
    $subscribeContent = getContent('subscribe.content', true);
    $socialIcons = getContent('social_icon.element', orderById: true);
@endphp
<footer class="footer-area">
    <div class="container">
        <div class="footer-area__wrapper">
            <div class="row justify-content-center gy-5">
                <div class="col-xl-4 col-sm-6  wow fadeInUp" data-wow-duration="2s">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ siteLogo('dark') }}" alt="logo">
                            </a>
                        </div>
                        <p class="footer-item__desc">
                            {{ __(@$footerContent->data_values->description) }}
                        </p>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6  wow fadeInUp" data-wow-duration="2s">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Quick links')</h6>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a href="{{ route('company.list') }}" class="footer-menu__link">
                                    @lang('Companies')
                                </a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('job') }}" class="footer-menu__link">
                                    @lang('Jobs')
                                </a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('contact') }}" class="footer-menu__link">
                                    @lang('Contact')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6  wow fadeInUp" data-wow-duration="2s">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Policy')</h6>
                        <ul class="footer-menu">
                            @foreach ($policies ?? [] as $policy)
                                <li class="footer-menu__item">
                                    <a href="{{ route('policy.pages', $policy->slug) }}" class="footer-menu__link">
                                        {{ __($policy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6  wow fadeInUp" data-wow-duration="2s">
                    <div class="footer-item">
                        <h6 class="footer-item__title">
                            {{ __(@$subscribeContent->data_values->heading) }}
                        </h6>
                        <p class="footer-item__desc">
                            {{ __(@$subscribeContent->data_values->subheading) }}
                        </p>
                        <form id="subscribeForm" class="footer-contact-form">
                            @csrf
                            <input type="email" name="email" class="form--control" placeholder="@lang('Email Address')" required>
                            <button type="submit" class="btn btn--base subscribe-btn">{{ __(@$subscribeContent->data_values->button_text) }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bottom-footer  wow fadeInUp" data-wow-duration="2s">
                <div class="bottom-footer-text">
                    @lang('Copyright') &copy; @php echo now()->year; @endphp @lang('All rights reserved.')
                </div>
                <ul class="social-list">
                    @foreach ($socialIcons ?? [] as $socialIcon)
                        <li class="social-list__item">
                            <a href="{{ $socialIcon->data_values->url }}" class="social-list__link flex-center" target="_blank">
                                @php echo $socialIcon->data_values->social_icon; @endphp
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>

@push('script')
    <script>
        "use strict";
        (function($) {
            var form = $("#subscribeForm");
            form.on('submit', function(e) {
                e.preventDefault();
                var data = form.serialize();
                $.ajax({
                    url: `{{ route('subscribe') }}`,
                    method: 'post',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            form.find('input[name=email]').val('');
                            notify('success', response.message);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
