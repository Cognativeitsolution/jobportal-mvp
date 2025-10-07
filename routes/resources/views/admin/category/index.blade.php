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
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $category)
                                    <tr>
                                        <td>
                                            <div class="user gap-2">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('category') . '/' . @$category->image, getFileSize('category')) }}"
                                                        alt="category-image" class="plugin_bg">
                                                </div>
                                                <span>{{ __($category->name) }}</span>
                                            </div>
                                        </td>
                                        <td>@php echo $category->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary editBtn"
                                                    data-action="{{ route('admin.category.save', $category->id) }}"
                                                    data-image="{{ getImage(getFilePath('category') . '/' . @$category->image, getFileSize('category')) }}"
                                                    data-title="@lang('Edit Category')" data-category="{{ $category }}">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($category->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this category?')"
                                                        data-action="{{ route('admin.category.status', $category->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this category?')"
                                                        data-action="{{ route('admin.category.status', $category->id) }}">
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

    <div id="categoryModal" class="modal fade">
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
                                <x-image-uploader :imagePath="getImage(null, getFileSize('category'))" :size="getFileSize('category')" class="w-100" id="imageCreate"
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
    <button type="button" class="btn btn-outline--primary addBtn btn-sm" data-action="{{ route('admin.category.save') }}"
        data-image="{{ getImage(null, getFileSize('category')) }}" data-title="@lang('Add New Category')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            let modal = $("#categoryModal");

            $('.addBtn').on('click', function(e) {
                modal.find('.modal-title').text($(this).data('title'));
                modal.find('form').attr('action', $(this).data('action'))
                modal.find('.image-upload-preview').css('background-image', `url(${$(this).data('image')})`);
                modal.find('form').trigger("reset");
                modal.modal('show');
            });

            $('.editBtn').on('click', function(e) {
                let category = $(this).data('category');
                modal.find('.modal-title').text($(this).data('title'));
                modal.find("input[name=name]").val(category.name);
                modal.find('form').attr("action", $(this).data('action'));
                modal.find('.image-upload-preview').css('background-image', `url(${$(this).data('image')})`);
                modal.find('input[name=image]').attr('required', false);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
