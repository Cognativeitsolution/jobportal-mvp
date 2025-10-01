@extends('Template::employer.layouts.master')
@section('content')
    <div class="company-profile-wrapper">
        <div class="card-item w-100">
            <div class="card-item__header">
                <h6 class="card-item__title">{{ __($pageTitle) }}</h6>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('employer.ticket.index') }}" class="btn btn--md btn--base">
                        <i class="las la-list"></i> @lang('My Tickets')
                    </a>
                </div>
            </div>
            <div class="card-item__inner">
                <form action="{{ route('employer.ticket.store') }}" class="disableSubmission w-100" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Subject')</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form--control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Priority')</label>
                                <select name="priority" class="form--control select2" data-minimum-results-for-search="-1"
                                    required>
                                    <option value="3">@lang('High')</option>
                                    <option value="2">@lang('Medium')</option>
                                    <option value="1">@lang('Low')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Message')</label>
                                <textarea name="message" id="inputMessage" rows="6" class="form--control" required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <button type="button" class="btn btn-dark addAttachment my-2">
                                <i class="las la-plus"></i> @lang('Add Attachment')
                            </button>
                            <p class="mb-2">
                                <span class="text--info">
                                    @lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                                </span>
                            </p>
                            <div class="row fileUploadsContainer"></div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn--base w-100 my-2" type="submit">
                                <i class="las la-paper-plane"></i> @lang('Submit')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.select2').select2();

            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-xxl-4 col-sm-6 removeFileInput">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control form--control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <button type="button" class="input-group-text removeFile bg--danger border-0 text-white"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
