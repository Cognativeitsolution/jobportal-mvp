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
                                    <th>@lang('Employer')</th>
                                    <th>@lang('Plan')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Subscription Number')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Subscribed')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <span class="fw-bold d-block">{{ __($subscription->employer->company_name) }}</span>
                                            <span class="text--small">
                                                <a href="{{ route('admin.employers.detail', @$subscription->employer->id) }}">
                                                    <span>@</span>{{ @$subscription->employer->username }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>{{ $subscription->plan->name }}</td>
                                        <td>{{ showAmount($subscription->amount) }}</td>
                                        <td>{{ $subscription->order_number }}</td>
                                        <td>@php echo $subscription->statusBadge; @endphp</td>
                                        <td>
                                            <span class="d-block">{{ showDateTime($subscription->created_at) }}</span>
                                            <span>{{ diffForHumans($subscription->created_at) }}</span>
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
                @if ($subscriptions->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subscriptions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back :route="route('admin.plan.index')" />
@endpush
