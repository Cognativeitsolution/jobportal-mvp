<div class="modal fade custom--modal fade-in-scale" id="customConfirmationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Confirmation Alert!')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission w-100">
                @csrf
                <div class="modal-body">
                    <h6 class="modal-form__title plan-confirm-text">
                        <span class="modalQuestion"></span>
                    </h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary btn--md"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--base btn--md">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            'use strict';

            let customConfirmationModal = $('#customConfirmationModal');

            $('.customConfirmationBtn').on('click', function() {
                customConfirmationModal.find('form').attr('action', $(this).data('action'));
                customConfirmationModal.find('.modalQuestion').text($(this).data('question'));
                customConfirmationModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
