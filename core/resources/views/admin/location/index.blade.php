@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card  ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('City')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($locations as $location)
                                    <tr>
                                        <td>{{ __(ucfirst($location->name)) }}</td>
                                        <td>{{ __(ucfirst(@$location->town->name)) }}</td>
                                        <td>@php echo $location->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary edit-btn" data-edit='@json($location->only('id', 'name', 'parent_id'))''>
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($location->status == Status::ENABLE)
                                                    <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn"
                                                            data-question="@lang('Are you sure to disable this location?')"
                                                            data-action="{{ route('admin.location.status', $location->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline--success confirmationBtn"
                                                            data-question="@lang('Are you sure to enable this location?')"
                                                            data-action="{{ route('admin.location.status', $location->id) }}">
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
                @if ($locations->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($locations) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div id="my-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('City')</label>
                            <select class="form-control select2" name="city" required>
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($cites as $city)
                                    <option value="{{ $city->id }}">{{ __($city->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" type="text" name="name" required value="{{ old('name') }}">
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
    <button type="button" class="btn btn-outline--primary add-btn btn-sm">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
@push('script')
    <script>
        "use strict";
        (function($) {
            let modal = $("#my-modal");
            let action = `{{ route('admin.location.save') }}`

            $('.add-btn').on('click', function(e) {
                modal.find('.modal-title').text("@lang('New Location')");
                modal.find('form').trigger("reset");
                modal.find('form').attr("action", action);
                modal.modal('show');
            });

            $('.edit-btn').on('click', function(e) {
                let action = `{{ route('admin.location.save', ':id') }}`;
                let data = $(this).data('edit');
                modal.find('.modal-title').text("@lang('Update Location')");
                modal.find("input[name=name]").val(data.name);
                modal.find("select[name=city]").val(data.parent_id).trigger('change');
                modal.find('form').attr("action", action.replace(":id", data.id));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
