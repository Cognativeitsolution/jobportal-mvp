@php
    $profileSettingContent = getContent('user_profile_setting.content', true);
@endphp
<div class="modal fade custom--modal fade-in-scale" id="employmentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Employment')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->employment_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->employment_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Company Name')</label>
                                <input type="text" class="form--control" name="company_name"
                                       value="{{ old('company_name') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Designation')</label>
                                <input type="text" class="form--control" name="designation"
                                       value="{{ old('designation') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Department')</label>
                                <input type="text" class="form--control" name="department"
                                       value="{{ old('department') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Is this your current employment?')</label>
                                <select name="currently_work" class="form--control select2"
                                        data-minimum-results-for-search="-1" required>
                                    <option value="{{ Status::YES }}">@lang('Yes')</option>
                                    <option value="{{ Status::NO }}">@lang('No')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Employment Type')</label>
                                <select name="type" class="form--control select2"
                                        data-minimum-results-for-search="-1" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                    @foreach ($types ?? [] as $type)
                                        <option value="{{ $type->id }}">
                                            {{ __($type->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 startDate">
                            <div class="form-group">
                                <label class="form--label">@lang('Joining Date')</label>
                                <input type="text" name="start_date" class="form--control date" autocomplete="off"
                                       value="{{ old('start_date') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6 endDate d-none">
                            <div class="form-group">
                                <label class="form--label">@lang('Worked Till')</label>
                                <input type="text" name="end_date" class="form--control date" autocomplete="off"
                                       value="{{ old('end_date') }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Responsibilities')</label>
                                <textarea type="text" class="form--control" name="responsibilities" required>{{ old('responsibilities') }}</textarea>
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

            $('.employmentBtn').on('click', function() {
                let modal = $('#employmentModal');
                let action = $(this).data('action');
                let employment = $(this).data('employment');
                modal.find('form').attr('action', action);
                modal.find('.modal-title').text($(this).data('title'));
                modal.find('[name="company_name"]').val(employment ? employment.company_name : '');
                modal.find('[name="designation"]').val(employment ? employment.designation : '');
                modal.find('[name="department"]').val(employment ? employment.department : '');
                modal.find('[name="start_date"]').val(employment ? employment.start_date : '');
                modal.find('[name="end_date"]').val(employment ? employment.end_date : '');
                modal.find('select[name="currently_work"]').val(employment ? employment.currently_work : {{ Status::YES }}).trigger('change');
                modal.find('select[name="type"]').val(employment ? employment.type_id : '').trigger('change');
                modal.find('[name="responsibilities"]').val(employment ? employment.responsibilities : '');
                modal.modal('show');
            })

            $('[name="currently_work"]').on('change', function() {
                let currentWork = $(this).val();
                if (currentWork == {{ Status::YES }}) {
                    $('.endDate').addClass('d-none');
                    $('[name="end_date"]').attr('required', false);
                    $('label[for="end_date"]').removeClass('required');
                    $('.startDate').removeClass('col-sm-6').addClass('col-sm-12');
                } else {
                    $('.endDate').removeClass('d-none');
                    $('[name="end_date"]').attr('required', true);
                    $('label[for="end_date"]').addClass('required');
                    $('.startDate').addClass('col-sm-6').removeClass('col-sm-12');
                }
            });
        })(jQuery)
    </script>
@endpush
