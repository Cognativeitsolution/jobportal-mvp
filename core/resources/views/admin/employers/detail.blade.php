@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.report.transaction') }}?search={{ $employer->username }}"
                      title="Balance" icon="las la-coins" value="{{ showAmount($employer->balance) }}" bg="primary" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.deposit.successful') }}?search={{ $employer->username }}"
                      title="Total Payment" icon="las la-wallet" value="{{ showAmount($widget['successful_deposit']) }}"
                      bg="success" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.deposit.pending') }}?search={{ $employer->username }}"
                      title="Pending Payment" icon="las la-money-bill-wave-alt"
                      value="{{ showAmount($widget['pending_deposit']) }}" bg="warning" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.report.transaction') }}?search={{ $employer->username }}"
                      title="Total Transaction" icon="las la-exchange-alt" value="{{ $widget['total_transaction'] }}"
                      bg="8" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.jobs.index') }}?search={{ $employer->company_name }}"
                      title="Total Job" icon="las la-clipboard-list" value="{{ getAmount($widget['total_job']) }}"
                      bg="17" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.jobs.approved') }}?search={{ $employer->company_name }}"
                      title="Approved Jobs" icon="lar la-check-circle" value="{{ $widget['approved_job'] }}" bg="success" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.jobs.pending') }}?search={{ $employer->company_name }}"
                      title="Pending Jobs" icon="las la-spinner" value="{{ $widget['pending_job'] }}" bg="warning" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="6" link="{{ route('admin.jobs.rejected') }}?search={{ $employer->company_name }}"
                      title="Rejected Jobs" icon="las la-ban" value="{{ $widget['rejected_job'] }}" bg="danger" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="7" type="2" link="javascript:void()" title="Applicants" icon="las la-users"
                      value="{{ $widget['total_applicants'] }}" bg="1" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="7" type="2" link="javascript:void()" title="User Engagement" icon="las la-user-circle"
                      value="{{ $widget['total_visitor'] }}" bg="3" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="7" type="2"
                      link="{{ route('admin.plan.subscriber.list') }}?employer_id={{ $employer->id }}" title="Subscribed Plan"
                      icon="las la-shopping-bag" value="{{ __($widget['subscribed_plan']) }}" bg="17" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="7" type="2"
                      link="{{ route('admin.ticket.index') }}?employer_id={{ $employer->id }}" title="Total Support Ticket"
                      icon="las la-ticket-alt" value="{{ $widget['total_ticket'] }}" bg="7" />
        </div>
    </div>
    <div class="d-flex flex-wrap gap-3 mt-4">
        <div class="flex-fill">
            <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                    class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                <i class="las la-plus-circle"></i> @lang('Balance')
            </button>
        </div>
        <div class="flex-fill">
            <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                    class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                <i class="las la-minus-circle"></i> @lang('Balance')
            </button>
        </div>
        <div class="flex-fill">
            <a href="{{ route('admin.report.login.history') }}?search={{ $employer->username }}"
               class="btn btn--primary btn--shadow w-100 btn-lg">
                <i class="las la-list-alt"></i>@lang('Logins')
            </a>
        </div>
        <div class="flex-fill">
            <a href="{{ route('admin.employers.notification.log', $employer->id) }}"
               class="btn btn--secondary btn--shadow w-100 btn-lg">
                <i class="las la-bell"></i>@lang('Notifications')
            </a>
        </div>
        <div class="flex-fill">
            @if ($employer->status == Status::EMPLOYER_ACTIVE)
                <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus"
                        data-bs-toggle="modal" data-bs-target="#userStatusModal">
                    <i class="las la-ban"></i>@lang('Ban Employer')
                </button>
            @else
                <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus"
                        data-bs-toggle="modal" data-bs-target="#userStatusModal">
                    <i class="las la-undo"></i>@lang('Unban Employer')
                </button>
            @endif
        </div>
    </div>
    <div class="card mt-30">
        <div class="card-header">
            <h5 class="card-title mb-0">@lang('Employer Image & Map')</h5>
        </div>
        <div class="card-body">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-3 col-lg-5 col-md-5">
                    <div class="image-upload-wrapper">
                        <div class="image-upload-preview">
                            <img src="{{ getProfileImage($employer->image, 'employer') }}" alt="employer image">
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-7 col-md-7">
                    <div class="map">
                        @php echo $employer->map;@endphp
                    </div>
                </div>
            </div>
            <div class="row"></div>
        </div>
    </div>
    <form action="{{ route('admin.employers.update', [$employer->id]) }}" method="POST">
        @csrf
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Basic Information')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">@lang('Company Name')</label>
                            <input class="form-control" type="text" name="company_name" required
                                   value="{{ $employer->company_name }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">@lang('Company CEO')</label>
                            <input class="form-control" type="text" name="company_ceo" required
                                   value="{{ $employer->ceo_name }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Username') </label>
                            <input class="form-control" readonly value="{{ $employer->username }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Email') </label>
                            <input class="form-control" name="email" value="{{ $employer->email }}" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>@lang('Mobile Number')</label>
                        <div class="input-group ">
                            <span class="input-group-text mobile-code"></span>
                            <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile"
                                   class="form-control checkUser" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Website')</label>
                            <input class="form-control" type="url" name="website"
                                   value="{{ @$employer->website }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('FAX')</label>
                            <input class="form-control" type="text" name="fax" value="{{ @$employer->fax }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>@lang('Industry')</label>
                            <select class="form-control select2" name="industry" required>
                                <option selected disabled>@lang('Select One')</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}" @selected($industry->id == $employer->industry_id)>
                                        {{ __($industry->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>@lang('Number Of Employees')</label>
                            <select class="form-control select2" name="number_of_employees" required>
                                <option selected disabled>@lang('Select One')</option>
                                @foreach ($numberOfEmployees as $numberOfEmployee)
                                    <option value="{{ $numberOfEmployee->id }}" @selected($numberOfEmployee->id == $employer->number_of_employees_id)>
                                        {{ __($numberOfEmployee->employees) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>@lang('Founding Date')</label>
                            <input type="text" class="form-control" name="founding_date"
                                   value="{{ $employer->founding_date }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>@lang('Email Verification')</label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                   data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                   name="ev" @checked($employer->ev)>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>@lang('Mobile Verification')</label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                   data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                   name="sv" @checked($employer->sv)>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>@lang('2FA Verification') </label>
                            <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                   data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')"
                                   data-off="@lang('Disable')" name="ts" @checked($employer->ts)>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Address')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Address')</label>
                            <input class="form-control" type="text" name="address"
                                   value="{{ @$employer->address }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('City')</label>
                            <input class="form-control" type="text" name="city" value="{{ @$employer->city }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('State')</label>
                            <input class="form-control" type="text" name="state" value="{{ @$employer->state }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Zip/Postal')</label>
                            <input class="form-control" type="text" name="zip" value="{{ @$employer->zip }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Country')</label>
                            <select name="country" class="form-control select2">
                                @foreach ($countries as $key => $country)
                                    <option @selected(old('country', @$employer->country_code) == $key) data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Social Link')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Facebook')</label>
                            <input class="form-control" type="url" name="social_media[facebook]"
                                   value="{{ @$employer->social_media->facebook }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>@lang('Linkedin')</label>
                            <input class="form-control" type="url" name="social_media[linkedin]"
                                   value="{{ @$employer->social_media->linkedin }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>@lang('Twitter')</label>
                            <input class="form-control" type="url" name="social_media[twitter]"
                                   value="{{ @$employer->social_media->twitter }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>@lang('Instagram')</label>
                            <input class="form-control" type="url" name="social_media[instagram]"
                                   value="{{ @$employer->social_media->instagram }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>@lang('Pinterest')</label>
                            <input class="form-control" type="url" name="social_media[pinterest]"
                                   value="{{ @$employer->social_media->pinterest }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label>@lang('Telegram')</label>
                            <input class="form-control" type="url" name="social_media[telegram]"
                                   value="{{ @$employer->social_media->telegram }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Description')</h5>
            </div>
            <div class="card-body">
                <textarea name="description" class="nicEdit" rows="10">@php echo $employer->description; @endphp</textarea>
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
                        {{ $employer->status == Status::USER_ACTIVE ? trans('Ban Employer') : trans('Unban Employer') }}
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.employers.status', $employer->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($employer->status == Status::EMPLOYER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this employer he/she won\'t be able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $employer->ban_reason }}</p>
                            <h4 class="text-center mt-3">@lang('Are you sure to unban this employers?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($employer->status == Status::EMPLOYER_ACTIVE)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark"
                                    data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="addSubModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.employers.add.sub.balance', $employer->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control"
                                       placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.employers.login', $employer->id) }}" target="_blank"
       class="btn btn-sm btn-outline--primary">
        <i class="las la-sign-in-alt"></i>@lang('Login as Employer')
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
            "use strict";

            let foundingDate = `{{ @$employer->founding_date }}` ? `{{ showDateTime(@$employer->founding_date, 'm/d/Y') }}` : moment();

            $('input[name="founding_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1600,
                maxYear: parseInt(moment().format('YYYY'), 10),
                startDate: foundingDate,
                maxDate: moment(),
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('{{ @$employer->country_code }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $employer->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

            $('.bal-btn').on('click', function() {
                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            $('label[for=number_of_employees]').on('mousedown', function(e) {
                let select = $('select[name=number_of_employees]')[0];
                var evt = event;
                setTimeout(function() {
                    select.dispatchEvent(evt);
                });
            });
        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        .map iframe {
            width: 100%;
            max-height: 275px;
            border-radius: 6px;
        }

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
