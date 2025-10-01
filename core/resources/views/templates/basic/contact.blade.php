@extends('Template::layouts.frontend')
@php
    $contactContent = getContent('contact_us.content', true);
@endphp
@section('content')
    <div class="contact-section my-120">
        <div class="container">
            <div class="contact-main-wrapper">
                <div class="contact-wrapper">
                    <span class="contact-wrapper__subtitle wow fadeInUp" data-wow-duration="2s">
                        {{ __(@$contactContent->data_values->title) }}
                    </span>
                    <h4 class="contact-wrapper__title wow fadeInUp" data-wow-duration="2s">
                        {{ __(@$contactContent->data_values->heading) }}
                    </h4>
                    <p class="contact-wrapper__desc wow fadeInUp" data-wow-duration="2s">
                        {{ __(@$contactContent->data_values->subheading) }}
                    </p>
                    <form action="{{ url()->current() }}" method="POST" class="contact-form wow fadeInUp disableSubmission verify-gcaptcha" data-wow-duration="2s">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label class="form--label">@lang('Full Name')</label>
                                <input type="text" class="form--control" name="name" value="{{ old('name', @$activeUser->fullname) }}" @readonly(@$activeUser && @$activeUser->profile_complete) required>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form--label">@lang('Email')</label>
                                <input type="email" class="form--control" name="email" value="{{ old('email', @$activeUser->email) }}" @readonly(@$activeUser && @$activeUser->profile_complete) required>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form--label">@lang('Subject')</label>
                                <input type="text" class="form--control" name="subject" value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form--label">@lang('Message')</label>
                                <textarea class="form--control" name="message" required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <x-captcha labelClass="form--label" />
                        <div class="contact-form__btn">
                            <button type="submit" class="btn--base btn">@lang('Send Message')</button>
                        </div>
                    </form>
                </div>
                <div class="contact-right">
                    <div class="contact-right__top wow fadeInUp" data-wow-duration="2s">
                        <div class="contact-right__thumb">
                            <img src="{{ frontendImage('contact_us', @$contactContent->data_values->image, '565x415') }}" alt="contact-image">
                        </div>
                    </div>
                    <div class="contact-right__wrapper">
                        <div class="contact-item wow fadeInUp" data-wow-duration="2s">
                            <div class="contact-item__icon">
                                @php echo @$contactContent->data_values->mobile_icon; @endphp
                                <span class="text">{{ __(@$contactContent->data_values->mobile_icon_text) }}</span>
                            </div>
                            <div class="contact-item__content">
                                <p class="contact-item__text">
                                    {{ __(@$contactContent->data_values->mobile_heading) }}
                                </p>
                                <a href="tel:{{ @$contactContent->data_values->mobile }}" class="contact-item__link">
                                    {{ @$contactContent->data_values->mobile }}
                                </a>
                            </div>
                        </div>
                        <div class="contact-item wow fadeInUp" data-wow-duration="2s">
                            <div class="contact-item__icon">
                                @php echo @$contactContent->data_values->email_icon; @endphp
                                <span class="text">{{ __(@$contactContent->data_values->email_icon_text) }}</span>
                            </div>
                            <div class="contact-item__content">
                                <p class="contact-item__text">
                                    {{ __(@$contactContent->data_values->email_heading) }}
                                </p>
                                <a href="mailto:{{ @$contactContent->data_values->email }}" class="contact-item__link">
                                    {{ @$contactContent->data_values->email }}
                                </a>
                            </div>
                        </div>
                        <div class="contact-item wow fadeInUp" data-wow-duration="2s">
                            <div class="contact-item__icon">
                                @php echo @$contactContent->data_values->address_icon; @endphp
                                <span class="text">{{ __(@$contactContent->data_values->address_icon_text) }}</span>
                            </div>
                            <div class="contact-item__content">
                                <p class="contact-item__text">
                                    {{ __(@$contactContent->data_values->address) }}
                                </p>
                                <button class="contact-item__button">
                                    @lang('Get Direction')
                                    <span class="contact-item__button-icon">
                                        <i class="las la-angle-right"></i>
                                    </span>
                                </button>
                                <div class="contact-item__map">
                                    <iframe src="{{ @$contactContent->data_values->location_url }}" width="600"
                                            height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
