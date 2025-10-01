@extends('Template::layouts.user_dashboard')
@section('content')
    <div class="table-wrapper">
        <div class="flex-between gap-2 table-wrapper-header">
            <h5 class="m-0">{{ __($pageTitle) }}</h5>
        </div>
        @if ($favorites->count())
            <table class="table table--responsive--xl rounded-0">
                <thead>
                    <tr>
                        <th>@lang('Job Title')</th>
                        <th>@lang('Company Name')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favorites ?? [] as $favorite)
                        <tr>
                            <td>{{ __(@$favorite->job->title) }}</td>
                            <td>{{ __(@$favorite->job->employer->company_name) }}</td>
                            <td>
                                <div class="action-btn-wrapper">
                                    <div class="action-buttons">
                                        <a class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Details" href="{{ route('job.details', $favorite->job->id) }}">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <button class="action-btn text--danger customConfirmationBtn"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                            data-action="{{ route('user.favorite.job.delete', $favorite->id) }}"
                                            data-question="@lang('Are You sure to delete this favorite job?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($favorites->hasPages())
                <div class="mt-3">
                    {{ paginateLinks($favorites) }}
                </div>
            @endif
        @else
            @include('Template::partials.empty', ['message' => 'Favorite job not found!'])
        @endif
    </div>
    @include('Template::partials.modal.confirmation_modal')
@endsection
