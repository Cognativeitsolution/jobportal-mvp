@extends('Template::employer.layouts.master')
@section('content')
    <div class="company-profile-wrapper">
        <form class="disableSubmission w-100" action="{{ route('employer.profile.submit') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="card-item">
                <div class="card-item__header">
                    <h6 class="card-item__title">@lang('Company Information')</h6>
                </div>
                <div class="card-item__inner">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="company-profile-thumb-wrapper">
                                    <div class="company-profile-thumb">
                                        <div class="thumb">
                                            <img id="imagePreview"
                                                 src="{{ getImage(getFilePath('employer') . '/' . @$employer->image, getFileSize('employer')) }}"
                                                 alt="profile-image">
                                        </div>
                                        <div class="company-profile-thumb__btn">
                                            <div class="file-upload">
                                                <label class="edit" for="image"> <i class="las la-camera"></i>
                                                </label>
                                                <input class="form-control form--control" id="image"
                                                       name="image" type="file" hidden=""
                                                       accept=".jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <p class="label">@lang('Company Logo')</p>
                                        <p class="description">@lang('Supported formats: PNG, JPG, JPEG. Max file size: 2 MB.')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="form--label">@lang('Company Name')</label>
                                    <a class="buildSlug fs-14" href="javascript:void(0)"><i
                                           class="las la-link"></i>@lang('Make Slug')</a>
                                </div>
                                <input class="form--control" name="company_name" type="text"
                                       value="{{ old('company_name', @$employer->company_name) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="form--label">@lang('Slug')</label>
                                    <div class="slug-verification d-none"></div>
                                </div>
                                <input class="form--control" name="slug" type="text"
                                       value="{{ old('slug', @$employer->slug) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('CEO Name')</label>
                                <input class="form--control" name="ceo_name" type="text"
                                       value="{{ old('ceo_name', @$employer->ceo_name) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Website')</label>
                                <input class="form--control" name="website" type="url"
                                       value="{{ old('website', @$employer->website) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Email')</label>
                                <input class="form--control" type="email" value="{{ @$employer->email }}"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Phone')</label>
                                <input class="form--control" type="text"
                                       value="{{ @$employer->mobileNumber }}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Fax')</label>
                                <input class="form--control" name="fax" type="text"
                                       value="{{ old('fax', @$employer->fax) }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Industry')</label>
                                <select class="form--control select2" name="industry" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($industries ?? [] as $industry)
                                        <option value="{{ $industry->id }}" @selected($industry->id == old('industry', @$employer->industry_id))>
                                            {{ __($industry->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Number Of Employees')</label>
                                <select class="form--control select2" name="number_of_employees">
                                    <option selected disabled>@lang('Select One')</option>
                                    @foreach ($numberOfEmployees ?? [] as $employee)
                                        <option value="{{ $employee->id }}" @selected($employee->id == old('number_of_employees', @$employer->number_of_employees_id))>
                                            {{ __($employee->employees) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Founding Date')</label>
                            <input class="form--control" name="founding_date" type="text"
                                   value="{{ old('founding_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-item">
                <div class="card-item__header">
                    <h6 class="card-item__title">@lang('Company Details')</h6>
                </div>
                <div class="card-item__inner">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Description')</label>
                                <textarea class="form--control nicEdit" name="description" rows="8" required>@php echo $employer->description @endphp </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-item">
                <div class="card-item__header">
                    <h6 class="card-item__title">@lang('Social Media')</h6>
                </div>
                <div class="card-item__inner">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Facebook')</label>
                            <input class="form--control" name="social_media[facebook]" type="url"
                                   value="{{ old('social_media[facebook]', @$employer->social_media->facebook) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Linkedin')</label>
                            <input class="form--control" name="social_media[linkedin]" type="url"
                                   value="{{ old('social_media[linkedin]', @$employer->social_media->linkedin) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('X')</label>
                            <input class="form--control" name="social_media[twitter]" type="url"
                                   value="{{ old('social_media[twitter]', @$employer->social_media->twitter) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Instagram')</label>
                            <input class="form--control" name="social_media[instagram]" type="url"
                                   value="{{ old('social_media[instagram]', @$employer->social_media->instagram) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Pinterest')</label>
                            <input class="form--control" name="social_media[pinterest]" type="url"
                                   value="{{ old('social_media[pinterest]', @$employer->social_media->pinterest) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Telegram')</label>
                            <input class="form--control" name="social_media[telegram]" type="url"
                                   value="{{ old('social_media[telegram]', @$employer->social_media->telegram) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-item">
                <div class="card-item__header">
                    <h6 class="card-item__title">@lang('Address & Location')</h6>
                </div>
                <div class="card-item__inner">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Address')</label>
                            <input class="form--control" name="address" type="text" value="{{ old('address', @$employer->address) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('City')</label>
                            <input class="form--control" name="city" type="text" value="{{ old('city', @$employer->city) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Zip Code')</label>
                            <input class="form--control" name="zip" type="text" value="{{ old('zip', @$employer->zip) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('State')</label>
                            <input class="form--control" name="state" type="text" value="{{ old('state', @$employer->state) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Country')</label>
                            <input class="form--control" type="text" value="{{ @$employer->country_name }}" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form--label">@lang('Map iFrame')</label>
                            <input class="form--control" name="map" type="text" value="{{ old('map', @$employer->map) }}">
                        </div>
                    </div>
                </div>
            </div>


            <div class="company-profile-wrapper__btn justify-content-end">
                <button class="btn btn--base btn--lg" type="submit">@lang('Submit')</button>
            </div>
        </form>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            $(".select2").select2();

            let foundingDate = `{{ @$employer->founding_date }}` ?
                `{{ showDateTime(@$employer->founding_date, 'm/d/Y') }}` : moment();

            $('input[name="founding_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1600,
                maxYear: parseInt(moment().format('YYYY'), 10),
                maxDate: moment(),
                startDate: foundingDate,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            function initNicEditor() {
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
            }

            initNicEditor()

            $(document).on('mouseover', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });

            $('#image').on('change', function(e) {
                const file = e.target.files[0];
                const preview = $('#imagePreview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('.buildSlug').on('click', function() {
                let closestForm = $(this).closest('form');
                let title = closestForm.find('[name=company_name]').val();
                closestForm.find('[name=slug]').val(title);
                closestForm.find('[name=slug]').trigger('input');
            });

            $('[name=slug]').on('input', function() {
                let closestForm = $(this).closest('form');
                closestForm.find('[type=submit]').addClass('disabled')
                let slug = $(this).val();
                slug = slug.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $(this).val(slug)
                if (slug) {
                    $('.slug-verification').removeClass('d-none');
                    $('.slug-verification').html(`
                        <small class="text--info"><i class="las la-spinner la-spin"></i> @lang('Checking')</small>
                    `);
                    $.get("{{ route('employer.profile.check.slug', @$employer->id) }}", {
                        slug: slug
                    }, function(response) {
                        if (!response.exists) {
                            $('.slug-verification').html(`
                                <small class="text--success"><i class="las la-check"></i> @lang('Available')</small>
                            `);
                            closestForm.find('[type=submit]').removeClass('disabled')
                        }
                        if (response.exists) {
                            $('.slug-verification').html(`
                                <small class="text--danger"><i class="las la-times"></i> @lang('Slug already exists')</small>
                            `);
                        }
                    });
                } else {
                    $('.slug-verification').addClass('d-none');
                }
            })
        });
    </script>
@endpush

@push('style')
    <style>
        .nicEdit-main {
            outline: unset;
            min-height: 300px !important;
        }

        .cancelBtn {
            background: hsl(var(--warning)) !important;
        }

        .company-description {
            padding: 10px;
        }
    </style>
@endpush
