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
                                    <th>@lang('Question')</th>
                                    <th>@lang('Answer')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $faq)
                                    <tr>
                                        <td>{{ Str::limit(ucfirst($faq->question), 50, '..?') }}</td>
                                        <td>{{ Str::limit(ucfirst($faq->answer), 50, '...') }}</td>
                                        <td>@php echo $faq->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary edit-btn"
                                                    data-edit='@json($faq->only('id', 'question', 'answer'))'>'>
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>
                                                @if ($faq->status == Status::ENABLE)
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this faq?')"
                                                        data-action="{{ route('admin.faq.status', $faq->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this faq?')"
                                                        data-action="{{ route('admin.faq.status', $faq->id) }}">
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


    <div id="my-modal" class="modal fade">
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
                            <label>@lang('Question')</label>
                            <input class="form-control" type="text" name="question" required
                                value="{{ old('question') }}">

                            <label>@lang('Answer')</label>
                            <textarea class="form-control" type="text" name="answer" required value="{{ old('answer') }}"></textarea>
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
            let action = `{{ route('admin.faq.save') }}`

            $('.add-btn').on('click', function(e) {
                modal.find('.modal-title').text("@lang('Add Faq')");
                modal.find('form').trigger("reset");
                modal.find('form').attr("action", action);
                modal.modal('show');
            });

            $('.edit-btn').on('click', function(e) {
                let action = `{{ route('admin.faq.save', ':id') }}`;
                let data = $(this).data('edit');
                modal.find('.modal-title').text("@lang('Update Faq')");
                modal.find("input[name=question]").val(data.question);
                modal.find("textarea[name=answer]").val(data.answer);
                modal.find('form').attr("action", action.replace(":id", data.id));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
