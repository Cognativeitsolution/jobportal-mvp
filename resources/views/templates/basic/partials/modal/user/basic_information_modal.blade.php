<div class="modal fade custom--modal fade-in-scale" id="basicDetailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Basic details')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.basic.details.update') }}" method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="form--label">@lang('First Name')</label>
                            <input type="text" class="form--control" name="firstname" value="{{ $user->firstname }}"
                                required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form--label">@lang('Last Name')</label>
                            <input type="text" class="form--control" name="lastname" value="{{ $user->lastname }}"
                                required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form--label">@lang('Email')</label>
                            <input type="text" class="form--control" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form--label">@lang('Mobile')</label>
                            <input type="text" class="form--control" value="{{ $user->mobileNumber }}" readonly>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form--label">@lang('Work Status')</label>
                            <select class="select2 form--control" data-minimum-results-for-search="-1"
                                name="work_status" required>
                                <option value="{{ Status::WORK_STATUS_FRESHER }}" @selected(old('work_status', @$user->work_status) == Status::WORK_STATUS_FRESHER)>
                                    @lang('Fresher')
                                </option>
                                <option value="{{ Status::WORK_STATUS_EXPERIENCE }}" @selected(old('work_status', @$user->work_status) == Status::WORK_STATUS_EXPERIENCE)>
                                    @lang('Experienced')
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form--label">@lang('Availability To Job')</label>
                            <select class="select2 form--control" data-minimum-results-for-search="-1"
                                name="available_to_job" required>
                                <option value="{{ Status::IMMEDIATE }}" @selected(old('available_to_job', @$user->available_to_job) == Status::IMMEDIATE)>
                                    @lang('Immediate')
                                </option>
                                <option value="{{ Status::ONE_MONTH }}" @selected(old('available_to_job', @$user->available_to_job) == Status::ONE_MONTH)>
                                    @lang('One Month')
                                </option>
                                <option value="{{ Status::TWO_MONTH }}" @selected(old('available_to_job', @$user->available_to_job) == Status::TWO_MONTH)>
                                    @lang('Two Month')
                                </option>
                                <option value="{{ Status::MORE_THEN_TWO_MONTH }}" @selected(old('available_to_job', @$user->available_to_job) == Status::MORE_THEN_TWO_MONTH)>
                                    @lang('More Then Two Month')
                                </option>
                            </select>
                        </div>
                        <div class="col-12 experience d-none">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label class="form--label">@lang('Designation')</label>
                                    <input class="form--control" type="text" name="designation"
                                        value="{{ old('designation', @$user->designation) }}">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="form--label">@lang('Current Salary')</label>
                                    <div class="input-group">
                                        <input class="form--control form-control" type="number" name="current_salary"
                                            value="{{ old('current_salary', @$user->current_salary) }}">
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="m-0 my-3">@lang('Total Experience')</h6>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="form--label">@lang('Year')</label>
                                    <div class="input-group">
                                        <input class="form--control form-control" type="number"
                                            name="year_of_experience"
                                            value="{{ old('year_of_experience', @$user->year_of_experience) }}">
                                        <span class="input-group-text">@lang('Year')</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="form--label">@lang('Month')</label>
                                    <div class="input-group">
                                        <input class="form--control form-control" type="number"
                                            name="month_of_experience"
                                            value="{{ old('month_of_experience', @$user->month_of_experience) }}">
                                        <span class="input-group-text">@lang('Month')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            'use strict';

            $('[name="work_status"]').on('change', function() {
                updateBasicDetailsModal($(this).val());
            });

            updateBasicDetailsModal($('[name="work_status"]').val());

            function updateBasicDetailsModal(workStatus) {
                if (workStatus == {{ Status::WORK_STATUS_EXPERIENCE }}) {
                    $('.experience').removeClass('d-none');
                    $('[name="designation"], [name="year_of_experience"], [name="month_of_experience"], [name="current_salary"]')
                        .attr('required', true);
                    $('label[for="year_of_experience"], label[for="month_of_experience"], label[for="current_salary"], label[for="designation"]')
                        .addClass('required');
                } else {
                    $('[name="year_of_experience"], [name="month_of_experience"], [name="current_salary"], [name="designation"]')
                        .attr('required', false);
                    $('label[for="year_of_experience"], label[for="month_of_experience"], label[for="current_salary"], label[for="designation"]')
                        .removeClass('required');
                    $('.experience').addClass('d-none');
                }
            }
        })(jQuery)
    </script>
@endpush
