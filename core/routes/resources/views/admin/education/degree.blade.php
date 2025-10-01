@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Education Level')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allDegrees as $degree)
                                    <tr>
                                        <td>{{ __($degree->name) }}</td>
                                        <td>{{ __(@$degree->educationLevel->name) }}</td>
                                        <td>@php echo $degree->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary edit-btn"
                                                        data-edit="{{ $degree }}"
                                                        data-action="{{ route('admin.education.degree.save', $degree->id) }}">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($degree->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                            data-question="@lang('Are you sure to disable this education degree?')"
                                                            data-action="{{ route('admin.education.degree.status', $degree->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                            data-question="@lang('Are you sure to enable this education degree?')"
                                                            data-action="{{ route('admin.education.degree.status', $degree->id) }}">
                                                        <i class="la la-eye"></i>@lang('Enable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($allDegrees->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($allDegrees) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="degreeModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('Education Level')</label>
                            <select name="education_level_id" class="form-control select2"
                                    data-minimum-results-for-search="-1" required>
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ __($level->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search here ..." />
    <button type="button" class="btn btn-outline--primary add-btn btn-sm"
            data-action="{{ route('admin.education.degree.save') }}">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let modal = $("#degreeModal");

            $('.add-btn').on('click', function(e) {
                modal.find('.modal-title').text("@lang('Add New Degree')");
                modal.find('form').trigger("reset");
                modal.find('form').attr("action", $(this).data('action'));
                modal.find('select[name="education_level_id"]').val('').trigger('change');
                modal.modal('show');
            });

            $('.edit-btn').on('click', function(e) {
                let data = $(this).data('edit');
                modal.find('.modal-title').text("@lang('Update Degree')");
                modal.find("input[name=name]").val(data.name);
                modal.find('select[name="education_level_id"]').val(data.education_level_id).trigger('change');
                modal.find('form').attr("action", $(this).data('action'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
