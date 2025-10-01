<div class="modal fade custom--modal fade-in-scale" id="projectModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Project')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->project_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->project_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Title')</label>
                                <input type="text" class="form--control" name="title" value="{{ old('title') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Project Link')</label>
                                <input type="url" class="form--control" name="link" value="{{ old('link') }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Details')</label>
                                <textarea type="text" class="form--control" name="details" required>{{ old('details') }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Duration')</label>
                                <div class="input-group">
                                    <input type="number" class="form--control form-control" name="duration"
                                        value="{{ old('duration') }}" required>
                                    <span class="input-group-text">@lang('Month')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Status')</label>
                                <select name="status" class="form--control select2"
                                    data-minimum-results-for-search="-1" required>
                                    <option value="">@lang('Select One')</option>
                                    <option value="{{ Status::PROJECT_RUNNING }}">@lang('Running')</option>
                                    <option value="{{ Status::PROJECT_COMPLETED }}">@lang('Completed')</option>
                                </select>
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

            $('.projectBtn').on('click', function() {
                let projectModal = $('#projectModal');
                let project = $(this).data('project');
                projectModal.find('form').attr('action', $(this).data('action'));
                projectModal.find('.modal-title').text($(this).data('title'));
                projectModal.find('[name="title"]').val(project ? project.title : '');
                projectModal.find('[name=link]').val(project ? project.link : '');
                projectModal.find('[name=details]').val(project ? project.details : '');
                projectModal.find('[name=duration]').val(project ? parseInt(project.duration) : '');
                projectModal.find('[name="status"]').val(project ? project.status : '').trigger('change');
                projectModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
