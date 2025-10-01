<div class="modal fade custom--modal fade-in-scale" id="careerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Career Profile')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.career.profile.update') }}" method="POST"
                class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Current Industry')</label>
                                <select name="industry_id" class="form--control select2-modal">
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" @selected(old('industry_id', @$user->industry_id) == $industry->id)>
                                            {{ __($industry->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Department')</label>
                                <select name="department_id" class="form--control select2-modal">
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @selected(old('department_id', @$user->department_id) == $department->id)>
                                            {{ __($department->title) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Desired Job Type')</label>
                                <select name="desired_job_type" class="form--control select2"
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Desired Employment Type')</label>
                                <select name="type_id" class="form--control select2"
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Preferred Shift')</label>
                                <select name="shift_id" class="form--control select2"
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Preferred Location')</label>
                                <select name="location_id" class="form--control select2-modal">
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" @selected(old('location_id', @$user->location_id) == $city->id)>
                                            {{ __($city->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Expected Salary')</label>
                                <div class="input-group">
                                    <input type="number" class="form--control form-control" name="expected_salary"
                                    value="{{ old('expected_salary', getAmount(@$user->expected_salary)) }}" required/>
                                    <div class="input-group-text">{{ gs('cur_text') }}</div>
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

            $('.careerBtn').on('click', function() {
                let careerModal = $('#careerModal');
                careerModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
