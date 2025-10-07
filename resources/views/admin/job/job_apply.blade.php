@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Job Title - Category')</th>
                                    <th>@lang('Employer')</th>
                                    <th>@lang('Candidate')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobApplications as $jobApplication)
                                    <tr>
                                        <td>{{ $loop->index + $jobApplications->firstItem() }}</td>
                                        <td>
                                            <span class="d-block">{{ __(@$jobApplication->job->title) }}</span>
                                            <span class="text--small">{{ __(@$jobApplication->job->category->name) }}</span>
                                        </td>
                                        <td>
                                            @if (@$jobApplication->job->employer)
                                                <span
                                                    class="fw-bold d-block">{{ $jobApplication->job->employer->company_name }}</span>
                                                <a class="text--small"
                                                    href="{{ route('admin.employers.detail', $jobApplication->job->employer_id) }}"><span>@</span>{{ $jobApplication->job->employer->username }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold d-block">{{ __($jobApplication->user->fullname) }}</span>
                                            <a class="text--small"
                                                href="{{ route('admin.users.detail', $jobApplication->user_id) }}"><span>@</span>{{ $jobApplication->user->username }}</a>
                                        </td>
                                        <td>@php echo $jobApplication->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.jobs.details', $jobApplication->job_id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="las la-desktop"></i>@lang('Details')
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
                @if ($jobApplications->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($jobApplications) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.jobs.index') }}" />
@endpush
