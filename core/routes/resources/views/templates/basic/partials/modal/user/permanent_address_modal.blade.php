<div class="modal fade custom--modal fade-in-scale" id="permanentAddressModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Permanent Address')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.permanent.address.update') }}" method="POST"
                class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Address')</label>
                                <input type="text" class="form--control" name="address"
                                    value="{{ old('address', @$user->permanent_address['address']) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('State')</label>
                                <input type="text" class="form--control" name="state"
                                    value="{{ old('state', @$user->permanent_address['state']) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('City')</label>
                                <input type="text" class="form--control" name="city"
                                    value="{{ old('city', @$user->permanent_address['city']) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Zip')</label>
                                <input type="text" class="form--control" name="zip"
                                    value="{{ old('zip', @$user->permanent_address['zip']) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Country')</label>
                                <select name="country" class="form--control select2-modal" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($countries as $key => $country)
                                        <option value="{{ $country->country }}" @selected(old('country', @$user->permanent_address['country']) == $country->country)>
                                            {{ __($country->country) }}
                                        </option>
                                    @endforeach
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

            $('.permanentAddressBtn').on('click', function() {
                let permanentAddressModal = $('#permanentAddressModal');
                permanentAddressModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
