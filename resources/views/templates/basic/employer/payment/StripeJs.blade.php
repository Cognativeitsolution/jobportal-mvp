@extends('Template::employer.layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-item wow fadeInUp" data-wow-duration="2s">
                <div class="card-item__header">
                    <h4 class="card-item__title">@lang('Confirm your payment via stripe storefront')</h4>
                </div>
                <div class="card-item__inner">
                    <form action="{{ $data->url }}" method="{{ $data->method }}">
                        <ul class="list-group text-center list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                @lang('You have to pay '):
                                <strong>{{ showAmount($deposit->final_amount, currencyFormat: false) }}
                                    {{ __($deposit->method_currency) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                @lang('You will get '):
                                <strong>{{ showAmount($deposit->amount) }}</strong>
                            </li>
                        </ul>
                        <script src="{{ $data->src }}" class="stripe-button"
                            @foreach ($data->val as $key => $value)
                            data-{{ $key }}="{{ $value }}" @endforeach>
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="https://js.stripe.com/v3/"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('button[type="submit"]').removeClass().addClass("btn btn--base w-100 mt-3").text("Pay Now");
        })(jQuery);
    </script>
@endpush
