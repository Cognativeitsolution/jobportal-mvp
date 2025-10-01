@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Duration')</th>
                                    <th>@lang('Total Job Post')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                    <tr>
                                        <td><span class="fw-bold">{{ __($plan->name) }}</span></td>
                                        <td><span class="fw-bold">{{ showAmount($plan->price) }}</span></td>
                                        <td>{{ $plan->duration }} @lang('months')</td>
                                        <td>{{ $plan->job_post }}</td>
                                        <td> @php echo $plan->statusBadge; @endphp</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--info" data-bs-toggle="dropdown"
                                                type="button" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i> @lang('Action')
                                            </button>
                                            <div class="dropdown-menu">
                                                <button data-action="{{ route('admin.plan.save', $plan->id) }}"
                                                    data-title="@lang('Edit Plan')" data-plan="{{ $plan }}"
                                                    class="dropdown-item editBtn">
                                                    <i class="las la-pen"></i> @lang('Edit')
                                                </button>
                                                @if ($plan->status == Status::ENABLE)
                                                    <button type="button" class="dropdown-item confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this plan?')"
                                                        data-action="{{ route('admin.plan.status', $plan->id) }}">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @else
                                                    <button type="button" class="dropdown-item confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this plan?')"
                                                        data-action="{{ route('admin.plan.status', $plan->id) }}">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.plan.subscriber.list', $plan->id) }}"
                                                    class="dropdown-item">
                                                    <i class="las la-bars"></i> @lang('Subscribers')
                                                </a>
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
                @if ($plans->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($plans) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="planModal" class="modal fade">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input class="form-control" type="text" name="name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Price')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="price" step="any" required>
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Duration')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" name="duration" required>
                                        <span class="input-group-text">@lang('Months')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Job Post Limit')</label>
                                    <input class="form-control" type="number" name="job_post" required>
                                </div>
                            </div>
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
    <button data-action="{{ route('admin.plan.save') }}" data-title="@lang('Add New Plan')"
        class="btn btn-outline--primary btn-sm addBtn">
        <i class="las la-plus"></i>@lang('New Plan')
    </button>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            let modal = $('#planModal');

            $('.addBtn').on('click', function() {
                modal.find('form').attr('action', $(this).data('action'));
                modal.find('.modal-title').text($(this).data('title'));
                modal.find('[name="name"]').val('');
                modal.find('[name="price"]').val('');
                modal.find('[name="duration"]').val('');
                modal.find('[name="job_post"]').val('');
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                let plan = $(this).data('plan');
                modal.find('form').attr('action', $(this).data('action'));
                modal.find('.modal-title').text($(this).data('title'));
                modal.find('[name="name"]').val(plan.name);
                modal.find('[name="price"]').val(parseFloat(plan.price).toFixed(2));
                modal.find('[name="duration"]').val(plan.duration);
                modal.find('[name="job_post"]').val(plan.job_post);
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .dropdown-item {
            font-size: 14px;
        }
    </style>
@endpush
