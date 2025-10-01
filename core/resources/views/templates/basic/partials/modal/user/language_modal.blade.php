<div class="modal fade custom--modal fade-in-scale" id="languageModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Language')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->language_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->language_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Language')</label>
                                <input type="text" class="form--control" name="name" value="{{ old('name') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Proficiency')</label>
                                <select name="proficiency" class="form--control select2"
                                    data-minimum-results-for-search="-1" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                    <option value="{{ status::LANGUAGE_BEGINNER }}">@lang('Beginner')</option>
                                    <option value="{{ Status::LANGUAGE_PROFICIENT }}">@lang('Proficient')</option>
                                    <option value="{{ Status::LANGUAGE_EXPERT }}">@lang('Expert')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <h6 class="mb-3">@lang('Expertise')</h6>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form--check">
                                    <input class="form-check-input" type="checkbox" id="is_read"
                                        @checked(old('is_read')) name="is_read">
                                    <label class="form-check-label form--label" for="is_read">@lang('Read')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form--check">
                                    <input class="form-check-input" type="checkbox" id="is_write"
                                        @checked(old('is_write')) name="is_write">
                                    <label class="form-check-label form--label" for="is_write">@lang('Write')</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form--check">
                                    <input class="form-check-input" type="checkbox" id="is_speak"
                                        @checked(old('is_speak')) name="is_speak">
                                    <label class="form-check-label form--label"
                                        for="is_speak">@lang('Speak')</label>
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

            $('.languageBtn').on('click', function() {
                let languageModal = $('#languageModal');
                let userLanguage = $(this).data('user_language');

                languageModal.find('form').attr('action', $(this).data('action'));
                languageModal.find('[name="name"]').val(userLanguage ? userLanguage.name : '');
                languageModal.find('[name="proficiency"]').val(userLanguage ? userLanguage.proficiency : '')
                    .trigger('change');
                languageModal.find('[name="is_read"]').prop('checked', userLanguage.is_read ? true : false);
                languageModal.find('[name="is_write"]').prop('checked', userLanguage.is_write ? true : false);
                languageModal.find('[name="is_speak"]').prop('checked', userLanguage.is_speak ? true : false);
                languageModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
