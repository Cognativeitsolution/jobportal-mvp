@extends('Template::layouts.app')
@php
    $banned = getContent('banned.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp
@section('panel')
    <section class="error-page pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="error-content text-center">
                        <div class="error-content__thumb">
                            <img src="{{ frontendImage('banned', @$banned->data_values->image, '700x400') }}"
                                alt="@lang('image')">
                        </div>
                        <h2 class="error-content__title mb-2 mt-3">{{ __(@$banned->data_values->heading) }}</h2>
                        <div class="error-content__desc mb-4">
                            @lang('We are restricted your account for')
                            <strong class="text--danger"> {{ __(authUser('employer')->ban_reason) }}</strong>
                            <span class="mt-3">@lang('If you have any question or inquiry please visit our')
                                @foreach ($policyPages as $policy)
                                    <a class="text--base"
                                        href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">
                                        {{ __($policy->data_values->title) }}
                                    </a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                                @lang(' page or create support ticket form ')
                                <a class="text--base" href="{{ route('contact') }}">@lang('Here')</a>
                            </span>
                        </div>
                        <a href="{{ route('home') }}" class="btn--base btn">@lang('Go To Home')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $('footer').remove();
        })(jQuery);
    </script>
@endpush
@push('style')
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f6fb;
        }

        .error-content {
            background-color: #fff;
            padding: 60px;
            border-radius: 10px;
        }

        @media (max-width: 767px) {
            .error-content {
                padding: 45px;
            }
        }

        @media (max-width: 575px) {
            .error-content {
                padding: 25px;
            }
        }

        @media (max-width: 400px) {
            .error-content {
                padding: 15px;
            }
        }

        .error-content__thumb {
            max-width: 700px;
            margin: 0 auto;
        }

        .error-content__thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .error-content__title {
            font-weight: bolder;
        }

        .error-content__desc {
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endpush
