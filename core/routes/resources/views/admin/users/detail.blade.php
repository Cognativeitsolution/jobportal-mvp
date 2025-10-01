@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Job Applications" icon="las la-clipboard-list"
                value="{{ $widget['total_job_application'] }}" bg="primary" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Received Applications" icon="las la-check-circle"
                value="{{ $widget['received_job_application'] }}" bg="success" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Pending Applications" icon="las la-spinner"
                value="{{ $widget['pending_job_application'] }}" bg="warning" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Rejected Applications" icon="las la-ban"
                value="{{ $widget['rejected_job_application'] }}" bg="danger" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Total Favorite Jobs" icon="las la-bookmark"
                value="{{ $widget['mark_favorite'] }}" bg="primary" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.ticket.index') }}?user_id={{ $user->id }}"
                title="Support Ticket" icon="las la-ticket-alt" value="{{ $widget['total_ticket'] }}" bg="info" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Profile Complete" icon="las la-user"
                value="{{ $user->profile_update_percent }}%" bg="8" viewMoreIcon="{{ false }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="" title="Employer Interaction" icon="las la-network-wired" value="0"
                bg="17" viewMoreIcon="{{ false }}" />
        </div>
    </div>
    <div class="d-flex flex-wrap gap-3 mt-4">
        <div class="flex-fill">
            <a href="{{ route('admin.report.login.history') }}?search={{ $user->username }}"
                class="btn btn--primary btn--shadow w-100 btn-lg">
                <i class="las la-list-alt"></i>@lang('Logins')
            </a>
        </div>
        <div class="flex-fill">
            <a href="{{ route('admin.users.notification.log', $user->id) }}"
                class="btn btn--secondary btn--shadow w-100 btn-lg">
                <i class="las la-bell"></i>@lang('Notifications')
            </a>
        </div>
        <div class="flex-fill">
            @if ($user->status == Status::USER_ACTIVE)
                <button type="button" class="btn btn--warning btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal"
                    data-bs-target="#userStatusModal">
                    <i class="las la-ban"></i>@lang('Ban User')
                </button>
            @else
                <button type="button" class="btn btn--success btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal"
                    data-bs-target="#userStatusModal">
                    <i class="las la-undo"></i>@lang('Unban User')
                </button>
            @endif
        </div>
    </div>
    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mt-30">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Basic Information')</h5>
            </div>
            <div class="card-body">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-3 col-md-5">
                        <div class="image-upload-wrapper">
                            <div class="image-upload-preview">
                                <img src="{{ getProfileImage($user->image) }}" alt="user image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required
                                        value="{{ $user->firstname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $user->mobile }}"
                                            id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ @$user->address }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ @$user->city }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ @$user->state }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                        value="{{ @$user->zip }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $key }}" @selected($user->country_code == $key)>
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-30">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Verification')</h5>
            </div>
            <div class="card-body">
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="form-group">
                            <label>@lang('Email Verification')</label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success"
                                data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                data-off="@lang('Unverified')" name="ev"
                                @if ($user->ev) checked @endif>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="form-group">
                            <label>@lang('Mobile Verification')</label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success"
                                data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                data-off="@lang('Unverified')" name="sv"
                                @if ($user->sv) checked @endif>
                        </div>
                    </div>
                    <div class="col-xl-4 col-12">
                        <div class="form-group">
                            <label>@lang('2FA Verification') </label>
                            <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')"
                                data-off="@lang('Disable')" name="ts"
                                @if ($user->ts) checked @endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Online Profile & Profile Summary')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>@lang('Headline')</label>
                            <input type="text" name="resume_headline" class="form-control"
                                value="{{ @$user->resume_headline }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>@lang('Profile Summary')</label>
                            <textarea name="summary" class="form-control" rows="5">{{ @$user->summary }}</textarea>
                        </div>
                    </div>
                    @if ($user->userOnlineProfiles->count())
                        <div class="col-12">
                            <h5 class="my-3">@lang('Social Media')</h5>
                        </div>
                        @foreach ($user->userOnlineProfiles as $userOnlineProfile)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __($userOnlineProfile->social_media_name) }}</label>
                                    <input class="form-control" type="url"
                                        value="{{ $userOnlineProfile->link }}">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Career Profile')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Current Industry')</label>
                            <select name="industry_id" class="form-control select2">
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}" @selected(old('industry_id', @$user->industry_id) == $industry->id)>
                                        {{ __($industry->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Department')</label>
                            <select name="department_id" class="form-control select2">
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id', @$user->department_id) == $department->id)>
                                        {{ __($department->title) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Desired Job Type')</label>
                            <select name="desired_job_type" class="form-control select2"
                                data-minimum-results-for-search="-1">
                                <option value="" selected disabled>@lang('Select One')</option>
                                <option value="{{ Status::PERMANENT }}" @selected(old('desired_job_type', @$user->desired_job_type) == Status::PERMANENT)>
                                    @lang('Permanent')
                                </option>
                                <option value="{{ Status::CONTRACTUAL }}" @selected(old('desired_job_type', @$user->desired_job_type) == Status::CONTRACTUAL)>
                                    @lang('Contractual')
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Desired Employment Type')</label>
                            <select name="type_id" class="form-control select2"
                                data-minimum-results-for-search="-1">
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @selected(old('type_id', @$user->type_id) == $type->id)>
                                        {{ __($type->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Preferred Location')</label>
                            <select name="location_id" class="form-control select2">
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('location_id', @$user->location_id) == $city->id)>
                                        {{ __($city->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Preferred Shift')</label>
                            <select name="shift_id" class="form-control select2"
                                data-minimum-results-for-search="-1">
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}" @selected(old('shift_id', @$user->shift_id) == $shift->id)>
                                        {{ __($shift->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Expected Salary')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="expected_salary"
                                    value="{{ old('expected_salary', getAmount(@$user->expected_salary)) }}" />
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Personal Information')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Date of Birth')</label>
                            <input type="text" class="form-control date" name="birth_date"
                                value="{{ old('birth_date', @$user->birth_date) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('National ID')</label>
                            <input class="form-control" type="text" name="national_id"
                                value="{{ @$user->national_id }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Gender')</label>
                            <select class="form-control select2" data-minimum-results-for-search="-1"
                                name="gender">
                                <option selected disabled>@lang('Select One')</option>
                                <option value="1" @selected(@$user->gender == 1)>@lang('Male')
                                </option>
                                <option value="2" @selected(@$user->gender == 2)>@lang('Female')
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Marital Status')</label>
                            <select name="married_status" class="form-control select2"
                                data-minimum-results-for-search="-1">
                                <option value="">@lang('Select One')</option>
                                <option value="{{ Status::SINGLE }}" @selected(old('married_status', @$user->married_status) == Status::SINGLE)>
                                    @lang('Single')
                                </option>
                                <option value="{{ Status::MARRIED }}" @selected(old('married_status', @$user->married_status) == Status::MARRIED)>
                                    @lang('Married')
                                </option>
                                <option value="{{ Status::DIVORCED }}" @selected(old('married_status', @$user->married_status) == Status::DIVORCED)>
                                    @lang('Divorced')
                                </option>
                                <option value="{{ Status::SEPARATED }}" @selected(old('married_status', @$user->married_status) == Status::SEPARATED)>
                                    @lang('Separated')
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Blood Group')</label>
                            <select name="blood_group" class="form-control select2"
                                data-minimum-results-for-search="-1">
                                <option value="">@lang('Select One')</option>
                                <option value="A +" @selected(old('blood_group', @$user->blood_group) == 'A +')>
                                    @lang('A +')
                                </option>
                                <option value="A -" @selected(old('blood_group', @$user->blood_group) == 'A -')>
                                    @lang('A -')
                                </option>
                                <option value="B +" @selected(old('blood_group', @$user->blood_group) == 'B +')>
                                    @lang('B +')
                                </option>
                                <option value="B -" @selected(old('blood_group', @$user->blood_group) == 'B -')>
                                    @lang('B -')
                                </option>
                                <option value="O +" @selected(old('blood_group', @$user->blood_group) == 'O +')>
                                    @lang('O +')
                                </option>
                                <option value="O -" @selected(old('blood_group', @$user->blood_group) == 'O -')>
                                    @lang('O -')
                                </option>
                                <option value="AB +" @selected(old('blood_group', @$user->blood_group) == 'AB +')>
                                    @lang('AB +')
                                </option>
                                <option value="AB -" @selected(old('blood_group', @$user->blood_group) == 'AB -')>
                                    @lang('AB -')
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Career Break')</label>
                            <select name="career_break" class="form-control select2"
                                data-minimum-results-for-search="-1">
                                <option value="{{ Status::NO }}" @selected(old('career_break', @$user->career_break) == Status::NO)>
                                    @lang('No')
                                </option>
                                <option value="{{ Status::YES }}" @selected(old('career_break', @$user->career_break) == Status::YES)>
                                    @lang('Yes')
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <button type="submit" class="btn--primary btn h-45 w-100">@lang('Submit')</button>
            </div>
        </div>
    </form>

    <div id="userStatusModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $user->status == Status::USER_ACTIVE ? trans('Ban User') : trans('Unban User') }}
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="text-center mt-3">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == Status::USER_ACTIVE)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark" data-bs-dismiss="modal">
                                @lang('No')
                            </button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.users.login', $user->id) }}" target="_blank" class="btn btn-sm btn-outline--primary">
        <i class="las la-sign-in-alt"></i>@lang('Login as User')
    </a>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"

            let birthDate = `{{ @$user->birth_date }}` ? `{{ showDateTime(@$user->birth_date, 'm/d/Y') }}` : moment();

            $('input[name="birth_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1600,
                maxYear: parseInt(moment().format('YYYY'), 10),
                startDate: birthDate,
                maxDate: moment(),
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .image-upload-preview {
            border-radius: 10px;
            overflow: hidden;
        }

        .image-upload-preview img {
            width: 100%;
            height: 100%;
        }

        .image-upload-wrapper {
            max-width: 350px;
            margin: 0 auto;
        }

        @media (max-width:424px) {
            .image-upload-wrapper {
                height: 200px;
            }
        }
    </style>
@endpush
