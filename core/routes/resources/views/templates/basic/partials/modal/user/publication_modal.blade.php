<div class="modal fade custom--modal fade-in-scale" id="publicationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Publication')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->publication_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->publication_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Title')</label>
                                <input type="text" class="form--control" name="title" value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('URL')</label>
                                <input type="url" class="form--control" name="url" value="{{ old('url') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Published Date')</label>
                                <input type="text" class="form--control date" name="published_date" value="{{ old('published_date') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Details')</label>
                                <textarea class="form--control" name="publication_details" required>{{ old('publication_details') }}</textarea>
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

            $('.publicationBtn').on('click', function() {
                let publicationData = $(this).data('publication');
                let publicationModal = $('#publicationModal');
                publicationModal.find('form').attr('action', $(this).data('action'));
                publicationModal.find('.modal-title').text($(this).data('title'));
                publicationModal.find('[name="title"]').val(publicationData ? publicationData.title : '');
                publicationModal.find('[name="url"]').val(publicationData ? publicationData.url : '');
                publicationModal.find('[name="published_date"]').val(publicationData ? publicationData.published_date : '');
                publicationModal.find('[name="publication_details"]').val(publicationData ? publicationData.publication_details : '');
                publicationModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
