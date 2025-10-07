<div class="modal fade custom--modal fade-in-scale" id="itSkillModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('IT Skill')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->it_skill_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->it_skill_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Skill or Software Name')</label>
                                <input type="text" class="form--control" name="name" value="{{ old('name') }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Version')</label>
                                <input type="text" class="form--control" name="version" value="{{ old('version') }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Last Used')</label>
                                <select name="last_used" class="form--control select2-modal" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                    @for ($year = now()->year; $year > now()->year - 30; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <h6 class="m-0 my-2">@lang('Experience')</h6>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Year')</label>
                                <input type="number" name="year" class="form--control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Month')</label>
                                <input type="number" name="month" class="form--control" required>
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

            $('.itSkillBtn').on('click', function() {
                let itSkillModal = $('#itSkillModal');
                let userItSkill = $(this).data('user_it_skill');
                itSkillModal.find('form').attr('action', $(this).data('action'));
                itSkillModal.find('.modal-title').text($(this).data('title'));
                itSkillModal.find('[name="name"]').val(userItSkill ? userItSkill.name : '');
                itSkillModal.find('[name="version"]').val(userItSkill ? parseFloat(userItSkill.version).toFixed(2) : '');
                itSkillModal.find('[name="last_used"]').val(userItSkill ? userItSkill.last_used : '').trigger('change');
                itSkillModal.find('[name="year"]').val(userItSkill ? userItSkill.year : '');
                itSkillModal.find('[name="month"]').val(userItSkill ? userItSkill.month : '');
                itSkillModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
