@extends('Template::layouts.frontend')
@php
    $requestData = session()->has('REQUEST_DATA') ? session()->get('REQUEST_DATA') : false;
    session()->forget('REQUEST_DATA');
@endphp
@section('content')
    <div class="filter-section my-120">
        <div class="container">
            <div class="filter-main-wrapper">
                <div class="filter-sidebar">
                    <span class="sidebar-filter__close d-lg-none d-block"><i class="las la-times"></i></span>
                    <div class="sidebar-header wow fadeInUp" data-wow-duration="2s">
                        <h6 class="sidebar-header__filter">
                            @lang('All Filters')
                        </h6>
                        <span class="sidebar-header__text">
                            @lang('Applied')
                            (<span class="filterCount">0</span>)
                        </span>
                    </div>
                    <div class="accordion sidebar--acordion">
                        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#search1" aria-expanded="true">
                                        @lang('Search')
                                    </button>
                                </h2>
                                <div id="search1" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="filter-block__list">
                                            <li class="filter-block__item">
                                                <div class="filter-block__select">
                                                    <div class="search-box">
                                                        <input type="text" class="form--control" name="search"
                                                            placeholder="@lang('Company name')">
                                                        <button type="submit" class="search-box__button">
                                                            <i class="las la-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#location" aria-expanded="true">
                                        @lang('Location')
                                    </button>
                                </h2>
                                <div id="location" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="filter-block__list">
                                            <li class="filter-block__item">
                                                <div class="filter-block__select">
                                                    <select class="form--control select2" name="city">
                                                        <option value="" selected>@lang('All')</option>
                                                        @foreach ($cities ?? [] as $city)
                                                            <option value="{{ $city }}"
                                                                @selected(@$requestData['city'] == $city)>
                                                                {{ __($city) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#department" aria-expanded="true">
                                        @lang('Country')
                                    </button>
                                </h2>
                                <div id="department" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="filter-block__list">
                                            <li class="filter-block__item">
                                                <div class="filter-block__select">
                                                    <select class="form--control select2" name="country_name">
                                                        <option value="" selected>@lang('All')</option>
                                                        @foreach ($countries ?? [] as $country)
                                                            <option value="{{ $country }}">
                                                                {{ __($country) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#company" aria-expanded="true">
                                        @lang('Industry Type')
                                    </button>
                                </h2>
                                <div id="company" class="accordion-collapse show collapse">
                                    <div class="accordion-body">
                                        <ul class="filter-block__list">
                                            <li class="filter-block__item">
                                                <div class="form--check">
                                                    <input class="form-check-input" type="checkbox"
                                                        @checked(!@$requestData['industry_id']) id="industry_all">
                                                    <label class="form-check-label" for="industry_all">
                                                        <span class="label-text">@lang('All')</span>
                                                    </label>
                                                </div>
                                            </li>
                                            @foreach ($industries ?? [] as $industry)
                                                <li class="filter-block__item">
                                                    <div class="form--check">
                                                        <input class="form-check-input" type="checkbox" name="industry_id[]"
                                                            value="{{ $industry->id }}" id="industry_{{ $industry->id }}"
                                                            @checked(@$requestData['industry_id'] == $industry->id)>
                                                        <label class="form-check-label"
                                                            for="industry_{{ $industry->id }}">
                                                            <span class="label-text">{{ __($industry->name) }}</span>
                                                            <span class="label-text">
                                                                ({{ $industry->employers_count }})
                                                            </span>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <li class="load-more-button">@lang('Load more')</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-body">
                    <div class="filter-header">
                        <div class="filter-header__left wow fadeInUp" data-wow-duration="2s">
                            <span class="sidebar-filter-icon"> <i class="las la-filter"></i>@lang('Filter')</span>
                            <span class="filter-header__text">
                                @lang('Showing total')
                                <span class="fw-bold totalEmployers">{{ @$totalEmployers }} </span>
                                @lang('companies')
                            </span>
                        </div>
                        <div class="filter-header__right">
                            <div class="filter-header__content content-two">
                                <span class="filter-header__right-text wow fadeInUp" data-wow-duration="2s">
                                    @lang('Short by')
                                </span>
                                <div class="filter-header__right-select wow fadeInUp" data-wow-duration="2s">
                                    <select class="form--control select2 short" name="sort_by"
                                        data-minimum-results-for-search="-1">
                                        <option value="desc" @selected(request()->sort_by == 'desc')>@lang('Newest')</option>
                                        <option value="asc" @selected(request()->sort_by == 'asc')>@lang('Oldest')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="allCompanies">
                        @include('Template::partials.frontend.company_list_card')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            let page = '';
            let sortBy = 'desc';
            let city = `{{ @$requestData['city'] }}` ? [`{{ @$requestData['city'] }}`] : '';
            let industryId = `{{ @$requestData['industry_id'] }}` ? [`{{ @$requestData['industry_id'] }}`] : '';
            let search = '';
            let countryName = '';
            let filter = false;
            let sum = 0;
            const flag = {
                search: 0,
                country: 0,
                industry: `{{ @$requestData['industry_id'] }}` ? 1 : 0,
                city: `{{ @$requestData['city'] }}` ? 1 : 0,
            };

            if (`{{ @$requestData['city'] }}` || `{{ @$requestData['industry_id'] }}`) {
                sum = Object.values(flag).reduce((total, value) => total + value, 0)
                $('.filterCount').html(sum);
            }

            $('.select2').select2();

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let href = $(this).attr('href');
                let url = new URL(href);
                page = url.searchParams.get("page");
                filterEmployers();
            });

            $('[name="sort_by"]').on('change', function() {
                sortBy = $(this).val();
                filterEmployers();
            });

            $('.search-box__button').on('click', function() {
                search = $('[name="search"]').val();
                flag.search = (search == '') ? 0 : 1;
                filterEmployers();
            });

            $('[name="city"]').on('change', function() {
                city = $(this).val();
                flag.city = (city == '') ? 0 : 1;
                filterEmployers();
            });

            $('[name="country_name"]').on('change', function() {
                countryName = $(this).val();
                flag.country = (countryName == '') ? 0 : 1;
                filterEmployers();
            });

            $('[name="industry_id[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#industry_all').prop('checked', false);
                }
                industryId = $('[name="industry_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.industry = 1;
                if (industryId.length == 0) {
                    flag.industry = 0;
                    $('#industry_all').prop('checked', true);
                }
                filterEmployers();
            });

            $('#industry_all').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="industry_id[]"]').prop('checked', false);
                }
                industryId = [];
                flag.industry = 0;
                filterEmployers();
            });

            function filterEmployers() {
                let formData = {
                    sort_by: sortBy,
                    page: page,
                    city: city,
                    industry_id: industryId,
                    search: search,
                    country_name: countryName,
                    filter: true
                };
                $.ajax({
                    url: "{{ route('company.list') }}",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        $('#allCompanies').html(response.view);
                        $('.totalEmployers').html(response.totalEmployers);
                        sum = Object.values(flag).reduce((total, value) => total + value, 0)
                        $('.filterCount').html(sum);
                        $('html, body').animate({ scrollTop: 0 }, 300);
                        setTimeout(function() {
                            $('.skeleton').removeClass('skeleton');
                        }, 1000);
                    }
                });
            }
            setTimeout(function() {
                $('.skeleton').removeClass('skeleton');
            }, 1000);
        })(jQuery)
    </script>
@endpush
