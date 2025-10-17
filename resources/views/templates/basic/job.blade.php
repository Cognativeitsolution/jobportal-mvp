@extends('Template::layouts.frontend')
@php
    $requestData = session()->has('REQUEST_DATA') ? session()->get('REQUEST_DATA') : false;
    session()->forget('REQUEST_DATA');
@endphp
@section('content')
    <div class="filter-section my-120">
        <div class="container">
            <div class="filter-main-wrapper">
                {{-- @dd($query) --}}
                @include('Template::partials.frontend.filter_card')
                <div class="filter-body">
                    <div class="filter-header">
                        <div class="filter-header__left wow fadeInUp" data-wow-duration="2s">
                            <span class="sidebar-filter-icon"><i class="las la-filter"></i>@lang('Filter')</span>
                            <span class="filter-header__text">
                                @lang('Showing total')
                                <span class="fw-bold totalJobs">{{ @$totalJobs }}</span>
                                @lang('jobs')
                            </span>
                        </div>
                        <div class="filter-header__right">
                            <div class="filter-header__content">
                                <span class="filter-header__right-text wow fadeInUp" data-wow-duration="2s">
                                    @lang('Short by')
                                </span>
                                <div class="filter-header__right-select wow fadeInUp" data-wow-duration="2s">
                                    <select class="form-select select2" name="sort_by" data-minimum-results-for-search="-1">
                                        <option value="desc" @selected(request()->sort_by == 'desc')>@lang('Newest')</option>
                                        <option value="asc" @selected(request()->sort_by == 'asc')>@lang('Oldest')</option>
                                    </select>
                                </div>
                            </div>
                            <ul class="nav nav-pills custom--tab tab-two wow fadeInUp mb-0" id="pills-tab"
                                data-wow-duration="2s" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link listViewBtn active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">


                                        </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link gridViewBtn" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">
                                        @include('Template::partials.frontend.grid_view_svg')
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade listView show active" id="pills-home">
                            @include('Template::partials.frontend.list_view_jobs')
                        </div>
                        <div class="tab-pane fade gridView" id="pills-profile">
                            @include('Template::partials.frontend.grid_view_jobs')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.select2').select2();

            let page = '';
            let sortBy = '';
            let city = `{{ @$requestData['city_id'] }}` ? `{{ @$requestData['city_id'] }}` : '';
            let search = '';
            let categoryId = `{{ @$requestData['category_id'] }}` ? [`{{ @$requestData['category_id'] }}`] : '';
            let roleId = `{{ @$requestData['role_id'] }}` ? [`{{ @$requestData['role_id'] }}`] : '';
            let jobLocationType = '';
            let typeId = `{{ @$requestData['type_id'] }}` ? [`{{ @$requestData['type_id'] }}`] : '';
            let jobExperienceId = '';
            let shiftId = '';
            let view = 'list_view_jobs';
            let keyword = `{{ @$requestData['keyword'] }}` ? `{{ @$requestData['keyword'] }}` : '';
            let minAge = '';
            let maxAge = '';
            let sum = 0;
            const flag = {
                search: 0,
                location: `{{ @$requestData['city_id'] }}` ? 1 : 0,
                category: `{{ @$requestData['category_id'] }}` ? 1 : 0,
                role: `{{ @$requestData['role_id'] }}` ? 1 : 0,
                locationType: 0,
                type: `{{ @$requestData['type_id'] }}` ? 1 : 0,
                experience: 0,
                shift: 0,
                keyword: `{{ @$requestData['keyword'] }}` ? 1 : 0,
                age: 0
            };

            if (flag.keyword || flag.role || flag.category || flag.type || flag.location) {
                sum = Object.values(flag).reduce((total, value) => total + value, 0)
                $('.filterCount').html(sum);
            }

            @if ($minAge && $maxAge)
                // age range
                $("#slider-range").slider({
                    range: true,
                    min: {{ $minAge }},
                    max: {{ $maxAge }},
                    values: [{{ $minAge }}, {{ $maxAge }}],
                    slide: function(event, ui) {
                        $("#range_amount").val(ui.values[0] + " Years" + " - " + ui.values[1] + " Years");
                    },
                    stop: function(event, ui) {
                        const selectedRange = ui.values[0] + " Years" + " - " + ui.values[1] + " Years";
                        minAge = ui.values[0];
                        maxAge = ui.values[1];
                        filterJobs();
                    }
                });
                $("#range_amount").val($("#slider-range").slider("values", 0) + " Years" +
                    " - " + $("#slider-range").slider("values", 1) + " Years");
            @endif

            // sort by
            $('[name="sort_by"]').on('change', function() {
                sortBy = $(this).val();
                filterJobs();
            });

            // paginate
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let href = $(this).attr('href');
                let url = new URL(href);
                page = url.searchParams.get("page");
                filterJobs();
            });

            // list view
            $('.listViewBtn').on('click', function() {
                if (view == 'list_view_jobs') {
                    return false;
                }
                view = 'list_view_jobs';
                $('.listView').html('');
                filterJobs();
            });

            // grid view
            $('.gridViewBtn').on('click', function() {
                if (view == 'grid_view_jobs') {
                    return false;
                }
                view = 'grid_view_jobs';
                $('.gridView').html('');
                filterJobs();
            });

            // search
            $('.search-box__button').on('click', function() {
                search = $('[name="search"]').val();
                flag.search = (search == '') ? 0 : 1;
                filterJobs();
            });

            // location
            $('[name="city"]').on('change', function() {
                city = $(this).val();
                flag.location = (city == '') ? 0 : 1;
                filterJobs();
            });

            // category
            $('[name="category_id[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#category_all').prop('checked', false);
                }
                categoryId = $('[name="category_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.category = 1;
                if (categoryId.length == 0) {
                    flag.category = 0;
                    $('#category_all').prop('checked', true);
                }
                filterJobs();
            });

            $('#category_all').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="category_id[]"]').prop('checked', false);
                }
                categoryId = [];
                flag.category = 0;
                filterJobs();
            });

            // role
            $('[name="role_id[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#role_all').prop('checked', false);
                }
                roleId = $('[name="role_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.role = 1;
                if (roleId.length == 0) {
                    flag.role = 0;
                    $('#role_all').prop('checked', true);
                }
                filterJobs();
            });

            $('#role_all').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="role_id[]"]').prop('checked', false);
                }
                roleId = [];
                flag.role = 0;
                filterJobs();
            });

            // work mode
            $('[name="job_location_type[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#all_job_location_type').prop('checked', false);
                }
                jobLocationType = $('[name="job_location_type[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.locationType = 1;
                if (jobLocationType.length == 0) {
                    flag.locationType = 0;
                    $('#all_job_location_type').prop('checked', true);
                }
                filterJobs();
            });

            $('#all_job_location_type').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="job_location_type[]"]').prop('checked', false);
                }
                jobLocationType = [];
                flag.locationType = 0;
                filterJobs();
            });

            // type
            $('[name="type_id[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#all_job_type').prop('checked', false);
                }
                typeId = $('[name="type_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.type = 1;
                if (typeId.length == 0) {
                    flag.type = 0;
                    $('#all_job_type').prop('checked', true);
                }
                filterJobs();
            });

            $('#all_job_type').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="type_id[]"]').prop('checked', false);
                }
                typeId = [];
                flag.type = 0;
                filterJobs();
            });

            // job experience
            $('[name="job_experience_id[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#all_job_experience').prop('checked', false);
                }
                jobExperienceId = $('[name="job_experience_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.experience = 1;
                if (jobExperienceId.length == 0) {
                    flag.experience = 0;
                    $('#all_job_experience').prop('checked', true);
                }
                filterJobs();
            });

            $('#all_job_experience').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="job_experience_id[]"]').prop('checked', false);
                }
                jobExperienceId = [];
                flag.experience = 0;
                filterJobs();
            });

            // shift
            $('[name="shift_id[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#all_shift').prop('checked', false);
                }
                shiftId = $('[name="shift_id[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                flag.shift = 1;
                if (shiftId.length == 0) {
                    flag.shift = 0;
                    $('#all_shift').prop('checked', true);
                }
                filterJobs();
            });

            $('#all_shift').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="shift_id[]"]').prop('checked', false);
                }
                shiftId = [];
                flag.shift = 0;
                filterJobs();
            });

            // keywords
            $('.keywordFilterBtn').on('click', function() {
                flag.keyword = 1;
                keyword = $(this).text().trim().replace(/\s+/g, ' ');
                $('.keywordFilterBtn').removeClass('active');
                $('.allKeywordFilterBtn').removeClass('active');
                $(this).addClass('active');
                filterJobs();
            });

            $('.allKeywordFilterBtn').on('click', function() {
                flag.keyword = 0;
                $('.keywordFilterBtn').removeClass('active');
                $(this).addClass('active');
                keyword = '';
                filterJobs();
            });

            function filterJobs() {
                let formData = {
                    sort_by: sortBy,
                    page: page,
                    city_id: city,
                    search: search,
                    category_id: categoryId,
                    role_id: roleId,
                    job_location_type: jobLocationType,
                    type_id: typeId,
                    job_experience_id: jobExperienceId,
                    shift_id: shiftId,
                    view: view,
                    keyword: keyword,
                    min_age: minAge,
                    max_age: maxAge,
                    filter: true
                };
                $.ajax({
                    url: "{{ $url }}",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        if (view == 'list_view_jobs') {
                            $('.listView').html(response.view);
                        } else {
                            $('.gridView').html(response.view);
                        }
                        sum = Object.values(flag).reduce((total, value) => total + value, 0)
                        $('.filterCount').html(sum);
                        $('.totalJobs').html(response.totalJobs);
                        page = response.page ?? page;
                        $('html, body').animate({
                            scrollTop: 0
                        }, 300);
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
