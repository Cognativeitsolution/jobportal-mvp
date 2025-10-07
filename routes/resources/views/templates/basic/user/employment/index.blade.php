@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="table-wrapper">
        <div class="flex-between gap-2 table-wrapper-header">
            <h5 class="m-0">{{ __($pageTitle) }}</h5>
            <button class="btn btn--base emp-btn employmentBtn" data-action="{{ route('user.employment.store') }}"
                data-employment="" data-title="@lang('Add Employment')">
                <i class="las la-plus"></i> @lang('Add Employment')
            </button>
        </div>
        @if ($employments->count())
            <table class="table table--responsive--xl rounded-0">
                <thead>
                    <tr>
                        <th>@lang('Designation')</th>
                        <th>@lang('Company Name')</th>
                        <th>@lang('Department')</th>
                        <th>@lang('Joining Date')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employments ?? [] as $employment)
                        <tr>
                            <td>{{ __($employment->designation) }}</td>
                            <td>{{ __($employment->company_name) }}</td>
                            <td>{{ __($employment->department) }}</td>
                            <td>{{ showDateTime($employment->start_date, 'd M, Y') }}</td>
                            <td>
                                <div class="action-btn-wrapper">
                                    <div class="action-buttons">
                                        <button class="action-btn employmentBtn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="@lang('Edit Employment')"
                                            data-action="{{ route('user.employment.store', $employment->id) }}"
                                            data-title="@lang('Edit Employment')" data-employment="{{ $employment }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn text--danger customConfirmationBtn"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="@lang('Delete')"
                                            data-action="{{ route('user.employment.delete', $employment->id) }}"
                                            data-question="@lang('Are You sure to delete this employment?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            @include('Template::partials.empty', ['message' => 'Employment not found!'])
        @endif
    </div>

    @include('Template::partials.modal.user.employment_modal')
    @include('Template::partials.modal.confirmation_modal')
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2').select2();
            $('.date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD',
                },
                minYear: 1901,
                maxDate: moment()
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .datepickers-container {
            z-index: 9999999;
        }

        label.currently_work.required::after {
            display: none !important;
        }
    </style>
@endpush
