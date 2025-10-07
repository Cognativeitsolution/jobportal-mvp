@php
    $profileSettingContent = getContent('user_profile_setting.content', true);
@endphp
<div class="modal fade custom--modal fade-in-scale" id="educationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Education')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->education_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->education_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Level of Education')</label>
                                <select name="education_level_id" class="form--control select2" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}"
                                                data-degrees="{{ $level->educationDegrees }}">{{ __($level->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Exam/Degree')</label>
                                <select name="education_degree_id" class="form--control select2" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('University/Institute')</label>
                                <input type="text" class="form--control" name="institute"
                                       value="{{ old('institute') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Major/Group')</label>
                                <select name="education_group_id" class="form--control select2" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ __($group->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('CGPA/Marks')</label>
                                <input type="number" step="any" class="form--control" name="cgpa_or_marks"
                                       value="{{ old('cgpa_or_marks') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Scale')</label>
                                <input type="number" class="form--control" name="scale" value="{{ old('scale') }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Duration')</label>
                                <div class="input-group">
                                    <input type="number" class="form--control form-control" name="duration"
                                           value="{{ old('duration') }}" required>
                                    <span class="input-group-text">@lang('Year')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Passing Year')</label>
                                <input type="number" class="form--control" name="passing_year"
                                       value="{{ old('passing_year') }}" required>
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

            $('.educationBtn').on('click', function() {
                let modal = $('#educationModal');
                let education = $(this).data('education');
                modal.find('form').attr('action', $(this).data('action'));
                modal.find('.modal-title').text($(this).data('title'));
                modal.find('[name="education_level_id"]').val(education ? education.education_level_id : '').trigger('change');
                modal.find('[name="education_degree_id"]').val(education ? education.education_degree_id : '').trigger('change');
                modal.find('[name="institute"]').val(education ? education.institute : '');
                modal.find('[name="education_group_id"]').val(education ? education.education_group_id : '').trigger('change');
                modal.find('[name="cgpa_or_marks"]').val(education ? education.cgpa_or_marks : '');
                modal.find('[name="scale"]').val(education ? education.scale : '');
                modal.find('[name="duration"]').val(education ? education.duration : '');
                modal.find('[name="passing_year"]').val(education ? education.passing_year : '');
                modal.modal('show');
            })

            $('[name="education_level_id"]').on('change', function() {
                let degrees = $(this).find(':selected').data('degrees');
                const degreeDropdown = $('select[name="education_degree_id"]');
                degreeDropdown.empty().append('<option value="" disabled selected>@lang('Select One')</option>');
                if (degrees && degrees.length > 0) {
                    degrees.forEach(degree => {
                        degreeDropdown.append(`<option value="${degree.id}">${degree.name}</option>`);
                    });
                }
                degreeDropdown.trigger('change');
            });
        })(jQuery)
    </script>
@endpush
