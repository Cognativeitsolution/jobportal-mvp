<div class="modal fade custom--modal fade-in-scale" id="presentAddressModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Present Address')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.present.address.update') }}" method="POST"
                class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Address')</label>
                                <input type="text" class="form--control" name="address"
                                    value="{{ old('address', @$user->address) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('State')</label>
                                <input type="text" class="form--control" name="state"
                                    value="{{ old('state', @$user->state) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('City')</label>
                                <input type="text" class="form--control" name="city"
                                    value="{{ old('city', @$user->city) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Zip')</label>
                                <input type="text" class="form--control" name="zip"
                                    value="{{ old('zip', @$user->zip) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Country')</label>
                                <input type="text" class="form--control" value="{{ $user->country_name }}" disabled>
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

            $('.presentAddressBtn').on('click', function() {
                let presentAddressModal = $('#presentAddressModal');
                presentAddressModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
