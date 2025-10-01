@extends('Template::employer.layouts.master')
@section('content')
    <div class="company-profile-wrapper responsive-filter-card">
        <div class="card-item w-100 p-0 mb-4">
            <div class="card-item__inner">
                <form>
                    <div class="d-flex flex-wrap gap-3 gap-lg-4">
                        <div class="flex-grow-1">
                            <label class="form--label">@lang('Applicant Username')</label>
                            <input type="text" name="search" value="{{ request()->search }}" class="form--control">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form--label">@lang('Jobs')</label>
                            <select name="job_id" class="form--control select2" data-minimum-results-for-search="-1">
                                <option value="">@lang('All')</option>
                                @foreach ($jobList as $job)
                                    <option value="{{ $job->id }}" @selected($job->id == request('job_id'))>
                                        {{ __($job->title) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-grow-1 align-self-end">
                            <button class="btn btn--base w-100">
                                <i class="las la-filter"></i> @lang('Filter')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="company-profile-wrapper">
        <div class="card-item p-0 w-100">
            <div class="card-item__header list-header">
                <h6 class="card-item__title">{{ __($pageTitle) }}</h6>
            </div>
            <div class="card-item__inner p-0">
                @if ($appliedJobs->count())
                    <table class="table table--responsive--lg m-0 border-0">
                        <thead>
                            <tr>
                                <th>@lang('Applicant')</th>
                                <th>@lang('Job Title')</th>
                                <th>@lang('Location')</th>
                                <th>@lang('Expected Salary')</th>
                                <th>@lang('Applied')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appliedJobs as $appliedJob)
                                <tr>
                                    <td>
                                        <div class="company flex-align align-items-start">
                                            <div class="company__thumb">
                                                <img src="{{ getProfileImage($appliedJob->user->image) }}" class="fit-image"
                                                     alt="applicant image">
                                            </div>
                                            <div class="company__content">
                                                <h6 class="company__name">{{ $appliedJob->user->fullname }}</h6>
                                                <ul class="text-list mb-0">
                                                    <li class="text-list__item">
                                                        <span class="text-list__icon">
                                                            <i class="las la-id-card"></i>
                                                        </span>
                                                        @if ($appliedJob->user->designation)
                                                            {{ __($appliedJob->user->designation) }}
                                                        @else
                                                            @lang('Fresher')
                                                        @endif
                                                    </li>
                                                    <li class="text-list__item">
                                                        <span class="text-list__icon">
                                                            <i class="las la-user"></i>
                                                        </span>
                                                        {{ __($appliedJob->user->username) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ __(@$appliedJob->job->title) }}</td>
                                    <td>{{ __($appliedJob->user->country_name) }}</td>
                                    <td>{{ showAmount($appliedJob->expected_salary) }}</td>
                                    <td>{{ showDateTime($appliedJob->job->created_at) }}</td>
                                    <td>@php echo $appliedJob->statusBadge;@endphp</td>
                                    <td>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                <a href="{{ route('candidate.profile', $appliedJob->user->id) }}"
                                                   class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-title="@lang('Profile Preview')" target="_blank">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                                <a href="{{ route('employer.job.applicants.all', [$appliedJob->job->id, $appliedJob->user->id]) }}"
                                                   class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-title="@lang('View On Job List')" target="_blank">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @include('Template::partials.empty', [
                        'message' => 'No transaction data found.',
                    ])
                @endif
            </div>
            @if ($appliedJobs->hasPages())
                <div class="card-item__footer">
                    {{ paginateLinks($appliedJobs) }}
                </div>
            @endif
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
        })(jQuery);
    </script>
@endpush
