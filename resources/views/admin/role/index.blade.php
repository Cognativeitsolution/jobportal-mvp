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
                                    <th>@lang('Role')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $role)
                                    <tr>
                                        <td>
                                            <div class="user gap-2">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('role') . '/' . @$role->image, getFileSize('role')) }}"
                                                        alt="role-image" class="plugin_bg">
                                                </div>
                                                <span>{{ __($role->name) }}</span>
                                            </div>
                                        </td>
                                        <td>@php echo $role->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary editBtn"
                                                    data-action="{{ route('admin.role.store', $role->id) }}"
                                                    data-image="{{ getImage(getFilePath('role') . '/' . @$role->image, getFileSize('role')) }}"
                                                    data-title="@lang('Edit Role')" data-role="{{ $role }}">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($role->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this role?')"
                                                        data-action="{{ route('admin.role.status', $role->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this role?')"
                                                        data-action="{{ route('admin.role.status', $role->id) }}">
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
                @if ($data->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($data) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="roleModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label> @lang('Image')</label>
                                <x-image-uploader :imagePath="getImage(null, getFileSize('role'))" :size="getFileSize('role')" class="w-100" id="imageCreate"
                                    :required="true" />
                            </div>
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
    <x-search-form />
    <button type="button" class="btn btn-outline--primary addBtn btn-sm" data-action="{{ route('admin.role.store') }}"
        data-image="{{ getImage(null, getFileSize('role')) }}" data-title="@lang('Add New Role')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            let modal = $("#roleModal");

            $('.addBtn').on('click', function(e) {
                modal.find('.modal-title').text($(this).data('title'));
                modal.find('form').attr('action', $(this).data('action'))
                modal.find('.image-upload-preview').css('background-image', `url(${$(this).data('image')})`);
                modal.find('form').trigger("reset");
                modal.modal('show');
            });

            $('.editBtn').on('click', function(e) {
                let role = $(this).data('role');
                modal.find('.modal-title').text($(this).data('title'));
                modal.find("input[name=name]").val(role.name);
                modal.find('form').attr("action", $(this).data('action'));
                modal.find('.image-upload-preview').css('background-image', `url(${$(this).data('image')})`);
                modal.find('[name=image]').attr('required', false);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
