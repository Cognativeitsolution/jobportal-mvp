<div class="modal fade custom--modal fade-in-scale" id="certificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Certification')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->certification_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->certification_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Certification Name')</label>
                                <input type="text" class="form--control" name="name" value="{{ old('name') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Institute')</label>
                                <input type="text" class="form--control" name="institute" value="{{ old('institute') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Location')</label>
                                <input type="text" class="form--control" name="location"
                                    value="{{ old('location') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Duration')</label>
                                <div class="input-group">
                                    <input type="number" class="form--control form-control" name="duration" value="{{ old('duration') }}" />
                                    <div class="input-group-text">@lang('Month')</div>
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

            $('.certificationBtn').on('click', function() {
                let certificationModal = $('#certificationModal');
                let certification = $(this).data('certification');
                certificationModal.find('form').attr('action', $(this).data('action'));
                certificationModal.find('.modal-title').text($(this).data('title'));
                certificationModal.find('[name="name"]').val(certification ? certification.name : '');
                certificationModal.find('[name="institute"]').val(certification ? certification.institute : '');
                certificationModal.find('[name="location"]').val(certification ? certification.location : '');
                certificationModal.find('[name="duration"]').val(certification ? certification.duration : '');
                certificationModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
