<div class="modal fade custom--modal fade-in-scale" id="skillModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Key Skills')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->skill_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->skill_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Skills')</label>
                                <select class="form--control select2-modal" name="skill_id" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}">
                                            {{ __($skill->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Expertise')</label>
                                <span class="input-group">
                                    <input type="number" class="form--control form-control" name="expertise" required>
                                    <span class="input-group-text">%</span>
                                </span>
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

            $('.skillBtn').on('click', function() {
                let skillModal = $('#skillModal');
                let userSkill = $(this).data('skill');
                skillModal.find('.modal-title').text($(this).data('title'));
                skillModal.find('form').attr('action', $(this).data('action'));
                skillModal.find('[name="skill_id"]').val(userSkill ? userSkill.skill_id : '').trigger('change');
                skillModal.find('[name="expertise"]').val(userSkill ? userSkill.expertise : '');
                skillModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
