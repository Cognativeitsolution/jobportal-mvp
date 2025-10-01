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
                                    <th>@lang('Applicant')</th>
                                    <th>@lang('Location')</th>
                                    <th>@lang('Expected Salary')</th>
                                    <th>@lang('Applied Date')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applicants as $applicant)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getProfileImage($applicant->user->image) }}"
                                                        alt="{{ $applicant->user->fullname }}" class="plugin_bg">
                                                </div>
                                                <span class="name">
                                                    <span class="fw-bold">{{ $applicant->user->fullname }}</span>
                                                    <br>
                                                    <span class="small">
                                                        <a href="{{ route('admin.users.detail', $applicant->user->id) }}">
                                                            <span>@</span>{{ $applicant->user->username }}
                                                        </a>
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td><span class="d-block">{{ __(@$applicant->user->country_name) }}</span></td>
                                        <td><span class="text--small">{{ __(@$applicant->expected_salary) }}</span></td>
                                        <td>{{ showDateTime($applicant->created_at) }}</td>
                                        <td>@php echo $applicant->statusBadge;@endphp</td>
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
                @if ($applicants->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($applicants) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username"/>
@endpush
