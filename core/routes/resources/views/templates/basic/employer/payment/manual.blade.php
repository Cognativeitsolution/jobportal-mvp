@extends('Template::employer.layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-item wow fadeInUp" data-wow-duration="2s">
                <div class="card-item__header">
                    <h4 class="card-item__title">{{ __($pageTitle) }}</h4>
                </div>
                <div class="card-item__inner">
                    <form action="{{ route('employer.deposit.manual.update') }}" method="POST" class="disableSubmission"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert--custom mb-4 alert--dark" role="alert">
                                    <p class="text--black">
                                        <i class="las la-info-circle"></i> @lang('You are requesting')
                                        <b>{{ showAmount($data['amount']) }}</b> @lang('to deposit.')
                                        @lang('Please pay')
                                        <b>{{ showAmount($data['final_amount'], currencyFormat: false) . ' ' . $data['method_currency'] }}
                                        </b> @lang('for successful payment.')
                                    </p>
                                </div>
                                <div class="mb-3">@php echo  $data->gateway->description @endphp</div>
                            </div>
                            <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
