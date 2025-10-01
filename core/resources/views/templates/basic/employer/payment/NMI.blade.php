@extends('Template::employer.layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-item wow fadeInUp" data-wow-duration="2s">
                <div class="card-item__header">
                    <h4 class="card-item__title">@lang('Confirm your payment via NMI')</h4>
                </div>
                <div class="card-item__inner">
                    <form role="form" class="disableSubmission appPayment" id="payment-form" method="{{ $data->method }}"
                        action="{{ $data->url }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Card Number')</label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control form--control" name="billing-cc-number"
                                            autocomplete="off" value="{{ old('billing-cc-number') }}" required autofocus />
                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Expiration Date')</label>
                                    <input type="tel" class="form--control" name="billing-cc-exp"
                                        value="{{ old('billing-cc-exp') }}" placeholder="e.g. MM/YY" autocomplete="off"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="form--label">@lang('CVC Code')</label>
                                    <input type="tel" class="form--control" name="billing-cc-cvv"
                                        value="{{ old('billing-cc-cvv') }}" autocomplete="off" required />
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--base w-100" type="submit"> @lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($deposit->from_api)
    @push('script')
        <script>
            (function($) {
                "use strict";

                $('.appPayment').on('submit', function() {
                    $(this).find('[type=submit]').html('<i class="las la-spinner fa-spin"></i>');
                })
            })(jQuery);
        </script>
    @endpush
@endif
