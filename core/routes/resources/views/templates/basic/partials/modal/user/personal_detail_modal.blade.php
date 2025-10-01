<div class="modal fade custom--modal fade-in-scale" id="personalDetailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Personal Information')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.personal.details.update') }}" method="POST"
                class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Gender')</label>
                                <select name="gender" class="form-control select2" data-minimum-results-for-search="-1"
                                    required>
                                    <option value="">@lang('Select One')</option>
                                    <option value="{{ Status::MALE }}" @selected(old('gender', @$user->gender) == Status::MALE)>
                                        @lang('Male')
                                    </option>
                                    <option value="{{ Status::FEMALE }}" @selected(old('gender', @$user->gender) == Status::FEMALE)>
                                        @lang('Female')
                                    </option>
                                    <option value="{{ Status::OTHERS }}" @selected(old('gender', @$user->gender) == Status::OTHERS)>
                                        @lang('Others')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Marital Status')</label>
                                <select name="married_status" class="form-control select2"
                                    data-minimum-results-for-search="-1" required>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Career Break')</label>
                                <select name="career_break" class="form-control select2"
                                    data-minimum-results-for-search="-1" required>
                                    <option value="{{ Status::NO }}" @selected(old('career_break', @$user->career_break) == Status::NO)>
                                        @lang('No')
                                    </option>
                                    <option value="{{ Status::YES }}" @selected(old('career_break', @$user->career_break) == Status::YES)>
                                        @lang('Yes')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Date of Birth')</label>
                                <input type="text" class="form--control date" name="birth_date"
                                value="{{ old('birth_date', @$user->birth_date) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Blood Group')</label>
                                <select name="blood_group" class="form-control select2"
                                    data-minimum-results-for-search="-1" required>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('National ID')</label>
                                <input type="text" name="national_id" class="form--control"
                                    value="{{ old('national_id', @$user->national_id) }}">
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

            $('.personalDetailBtn').on('click', function() {
                let birthDate = `{{ old('birth_date', @$user->birth_date) }}`;
                let personalDetailModal = $('#personalDetailModal');
                personalDetailModal.find('[name="birth_date"]').val(birthDate != '' ? birthDate : '');
                personalDetailModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
