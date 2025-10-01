<div class="modal fade custom--modal fade-in-scale" id="presentationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Presentation')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->presentation_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->presentation_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Title')</label>
                                <input type="text" class="form--control" name="title"
                                    value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('URL')</label>
                                <input type="url" class="form--control" name="url"
                                    value="{{ old('url') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Description')</label>
                                <textarea type="text" class="form--control" name="description" required>{{ old('description') }}</textarea>
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

            $('.presentationBtn').on('click', function() {
                let presentationModal = $('#presentationModal');
                let presentation = $(this).data('presentation');
                presentationModal.find('form').attr('action', $(this).data('action'));
                presentationModal.find('.modal-title').text($(this).data('title'));
                presentationModal.find('[name="title"]').val(presentation ? presentation.title : '');
                presentationModal.find('[name="url"]').val(presentation ? presentation.url : '');
                presentationModal.find('[name="description"]').val(presentation ? presentation.description : '');
                presentationModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
