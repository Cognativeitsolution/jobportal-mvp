@extends('Template::employer.layouts.master')
@php $employer = authUser('employer');@endphp
@section('content')
    @if ($employer->subscription_status == Status::SUBSCRIPTION_APPROVED)
        <div class="alert alert--custom alert--info mb-4" role="alert">
            <div class="alert__icon">
                <i class="las la-info-circle"></i>
            </div>
            <div class="alert__content">
                <p>
                    @lang('Currently you have a limit of')
                    {{ @$employer->job_post_count ?? 0 }} @lang('job post')
                </p>
            </div>
        </div>
    @else
        @if (gs('free_job_post') && @$employer->free_job_post_limit)
            <div class="alert alert--custom alert--info mb-4" role="alert">
                <div class="alert__icon">
                    <i class="las la-info-circle"></i>
                </div>
                <div class="alert__content">
                    <p>
                        @lang('You are able to post up to') {{ @$employer->free_job_post_limit }} @lang('job free of charge')
                    </p>
                </div>
            </div>
        @endif
        @if (!(gs('free_job_post') && @$employer->free_job_post_limit) && gs('job_post_payment'))
            <div class="alert alert--custom alert--info mb-4" role="alert">
                <div class="alert__icon">
                    <i class="las la-info-circle"></i>
                </div>
                <div class="alert__content">
                    <p>
                        @lang('If you don\'t have a subscription plan, a') {{ showAmount(gs('fee_per_job_post')) }} @lang('fee applies per job post. We recommend subscribing to a plan for more benefits and exclusive offers')
                    </p>
                </div>
            </div>
        @endif
    @endif
    @if ($plans->count())
        <div class="row justify-content-center">
            <div class="col-xxl-12">
                <div class="row justify-content-center gy-4">
                    @foreach ($plans as $plan)
                        <div class="col-xxl-3 col-sm-6">
                            <div class="plan-card {{ $plan->subscriptions->count() ? 'active_plan' : '' }}">
                                <div class="plan-card__header">
                                    <div class="flex-between gap-2 mb-3">
                                        <h6 class="plan-card__name">
                                            {{ __($plan->name) }}
                                        </h6>
                                        <div class="plan-card__badge">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-gem-icon lucide-gem">
                                                <path d="M6 3h12l4 6-10 13L2 9Z" />
                                                <path d="M11 3 8 9l4 13 4-13-3-6" />
                                                <path d="M2 9h20" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="plan-card__price">
                                        {{ gs('cur_sym') }}{{ showAmount($plan->price, currencyFormat: false) }}
                                        <span class="plan-card__duration">
                                            / {{ __($plan->duration) }} @lang('month')
                                        </span>
                                    </h3>
                                </div>
                                <p class="plan-card__text">
                                    <span class="plan-card__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-disc-icon lucide-disc">
                                            <circle cx="12" cy="12" r="10" />
                                            <circle cx="12" cy="12" r="2" />
                                        </svg>
                                    </span>
                                    @lang('You can post') {{ $plan->job_post }} @lang('jobs after subscribe this.')
                                </p>
                                <div class="plan-card__footer">
                                    @if (!$plan->subscriptions->count())
                                        <button class="btn btn--base subscribeBtn w-100"
                                            data-action="{{ route('employer.deposit.insert', $plan->id) }}"
                                            data-amount="{{ getAmount($plan->price) }}" type="button">
                                            @lang('Subscribe')
                                        </button>
                                    @else
                                        <button class="btn btn--success w-100" type="button">
                                            @lang('Subscribed')
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="company-profile-wrapper">
            <div class="card-item wow fadeInUp" data-wow-duration="2s">
                @include('Template::partials.empty', ['message' => 'No subscription plan found.'])
            </div>
        </div>
    @endif

    <div class="modal fade custom--modal fade-in-scale" id="subscribeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Plan Subscription')</h6>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="deposit-form" method="post">
                        @csrf
                        <input name="currency" type="hidden">
                        <div class="gateway-card">
                            <div class="row justify-content-center">
                                <div class="col-md-5 col-xl-6">
                                    <div class="payment-system-list is-scrollable gateway-option-list">
                                        @foreach ($gatewayCurrency as $data)
                                            <label
                                                class="payment-item @if ($loop->index > 4) d-none @endif gateway-option"
                                                for="{{ titleToKey($data->name) }}">
                                                <span class="payment-check d-none">
                                                    <input class="payment-item__radio gateway-input"
                                                        id="{{ titleToKey($data->name) }}" name="gateway"
                                                        data-gateway='@json($data)'
                                                        data-min-amount="{{ showAmount($data->min_amount) }}"
                                                        data-max-amount="{{ showAmount($data->max_amount) }}"
                                                        type="radio" value="{{ $data->method_code }}"
                                                        @checked(old('gateway', $loop->first) == $data->method_code)>
                                                </span>
                                                <span class="payment-item__right">
                                                    <span class="payment-item__info">
                                                        <span class="payment-item__check"></span>
                                                        <span class="payment-item__name">{{ __($data->name) }}</span>
                                                    </span>
                                                    <span class="payment-item__thumb">
                                                        <img class="payment-item__thumb-img"
                                                            src="{{ getImage(getFilePath('gateway') . '/' . $data->method->image) }}"
                                                            alt="@lang('payment-thumb')">
                                                    </span>
                                                </span>
                                            </label>
                                        @endforeach
                                        @if ($gatewayCurrency->count() > 4)
                                            <button class="payment-item__btn more-gateway-option" type="button">
                                                @lang('See More')
                                                <span class="icon"><i class="la la-arrow-down"></i></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7 col-xl-6">
                                    <div class="payment-system-list p-3">
                                        <div class="deposit-info">
                                            <div class="deposit-info__title">
                                                <p class="text mb-0">@lang('Amount')</p>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text fw-semibold">
                                                    <span class="view_amount fw-semibold"></span>
                                                    {{ gs('cur_text') }}
                                                </p>
                                            </div>
                                            <input class="form--control amount" name="amount" type="text"
                                                value="" hidden placeholder="@lang('00.00')"
                                                autocomplete="off">
                                        </div>
                                        <hr>
                                        <div class="deposit-info">
                                            <div class="deposit-info__title">
                                                <p class="text has-icon"> @lang('Limit')</p>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text"><span class="gateway-limit">@lang('0.00')</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="deposit-info">
                                            <div class="deposit-info__title">
                                                <p class="text has-icon">@lang('Charge')
                                                    <span class="proccessing-fee-info" data-bs-toggle="tooltip"
                                                        title="@lang('Processing charge for payment method')"><i class="las la-info-circle"></i>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text">
                                                    {{ gs('cur_sym') }}
                                                    <span class="processing-fee">@lang('0.00')</span>
                                                    {{ __(gs('cur_text')) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="deposit-info total-amount pt-3">
                                            <div class="deposit-info__title">
                                                <p class="text">@lang('Receivable')</p>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text">{{ gs('cur_sym') }}<span
                                                        class="final-amount">@lang('0.00')</span>
                                                    {{ __(gs('cur_text')) }}</p>
                                            </div>
                                        </div>
                                        <div class="deposit-info gateway-conversion d-none total-amount pt-2">
                                            <div class="deposit-info__title">
                                                <p class="text">@lang('Conversion')
                                                </p>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text"></p>
                                            </div>
                                        </div>
                                        <div class="deposit-info conversion-currency d-none total-amount pt-2">
                                            <div class="deposit-info__title">
                                                <p class="text">
                                                    @lang('In') <span class="gateway-currency"></span>
                                                </p>
                                            </div>
                                            <div class="deposit-info__input">
                                                <p class="text">
                                                    <span class="in-currency"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <button class="btn btn--base w-100" type="submit" disabled>
                                            @lang('Confirm Payment')
                                        </button>
                                        <div class="info-text pt-3">
                                            <p class="text">
                                                @lang('Ensure your payment is secure with our world-class payment options and a trusted payment process.')
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';

            var amount = parseFloat($('.amount').val() || 0);
            var gateway, minAmount, maxAmount;

            $('.subscribeBtn').on('click', function() {
                let modal = $('#subscribeModal');
                modal.find('form').attr('action', $(this).data('action'));
                amount = $(this).data('amount');
                modal.find('[name="amount"]').val(amount);
                modal.find('.view_amount').text(amount);
                gatewayChange();
                modal.modal('show');
            });

            $('.amount').on('input', function(e) {
                amount = parseFloat($(this).val());
                if (!amount) {
                    amount = 0;
                }
                calculation();
            });

            $('.gateway-input').on('change', function(e) {
                gatewayChange();
            });

            function gatewayChange() {
                let gatewayElement = $('.gateway-input:checked');
                let methodCode = gatewayElement.val();

                gateway = gatewayElement.data('gateway');
                minAmount = gatewayElement.data('min-amount');
                maxAmount = gatewayElement.data('max-amount');

                let processingFeeInfo =
                    `${parseFloat(gateway.percent_charge).toFixed(2)}% with ${parseFloat(gateway.fixed_charge).toFixed(2)} {{ __(gs('cur_text')) }} charge for payment gateway processing fees`
                $(".proccessing-fee-info").attr("data-bs-original-title", processingFeeInfo);
                calculation();
            }

            $(".more-gateway-option").on("click", function(e) {
                let paymentList = $(".gateway-option-list");
                paymentList.find(".gateway-option").removeClass("d-none");
                $(this).addClass('d-none');
                paymentList.animate({
                    scrollTop: (paymentList.height() - 60)
                }, 'slow');
            });

            function calculation() {
                if (!gateway) return;
                $(".gateway-limit").text(minAmount + " - " + maxAmount);

                let percentCharge = 0;
                let fixedCharge = 0;
                let totalPercentCharge = 0;

                if (amount) {
                    percentCharge = parseFloat(gateway.percent_charge);
                    fixedCharge = parseFloat(gateway.fixed_charge);
                    totalPercentCharge = parseFloat(amount / 100 * percentCharge);
                }

                let totalCharge = parseFloat(totalPercentCharge + fixedCharge);
                let totalAmount = parseFloat((amount || 0) + totalPercentCharge + fixedCharge);

                $(".final-amount").text(totalAmount.toFixed(2));
                $(".processing-fee").text(totalCharge.toFixed(2));
                $("input[name=currency]").val(gateway.currency);
                $(".gateway-currency").text(gateway.currency);

                if (amount < Number(gateway.min_amount) || amount > Number(gateway.max_amount)) {
                    console.log(amount);

                    $(".deposit-form button[type=submit]").attr('disabled', true);
                } else {
                    $(".deposit-form button[type=submit]").removeAttr('disabled');
                }

                if (gateway.currency != "{{ gs('cur_text') }}" && gateway.method.crypto != 1) {
                    $('.deposit-form').addClass('adjust-height')

                    $(".gateway-conversion, .conversion-currency").removeClass('d-none');
                    $(".gateway-conversion").find('.deposit-info__input .text').html(
                        `1 {{ __(gs('cur_text')) }} = <span class="rate">${parseFloat(gateway.rate).toFixed(2)}</span>  <span class="method_currency">${gateway.currency}</span>`
                    );
                    $('.in-currency').text(parseFloat(totalAmount * gateway.rate).toFixed(gateway.method
                        .crypto == 1 ?
                        8 : 2))
                } else {
                    $(".gateway-conversion, .conversion-currency").addClass('d-none');
                    $('.deposit-form').removeClass('adjust-height')
                }

                if (gateway.method.crypto == 1) {
                    $('.crypto-message').removeClass('d-none');
                } else {
                    $('.crypto-message').addClass('d-none');
                }
            }

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            $('.gateway-input').change();
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .btn.disabled,
        .btn:disabled,
        fieldset:disabled .btn {
            background: #16C79A;
        }

        .form--control[readonly] {
            background: transparent;
        }

        .card-item {
            padding: 30px;
            transition: .3s linear;
            position: relative;
            height: 100%;
            box-shadow: none;
            border: 1px solid hsl(var(--border-color)/.7);
        }

        .card-item.plan-card:hover {
            box-shadow: 0px 1.98px 5.93px 0px #0D0A2C14;
            background-color: hsl(var(--base)/.1) !important;
            border-color: hsl(var(--base)/.3);
        }

        @media (max-width:1399px) {
            .card-item {
                padding: 20px;
            }
        }

        .package-card__top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .package-card__name {
            margin-bottom: 10px;
            font-weight: 500;
        }

        .plan-card .icon {
            font-size: 50px;
            color: hsl(var(--heading-color));
            position: absolute;
            top: 15px;
            right: 20px;
            opacity: .1;
            line-height: 1;
        }

        .plan-card:hover .package-card__btn .btn {
            color: hsl(var(--white)) !important;
            background-color: hsl(var(--base)) !important;
        }

        .package-card__btn {
            margin-top: 20px;
        }

        .package-card__btn .btn {
            background: hsl(var(--base)/.1) !important;
            color: hsl(var(--base)) !important;
            border: 1px solid hsl(var(--base)/.20);
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
        }

        .card-item .content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-item__inner .content .badge--base {
            background: hsl(var(--base)) !important;
            color: hsl(var(--white)) !important;
        }

        .card-item__right .sub {
            color: hsl(var(--black)/.6);
            font-weight: 500;
            font-size: 16px;
        }

        .package-card__item:not(:last-child) {
            margin-bottom: 10px;
        }

        .package-card__price {
            margin-bottom: 0px;
            line-height: 1;
            font-weight: 600;
            transition: .3s linear;
            text-wrap-mode: nowrap;
        }

        @media (max-width: 1399px) {
            .package-card__price {
                font-size: 32px;
            }
        }

        .card-item__right {
            text-align: right;
        }

        .package-card__icon {
            font-size: 20px;
            line-height: 1;
            transition: .3s linear;
        }

        .package-card__item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--heading-font);
            font-weight: 500;
            font-size: 16px;
        }

        .content__subtitle {
            font-weight: 500;
            font-size: 16px;
        }

        .active_plan {
            background-color: hsl(var(--base)/.1) !important;
            border-color: hsl(var(--base)/.3);
        }

        .active_plan .plan-card__header {
            padding: 10px;
            background-color: hsl(var(--base) / .1);
            border-radius: 8px;
            border: 1px solid hsl(var(--base) / .1);
        }

        .active_plan .plan-card__footer {
            border-color: hsl(var(--base) / .2);
        }

        .active_plan .btn {
            background: hsl(var(--base)) !important;
            color: hsl(var(--white)) !important;
        }

        .active_plan .plan-card__price {
            color: hsl(var(--base)) !important;
        }

        .card-item__inner {
            justify-content: space-between;
            gap: 10px 20px;
            display: flex;
        }

        .active_plan .plan-card__badge {
            color: hsl(var(--base));
        }

        @media (max-width: 991px) {
            .content__subtitle {
                font-size: 14px;
            }

            .package-card__price {
                font-size: 32px;
            }
        }

        @media (max-width: 424px) {
            .package-card__price {
                font-size: 24px;
            }

            .card-item__right .sub {
                font-size: 14px;
            }
        }
    </style>
@endpush
