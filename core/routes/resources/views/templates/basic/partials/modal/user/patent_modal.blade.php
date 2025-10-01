<div class="modal fade custom--modal fade-in-scale" id="patentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Patent')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->patent_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->patent_message) }}
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('URL')</label>
                                <input type="url" class="form--control" name="url" value="{{ old('url') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Application Number')</label>
                                <input type="text" class="form--control" name="application_number"
                                    value="{{ old('application_number') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12 status">
                            <div class="form-group">
                                <label class="form--label">@lang('Status')</label>
                                <select name="status" class="form--control select2" data-minimum-results-for-search="-1" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    <option value="{{ Status::PATENT_ISSUED }}">@lang('Issued')</option>
                                    <option value="{{ Status::PATENT_PENDING }}">@lang('Pending')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 issuedDate d-none">
                            <div class="form-group">
                                <label class="form--label">@lang('Issued Date')</label>
                                <input type="text" class="form--control date" name="issued_date" value="{{ old('issued_date') }}" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-0">
                                <label class="form--label">@lang('Details')</label>
                                <textarea type="text" class="form--control" name="details" required>{{ old('details') }}</textarea>
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

            $('.patentBtn').on('click', function() {
                let patentModal = $('#patentModal');
                let patent = $(this).data('patent');
                patentModal.find('form').attr('action', $(this).data('action'));
                patentModal.find('.modal-title').text($(this).data('title'));
                patentModal.find('[name="title"]').val(patent ? patent.title : '');
                patentModal.find('[name="url"]').val(patent ? patent.url : '');
                patentModal.find('[name="application_number"]').val(patent ? patent.application_number : '');
                patentModal.find('[name="status"]').val(patent ? patent.status : '').trigger('change');
                patentModal.find('[name="issued_date"]').val(patent ? patent.issued_date : '');
                patentModal.find('[name="details"]').val(patent ? patent.details : '');
                patentModal.modal('show');
            });

            $('[name="status"]').on('change', function() {
                let currentWork = $(this).val();
                if (currentWork == {{ Status::PATENT_ISSUED }}) {
                    $('.issuedDate').removeClass('d-none');
                    $('[name="issued_date"]').attr('required', true);
                    $('label[for="issued_date"]').addClass('required');
                    $('.status').removeClass('col-sm-12').addClass('col-sm-6');
                } else {
                    $('.issuedDate').addClass('d-none');
                    $('[name="issued_date"]').attr('required', false);
                    $('label[for="issued_date"]').removeClass('required');
                    $('.status').addClass('col-sm-12').removeClass('col-sm-6');
                }
            });
        })(jQuery)
    </script>
@endpush
