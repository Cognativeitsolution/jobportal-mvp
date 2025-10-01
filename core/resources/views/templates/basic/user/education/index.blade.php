@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="table-wrapper">
        <div class="flex-between gap-2 table-wrapper-header">
            <h5 class="m-0">{{ __($pageTitle) }}</h5>
            <button class="btn btn--base emp-btn educationBtn" data-action="{{ route('user.education.store') }}"
                data-education="" data-title="@lang('Add Education')">
                <i class="las la-plus"></i> @lang('Add Education')
            </button>
        </div>
        @if ($educations->count())
            <table class="table table--responsive--xl rounded-0">
                <thead>
                    <tr>
                        <th>@lang('Exam/Degree')</th>
                        <th>@lang('Major/Group')</th>
                        <th>@lang('CGPA/Marks')</th>
                        <th>@lang('Passing Year')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($educations ?? [] as $education)
                        <tr>
                            <td>{{ __($education->educationDegree->name) }}</td>
                            <td>{{ __($education->educationGroup->name) }}</td>
                            <td>{{ __($education->cgpa_or_marks) }}</td>
                            <td>{{ $education->passing_year }}</td>
                            <td>
                                <div class="action-btn-wrapper">
                                    <div class="action-buttons">
                                        <button class="action-btn educationBtn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="@lang('Edit')"
                                            data-action="{{ route('user.education.store', $education->id) }}"
                                            data-education="{{ $education }}" data-title="@lang('Edit Education')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="action-btn text--danger customConfirmationBtn"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                            data-action="{{ route('user.education.delete', $education->id) }}"
                                            data-question="@lang('Are You sure to delete this educational level?')">
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
            @include('Template::partials.empty', ['message' => 'Education not found!'])
        @endif
    </div>

    @include('Template::partials.modal.user.education_modal')
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
