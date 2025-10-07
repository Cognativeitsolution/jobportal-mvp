@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="table-wrapper">
        <div class="flex-between gap-2 table-wrapper-header">
            <h5 class="m-0">{{ __($pageTitle) }}</h5>
        </div>
        @if ($applications->count())
            <table class="table table--responsive--xl rounded-0">
                <thead>
                    <tr>
                        <th>@lang('Job Title')</th>
                        <th>@lang('Company Name')</th>
                        <th>@lang('Application Date')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications ?? [] as $application)
                        <tr>
                            <td>{{ __(@$application->job->title) }}</td>
                            <td>{{ __(@$application->job->employer->company_name) }}</td>
                            <td>{{ showDateTime($application->created_at, 'd M, Y') }}</td>
                            <td>@php echo $application->statusBadge; @endphp</td>
                            <td>
                                <div class="action-btn-wrapper">
                                    <div class="action-buttons">
                                        <a class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="@lang('Job Detail')"
                                            href="{{ route('job.details', $application->job->id) }}">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($applications->hasPages())
                <div class="mt-3">
                    {{ paginateLinks($applications) }}
                </div>
            @endif
        @else
            @include('Template::partials.empty', ['message' => 'Job application not found!'])
        @endif
    </div>
@endsection
