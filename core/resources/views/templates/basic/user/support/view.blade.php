@extends('Template::layouts.' . $layout)
@section('content')
    @if ($layout == 'frontend')
        <div class="container my-120">
            <div class="row">
                <div class="col-12">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="d-flex flex-wrap align-items-center gap-2">
                                @php echo $myTicket->statusBadge; @endphp
                                <span>
                                    [@lang('Ticket')#{{ $myTicket->ticket }}] {{ __($myTicket->subject) }}
                                </span>
                            </h5>
                            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                                <button class="btn btn-danger close-button btn-sm confirmationBtn" type="button"
                                        data-question="@lang('Are you sure to close this ticket?')"
                                        data-action="{{ route('ticket.close', $myTicket->id) }}"><i
                                       class="fas fa-lg fa-times-circle"></i>
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <form method="post" class="disableSubmission w-100"
                                  action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control form--control" rows="4" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <button type="button" class="btn btn-dark addAttachment my-2">
                                            <i class="las la-plus"></i> @lang('Add Attachment')
                                        </button>
                                        <p>
                                            <span class="text--info text fs-14">
                                                @lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                                            </span>
                                        </p>
                                        <div class="row fileUploadsContainer gy-2"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn--base  w-100 my-2" type="submit">
                                            <i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card custom--card mt-4">
                        <div class="card-body">
                            @forelse($messages as $message)
                                @if ($message->admin_id == 0)
                                    <div class="support-ticket">
                                        <div class="flex-align gap-3 mb-2">
                                            <h5 class="my-3">{{ $message->ticket->fullname }}</h5>
                                            <p class="support-ticket-date"> @lang('Posted on')
                                                {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        </div>
                                        <p class="support-ticket-message">{{ $message->message }}</p>
                                        @if ($message->attachments->count() > 0)
                                            <div class="support-ticket-file mt-2">
                                                @foreach ($message->attachments as $k => $image)
                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                       class="me-3">
                                                        <span class="icon"><i class="la la-file-download"></i></span>
                                                        @lang('Attachment')
                                                        {{ ++$k }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="support-ticket reply">
                                        <div class="flex-align gap-3 mb-2">
                                            <h6 class="support-ticket-name">{{ $message->admin->name }} <span
                                                      class="staff">@lang('Staff')</span></h6>
                                            <p class="support-ticket-date"> @lang('Posted on')
                                                {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                            </p>
                                        </div>
                                        <p class="support-ticket-message">{{ $message->message }}</p>
                                        @if ($message->attachments->count() > 0)
                                            <div class="support-ticket-file mt-2">
                                                @foreach ($message->attachments as $k => $image)
                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                       class="me-3">
                                                        <span class="icon"><i class="la la-file-download"></i></span>
                                                        @lang('Attachment')
                                                        {{ ++$k }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="user-profile-body__wrapper mb-4">
            <div class="profile-item-wrapper">
                <div class="card-item__inner d-flex justify-content-between align-items-center">
                    <h5 class="d-flex align-items-center flex-wrap gap-2">
                        @php echo $myTicket->statusBadge; @endphp
                        <span>[@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}</span>
                    </h5>
                    @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                        <button class="btn btn-outline--danger btn--md close-button customConfirmationBtn" type="button"
                                data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}"><i
                               class="fas fa-lg fa-times-circle"></i>
                        </button>
                    @endif
                </div>
                <div class="card-item__inner">
                    <form method="post" class="disableSubmission" action="{{ route('ticket.reply', $myTicket->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control form--control" rows="4" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <button type="button" class="btn btn-dark addAttachment my-2">
                                    <i class="fas fa-plus"></i> @lang('Add Attachment')
                                </button>
                                <p class="mb-2">
                                    <span class="text--info">
                                        @lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                                    </span>
                                </p>
                                <div class="row fileUploadsContainer gy-2"></div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn--base w-100 my-2" type="submit">
                                    <i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="user-profile-body__wrapper">
            <div class="profile-item-wrapper">
                <div class="card-item__inner">
                    @forelse($messages as $message)
                        @if ($message->admin_id == 0)
                            <div class="support-ticket">
                                <div class="flex-align gap-3 mb-2">
                                    <h6 class="support-ticket-name">{{ $message->ticket->name }}</h6>
                                    <p class="support-ticket-date"> @lang('Posted on')
                                        {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                </div>
                                <p class="support-ticket-message">{{ $message->message }}</p>
                                @if ($message->attachments->count() > 0)
                                    <div class="support-ticket-file mt-2">
                                        @foreach ($message->attachments as $k => $image)
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3">
                                                <span class="icon"><i class="la la-file-download"></i></span>
                                                @lang('Attachment')
                                                {{ ++$k }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="support-ticket reply">
                                <div class="flex-align gap-3 mb-2">
                                    <h6 class="support-ticket-name">{{ $message->admin->name }} <span
                                              class="staff">@lang('Staff')</span></h6>
                                    <p class="support-ticket-date"> @lang('Posted on')
                                        {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                    </p>
                                </div>
                                <p class="support-ticket-message">{{ $message->message }}</p>
                                @if ($message->attachments->count() > 0)
                                    <div class="support-ticket-file mt-2">
                                        @foreach ($message->attachments as $k => $image)
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3">
                                                <span class="icon"><i class="la la-file-download"></i></span>
                                                @lang('Attachment')
                                                {{ ++$k }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @include('Template::partials.modal.confirmation_modal')
    @endif
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
                    <div class="col-lg-6 col-md-12 removeFileInput">
                        <div class="input-group">
                            <input type="file" class="form--control form-control" name="attachments[]" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                            <button type="button" class="input-group-text text-white removeFile bg--danger border--danger"><i class="fas fa-times"></i></button>
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

        .reply-bg {
            background-color: #ffd96729
        }

        .empty-message img {
            width: 120px;
            margin-bottom: 15px;
        }
    </style>
@endpush
