@extends('Template::employer.layouts.master')
@section('content')
    <div class="company-profile-wrapper mt-4">
        <div class="card-item w-100 p-0">
            <div class="card-item__header list-header">
                <h5 class="card-item__title">{{ __($pageTitle) }}</h5>
                <div class=" list-content d-flex align-items-center gap-2 flex-wrap">
                    <form id="statusForm">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search by transactions" class="form--control form-control">
                            <button class="input-group-text"><i class="las la-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-item__inner p-0">
                @if ($deposits->count())
                    <table class="table table--responsive--xl m-0 border-0">
                        <thead>
                            <tr>
                                <th>@lang('Gateway | Transaction')</th>
                                <th>@lang('Initiated')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Conversion')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $deposit)
                                <tr>
                                    <td>
                                        <div>
                                            <span class="fw-bold">
                                                <span class="text-primary">
                                                    @if ($deposit->method_code < 5000)
                                                        {{ __(@$deposit->gateway->name) }}
                                                    @else
                                                        @lang('Google Pay')
                                                    @endif
                                                </span>
                                            </span>
                                            <br>
                                            <small> {{ $deposit->trx }} </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ showDateTime($deposit->created_at) }}
                                            <br>
                                            {{ diffForHumans($deposit->created_at) }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            {{ showAmount($deposit->amount) }} +
                                            <span class="text--danger" data-bs-toggle="tooltip" title="@lang('Processing Charge')">
                                                {{ showAmount($deposit->charge) }}
                                            </span>
                                            <br>
                                            <strong data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }}
                                            </strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ showAmount(1) }} = {{ showAmount($deposit->rate, currencyFormat: false) }}
                                            {{ __($deposit->method_currency) }}
                                            <br>
                                            <strong>
                                                {{ showAmount($deposit->final_amount, currencyFormat: false) }}
                                                {{ __($deposit->method_currency) }}
                                            </strong>
                                        </div>
                                    </td>
                                    <td>@php echo $deposit->statusBadge @endphp</td>
                                    @php
                                        $details = [];
                                        if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000) {
                                            foreach (@$deposit->detail ?? [] as $key => $info) {
                                                $details[] = $info;
                                                if ($info->type == 'file') {
                                                    $details[$key]->value = route('employer.attachment.download', encrypt(getFilePath('verify') . '/' . $info->value));
                                                }
                                            }
                                        }
                                    @endphp
                                    <td>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                @if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000)
                                                    <button class="action-btn detailBtn" data-bs-toggle="tooltip"
                                                            data-info="{{ json_encode($details) }}" data-bs-placement="top"
                                                            data-bs-title="@lang('Payment Details')"
                                                            @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                                        <i class="la-lg las la-desktop"></i>
                                                    </button>
                                                @else
                                                    <button class="action-btn" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-title="@lang('Automatically processed')">
                                                        <i class="la-lg las la-check-circle"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @include('Template::partials.empty', [
                        'message' => 'No transaction data found.',
                    ])
                @endif
            </div>
            @if ($deposits->hasPages())
                <div class="card-item__footer">
                    {{ paginateLinks($deposits) }}
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade custom--modal fade-in-scale" id="detailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Details')</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData mb-2"></ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        } else {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>${element.name}</span>
                                <span"><a href="${element.value}"><i class="fa-regular fa-file"></i> @lang('Attachment')</a></span>
                            </li>`;
                        }
                    });
                }
                modal.find('.userData').html(html);
                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }
                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        })(jQuery);
    </script>
@endpush
