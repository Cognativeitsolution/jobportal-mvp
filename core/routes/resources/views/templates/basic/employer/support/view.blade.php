@extends('Template::employer.layouts.' . $layout)
@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-xxl-9 col-xl-8 col-md-7">
            <div class="card-item w-100">
                <div class="card-item__header">
                    <h6 class="card-item__title mb-0">{{ __($pageTitle) }}</h6>
                    <a href="{{ route('employer.ticket.index') }}" class="btn btn--base btn--md">
                        <i class="las la-list"></i> @lang('My Tickets')
                    </a>
                </div>
                <div class="card-item__inner">
                    <form method="post" action="{{ route('employer.ticket.reply', $myTicket->id) }}"
                          class="disableSubmission w-100" enctype="multipart/form-data">
                        @csrf
                        <div class="register">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group m-0">
                                        <label class="form--label">@lang('Message')</label>
                                        <textarea name="message" required class="form--control"></textarea>
                                    </div>
                                </div>
                                <div class="col-xxl-9">
                                    <button type="button" class="btn btn-dark addAttachment">
                                        <i class="fas fa-plus"></i> @lang('Add Attachment')
                                    </button>
                                    <p class="my-2">
                                        <span class="text--muted fs-14">
                                            @lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                                        </span>
                                    </p>
                                    <div class="row fileUploadsContainer"></div>
                                </div>
                                <div class="col-xxl-3">
                                    <button class="btn btn--base w-100" type="submit">
                                        <i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-md-5">
            <div class="card-item wow fadeInUp" data-wow-duration="2s">
                <div class="card-item__header mb-xxl-4 mb-3">
                    <h6 class="card-item__title mb-0">@lang('Ticket Information')</h4>
                </div>
                <div class="card-item__inner">
                    <div class="ticket-info">
                        <ul class="ticket-info-list">
                            <li class="ticket-info-item">
                                <span class="ticket-info-title">@lang('Status')</span>
                                <span class="ticket-info-text">
                                    @php echo $myTicket->statusBadge; @endphp
                                </span>
                            </li>
                            <li class="ticket-info-item">
                                <span class="ticket-info-title">@lang('Ticket ID')</span>
                                <span class="ticket-info-text">#{{ $myTicket->ticket }}</span>
                            </li>
                            <li class="ticket-info-item">
                                <span class="ticket-info-title">@lang('Priority')</span>
                                <span class="ticket-info-text">
                                    @php echo $myTicket->priorityBadge; @endphp
                                </span>
                            </li>
                            <li class="ticket-info-item">
                                <span class="ticket-info-title">@lang('Opened At')</span>
                                <span class="ticket-info-text">
                                    <i class="far fa-clock"></i> {{ showDateTime($myTicket->created_at) }}
                                </span>
                            </li>
                            @if ($myTicket->status !== Status::TICKET_CLOSE)
                                <li class="ticket-info-item  w-100">
                                    <button class="btn btn--danger w-100 customConfirmationBtn"
                                            data-question="Are you sure to close this ticket ?"
                                            data-action="{{ route('employer.ticket.close', $myTicket->id) }}">
                                        <i class="las la-times-circle"></i> @lang('Close Ticket')
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card-item w-100">
                <div class="card-item__inner">
                    @foreach ($messages as $message)
                        <div class="chat-item  {{ $message->admin_id == 0 ? 'reply' : '' }}">
                            <div class="chat-item__content">
                                <p class="chat-item__name text--base">
                                    {{ $message->admin ? $message->admin->name : $message->ticket->name }}
                                </p>
                                <p class="chat-item__time">
                                    <span>@lang('Created At'): </span>
                                    <span> <i class="far fa-clock"></i>
                                        {{ showdateTime($message->created_at) }}</span>
                                </p>
                                <p class="chat-item__message">{{ $message->message }}</p>
                                <div class="atach-preview-wrapper m-0">
                                    @foreach ($message->attachments as $attachment)
                                        <div class="atach-preview">
                                            <div class="atach-preview__left">
                                                <div class="atach-preview__image">
                                                    @php $ext = pathinfo($attachment->attachment, PATHINFO_EXTENSION); @endphp
                                                    <img src="{{ getImage(getFilePath('ticket') . '/' . (!in_array($ext, ['jpg', 'jpeg', 'png']) ? 'doc_type.png' : $attachment->attachment)) }}"
                                                         alt="File">
                                                </div>
                                                <div class="atach-preview__contemt">
                                                    <p class="atach-preview__title">@lang('attachments')</p>
                                                    <p class="atach-preview__size">
                                                        {{ fileSizeInB(getFilePath('ticket') . '/' . $attachment->attachment) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="atach-preview__action">
                                                <a href="{{ route('ticket.download', encrypt($attachment->id)) }}"
                                                   class="atach-icon">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('Template::partials.modal.confirmation_modal')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-4 col-md-12 removeFileInput">
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
        /* support ticket */
        .btn--link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn--link .icon {
            height: 24px;
            width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            background-color: hsl(var(--base) / 0.1);
            border-radius: 50%;
        }

        .action-btn.notification-btn {
            height: 32px;
            width: 32px;
            display: grid;
            place-content: center;
            font-size: 14px;
            border-radius: 50%;
            border: 1px solid hsl(var(--base) / 0.2);
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .action-btn.notification-btn:hover {
            background-color: hsl(var(--base) / 0.1);
            border-color: hsl(var(--base) / 0.3);
        }

        .notification-card-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-card-title {
            margin-bottom: 0;
            font-weight: 500;
        }

        .notification-card {
            background: transparent !important;
            border-bottom: 1px solid hsl(var(--base) / 0.1) !important;
            padding: 9px 16px;
        }

        .notification-read-card {
            border-bottom: 1px solid hsl(var(--base) / 0.1) !important;
            padding: 9px 16px;
            background-color: hsl(var(--success) / 0.03) !important;
        }

        .notification-read-card .notification-card-title {
            color: hsl(var(--success));
        }

        .form--check-table .form-check-input {
            height: 18px;
            width: 18px;
            border-radius: 4px;
            border-color: hsl(var(--base) / 0.2);
        }

        .view-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            width: 32px;
            border-radius: 50%;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-left: auto;
            background-color: hsl(var(--base) / 0.1);
            border: 1px solid hsl(var(--base) / 0.2);
        }

        .view-btn:hover {
            background-color: hsl(var(--base));
            border-color: hsl(var(--base));
            color: hsl(var(--black));
        }

        .view-btn.disabled {
            background-color: #f2f2f2 !important;
            border-color: 5px solid #dcdcdc !important;
            color: #999999 !important;
            opacity: 0.6 !important;
        }

        .view-btn.disabled:hover {
            background-color: #f2f2f2;
            border-color: unset;
            color: #f2f2f2;
        }

        .support-priority-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 8px 16px;
            flex-wrap: wrap;
        }

        .support-priority {
            display: flex;
            align-items: center;
            padding: 7px 14px;
            border-radius: 4px;
            border: 1px solid hsl(var(--base) / 0.1);
            gap: 12px;
            background-color: hsl(var(--base) / 0.04);
            cursor: pointer;
            font-weight: 500;
            line-height: 1;
            transition: all linear 0.3s;
            font-size: 0.875rem;
        }

        @media (max-width: 424px) {
            .support-priority {
                flex-grow: 1;
                justify-content: center;
            }
        }

        .support-priority[for="low"] .support-priority-circle {
            border-color: hsl(var(--success));
        }

        .support-priority[for="low"] .check-circle {
            color: hsl(var(--success));
        }

        .support-priority[for="medium"] .support-priority-circle {
            border-color: hsl(var(--warning));
        }

        .support-priority[for="medium"] .check-circle {
            color: hsl(var(--warning));
        }

        .support-priority[for="high"] .support-priority-circle {
            border-color: hsl(var(--danger));
        }

        .support-priority[for="high"] .check-circle {
            color: hsl(var(--danger));
        }

        .support-priority-circle {
            position: relative;
            height: 1.2rem;
            width: 1.2rem;
            border: 1px solid hsl(var(--base) / 0.1);
            border-radius: 50%;
            display: grid;
            place-content: center;
            flex-shrink: 0;
        }

        .support-priority .check-circle {
            transform: scale(0.8);
            position: unset;
            top: 0;
            left: 0;
        }

        .support-priority input {
            display: none;
        }

        .support-priority:has(input:checked) .check-circle {
            display: block;
        }

        .support-priority:has(input:checked)[for="low"] {
            background-color: hsl(var(--success) / 0.1);
            border-color: hsl(var(--success));
            color: hsl(var(--success));
        }

        .support-priority:has(input:checked)[for="medium"] {
            background-color: hsl(var(--warning) / 0.1);
            border-color: hsl(var(--warning));
            color: hsl(var(--warning));
        }

        .support-priority:has(input:checked)[for="high"] {
            background-color: hsl(var(--danger) / 0.1);
            border-color: hsl(var(--danger));
            color: hsl(var(--danger));
        }

        /* preview image */
        .atach-preview-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-block: 1.5rem;
        }

        .atach-preview {
            padding: 0.5rem;
            border-radius: 6px;

            border: 1px solid hsl(var(--base) / 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .atach-preview {
                flex-grow: 1;
            }
        }

        .atach-preview__left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.75rem;
        }

        .atach-preview__image {
            max-width: 2.2rem;
            flex-shrink: 0;
        }

        .atach-preview__image img {
            border-radius: 6px;
        }

        .atach-preview__content {
            flex: 1;
        }

        .atach-preview__title {
            font-size: 0.75rem;
            font-weight: 400;
        }

        .atach-preview__size {
            font-size: 0.75rem;
            font-weight: 700;
            color: hsl(var(--base));
        }

        .atach-preview__action {
            flex-shrink: 0;
        }

        .atach-preview .atach-icon {
            font-size: 0.875rem;
            cursor: pointer;
            color: hsl(var(--base) / 0.6);
        }

        .ticket-info-list {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            flex-direction: column;
        }

        .ticket-info-item {
            display: flex;
            flex-direction: column;
        }

        .ticket-info-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: hsl(var(--black));
        }

        .ticket-info-text {
            font-size: 1rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ticket-info-text .i {
            font-size: 0.75rem;
        }

        .chat-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }

        .chat-item:not(:last-of-type) {
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid hsl(var(--base) / 0.1);
        }

        .chat-item.reply {
            flex-direction: row-reverse;
            text-align: right;
        }

        .chat-item.reply .atach-preview-wrapper {
            justify-content: flex-end;
        }

        .chat-item__thumb {
            flex-shrink: 0;
            height: 36px;
            width: 36px;
        }

        .chat-item__thumb img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-item__content {
            flex: 1;
        }

        .chat-item__name {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .chat-item__time {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .chat-item__message {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .chat-item-wrapper {
            max-height: 460px;
            overflow-y: auto;
            padding-right: 20px;
        }

        .chat-form {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .chat-form-file {
            height: 3rem;
            width: 3rem;
            flex-shrink: 0;
            display: grid;
            place-content: center;
            cursor: pointer;
            font-size: 1.3rem;
        }

        .chat-form-file .file-upload {
            display: none;
        }

        .chat-form-inner {
            background-color: hsl(var(--base) / 0.5);
            border-radius: 6px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex: 1;
        }

        .chat-form-input {
            height: 3rem;
            flex: 1;
            background-color: transparent;
            padding: 1rem;
            border: 0;
            font-size: 0.875rem;
            font-weight: 600;
            outline: 0;
            overflow: hidden;
            resize: none;
            line-height: 1;
        }

        .chat-form-submit {
            height: 3rem;
            width: 3rem;
            display: grid;
            place-content: center;
            font-size: 1.3rem;
        }

        .input-note-text {
            font-size: 0.875rem;
            font-weight: 400;
            display: flex;
            align-items: flex-start;
        }

        .input-note-text i {
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .ticket--btn {
            font-size: 0.8775rem;
            font-weight: 600;
            background-color: hsl(var(--base));
            border: 1px solid hsl(var(--base));
            border-radius: 4px;
            padding: 0.7rem 1rem;
            display: flex !important;
            gap: 8px;
        }

        .ticket--btn:hover {
            border-color: hsl(var(--base));
            color: hsl(var(--black)) !important;
        }

        .responsive-filter-card {
            position: relative;
        }

        .responsive-filter-form {
            width: 350px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid hsl(var(--base) / 0.1);
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            z-index: 5;
            background-color: hsl(var(--bg-color));
            transition: all linear 0.3s;
            opacity: 0;
            visibility: hidden;
        }

        @media (max-width: 767px) {
            .responsive-filter-form {
                width: 280px;
            }
        }

        @media (max-width: 575px) {
            .responsive-filter-form {
                width: 250px;
            }
        }

        .responsive-filter-form.show {
            opacity: 1;
            visibility: visible;
        }

        .responsive-filter-body {
            padding: 20px 16px;
            background-color: hsl(var(--base) / 0.01);
        }

        .responsive-filter-footer {
            padding: 16px;
            background-color: hsl(var(--bg-color));
            box-shadow: 14px -7px 17px rgb(255 255 255 / 5%);
            text-align: right;
        }

        .responsive-filter-title {
            padding: 16px;
            background-color: hsl(var(--bg-color));
            box-shadow: -11px 4px 17px rgb(255 255 255 / 5%);
        }

        .responsive-filter-item:not(:last-child) {
            margin-bottom: 12px;
        }

        .close-filter-btn {
            font-size: 20px;
            cursor: pointer;
            color: hsl(var(--base));
        }

        .table-wrapper {
            border: 1px solid hsl(var(--base) / 0.1);
            height: 100%;
            border-radius: inherit;
        }

        .table-wrapper-header {
            padding: 16px;
            border-bottom: 1px solid hsl(var(--base) / 0.1);
        }

        .responsive-filter-body .form--control {
            padding-block: 12px;
        }

        .flex--end {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            flex-wrap: wrap;
        }

        .flex--end .view-btn {
            margin: 0;
        }

        .table-search {
            position: relative;
            border: 1px solid hsl(var(--base) / 0.1);
            max-width: 360px;
            width: 100%;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        .table-search .form--control {
            border: 0;
            padding-block: 14px;
            font-size: 1rem;
        }

        .table-search .form--control::placeholder {
            font-size: 1rem;
            color: hsl(var(--base) / 0.3);
            font-weight: 300;
        }

        .table-search-text {
            padding: 0 12px;
            color: hsl(var(--base));
        }

        .table-wrapper-footer {
            padding: 16px;
            border-top: 1px solid hsl(var(--base) / 0.1);
        }

        .table-wrapper-footer .pagination {
            margin-top: 0;
        }

        /* End Support ticket */
    </style>
@endpush
