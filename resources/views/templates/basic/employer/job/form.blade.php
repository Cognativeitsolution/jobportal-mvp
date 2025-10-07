@extends('Template::employer.layouts.master')
@php $employer = authUser('employer');@endphp
@section('content')

    @if (!@$subscription && !@$job)
        @if (gs('free_job_post') && @$employer->free_job_post_limit)
            <div class="alert alert--info align-items-center mb-4" role="alert">
                <div class="alert__icon">
                    <i class="las la-info-circle"></i>
                </div>
                <div class="alert__content">
                    <p class="alert__title mb-0">
                        @lang('You are able to post up to') {{ @$employer->free_job_post_limit }} @lang('job free of charge')
                    </p>
                </div>
            </div>
        @endif
        @if (!(gs('free_job_post') && @$employer->free_job_post_limit) && gs('job_post_payment'))
            <div class="alert alert--info align-items-center mb-4" role="alert">
                <div class="alert__icon">
                    <i class="las la-info-circle"></i>
                </div>
                <div class="alert__content">
                    <p class="alert__desc mb-0">
                        @lang('If you don\'t have a subscription plan, a') {{ showAmount(gs('fee_per_job_post')) }} @lang('fee applies per job post. We recommend subscribing to a plan for more benefits and exclusive offers')
                    </p>
                </div>
            </div>
        @endif
    @else
        @if (@$employer->job_post_count <= 0 && gs('job_post_payment'))
            <div class="alert alert--info align-items-center mb-4" role="alert">
                <div class="alert__icon">
                    <i class="las la-info-circle"></i>
                </div>
                <div class="alert__content">
                    <p class="alert__desc mb-0">
                        @lang('If you don\'t have a subscription plan, a') {{ showAmount(gs('fee_per_job_post')) }} @lang('fee applies per job post. We recommend subscribing to a plan for more benefits and exclusive offers')
                    </p>
                </div>
            </div>
        @endif
    @endif


    <div class="company-profile-wrapper">

        @php
            $jobSteps = [
                [
                    'name' => 'Basic Information',
                    'icon' => 'fa-solid fa-circle-info',
                    'value' => 'basic',
                ],
                [
                    'name' => 'Job Information',
                    'icon' => 'fa-solid fa-briefcase',
                    'value' => 'information',
                ],
                [
                    'name' => 'Job Details',
                    'icon' => 'fa-solid fa-list-check',
                    'value' => 'details',
                ],
            ];
            $stepName = collect(array_slice($jobSteps, 0, $step + 1))
                ->pluck('value')
                ->toArray();
            $currentStep = $jobSteps[$step]['value'] ?? 'basic';
            $jobStepDb = request()->step ?? 0;
        @endphp

        <div>
            <ul class="nav nav-pills tab--style" id="pills-tab" role="tablist">
                @foreach ($jobSteps as $key => $jobStep)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if ($currentStep == $jobStep['value']) active @endif" id="pills-{{ $jobStep['value'] }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $jobStep['value'] }}" type="button" role="tab" aria-controls="pills-{{ $jobStep['value'] }}" aria-selected="true">
                            <span class="nav-link__icon"> <i class="{{ $jobStep['icon'] }}"></i> </span> {{ __($jobStep['name']) }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @foreach ($jobSteps as $key => $jobStep)
                    <div class="tab-pane fade @if (!in_array($jobStep['value'], $stepName)) disabled @endif @if ($currentStep == $jobStep['value']) show active @endif" id="pills-{{ $jobStep['value'] }}" role="tabpanel" aria-labelledby="pills-{{ $jobStep['value'] }}-tab" tabindex="0">
                        @if (in_array($jobStep['value'], $stepName))
                            @include($activeTemplate . 'employer.job.partials.' . $jobStep['value'])
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
@endpush

{{-- blade-formatter-disable --}}
@push('script')
    <script>
        (function($) {
            "use strict";
            function changeCity(locationId = 0) {
                var locations = $('select[name=city_id] :selected').data('locations');
                var html = `<option selected disabled value="">@lang('Select One')</option>`;
                if (locations != undefined) {
                    locations.forEach(function myFunction(item, index) {
                        html += `<option value="${item.id}" ${parseInt(item.id) == parseInt(locationId)  ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('select[name=location_id]').html(html);
                }
            }

            $('select[name=city_id]').on('change', function() {
                changeCity();
            });

            @if (old('location_id', @$job->location_id))
                changeCity("{{ old('location_id', @$job->location_id) }}");
            @endif

            $('#salary_type').on('change', function() {
                updateSalaryType();
            });
            updateSalaryType();

            function updateSalaryType() {
                var value = $('#salary_type').val();
                if (value == 2) {
                    $(".salaryTypeParent").removeClass('col-sm-12');
                    $(".salaryTypeParent").addClass('col-sm-6');
                    $(".salaryFrom").removeClass('d-none');
                    $(".salaryTo").removeClass('d-none');
                } else {
                    $(".salaryTypeParent").addClass('col-sm-12');
                    $(".salaryTypeParent").removeClass('col-sm-6');
                    $(".salaryFrom").addClass('d-none');
                    $(".salaryTo").addClass('d-none');
                }
            }

            $('.select2').select2();

            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });

            let customDate = `{{ @$job }}` ? `{{ showDateTime(@$job->deadline, 'm/d/Y') }}` : moment();
            $('input[name="deadline"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1600,
                maxYear: parseInt(moment().format('YYYY'), 10),
                minDate: customDate,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $.each($('.select2-auto-tokenize'), function() {
                $(this)
                    .wrap(`<div class="position-relative"></div>`)
                    .select2({
                        tags: true,
                        tokenSeparators: [','],
                        dropdownParent: $(this).parent()
                    });
            });
        })(jQuery);
    </script>
@endpush
{{-- blade-formatter-enable --}}

@push('style')
    <style>
        .nicEdit-main {
            outline: unset;
            min-height: 200px !important;
        }
    </style>
@endpush
