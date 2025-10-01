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
                                    <th>@lang('Company | Username')</th>
                                    <th>@lang('Email | Phone')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Balance')</th>
                                    <th>@lang('Is Featured')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employers as $employer)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getProfileImage($employer->image, 'employer') }}"
                                                        alt="{{ $employer->company_name }}" class="plugin_bg">
                                                </div>
                                                <span class="name">
                                                    <span class="fw-bold d-block">{{ $employer->company_name }}</span>
                                                    <span class="text--small">
                                                        <a href="{{ route('admin.employers.detail', $employer->id) }}">
                                                            <span>@</span>{{ $employer->username }}
                                                        </a>
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="d-block">{{ $employer->email }}</span>
                                            <span>{{ $employer->mobileNumber }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold"
                                                title="{{ @$employer->address->country }}">{{ $employer->country_code }}</span>
                                        </td>
                                        <td>
                                            <span class="d-block">{{ showDateTime($employer->created_at) }}</span>
                                            <span>{{ diffForHumans($employer->created_at) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($employer->balance) }}</span>
                                        </td>
                                        <td>@php echo $employer->featuredBadge;@endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.employers.detail', $employer->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="las la-desktop"></i>@lang('Details')
                                                </a>
                                                @if ($employer->is_featured)
                                                    <button class="btn btn-outline--danger btn-sm confirmationBtn"
                                                        data-action="{{ route('admin.employers.featured', $employer->id) }}"
                                                        data-question="@lang('Are you sure to unfeatured this employer?')">
                                                        <i class="las la-star-of-life"></i> @lang('Unfeatured')
                                                    </button>
                                                @else
                                                    <button class="btn btn-outline--success btn-sm confirmationBtn"
                                                        data-action="{{ route('admin.employers.featured', $employer->id) }}"
                                                        data-question="@lang('Are you sure to featured this employer?')">
                                                        <i class="las la-star-of-life"></i> @lang('Featured')
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
                @if ($employers->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($employers) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
