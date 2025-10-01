@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end w-100">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm">
                    <i class="las la-filter"></i>@lang('Filter')
                </button>
            </div>
            @php
                $categories = App\Models\Category::where('status', 1)->get();
                $types = App\Models\Type::where('status', 1)->get();
                $shifts = App\Models\Shift::where('status', 1)->get();
                $locations = App\Models\Location::where('status', 1)->get();
            @endphp
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form>
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Job Title / Company Name')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Category')</label>
                                <select name="category_id" class="form-control select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request()->category_id == $category->id)>
                                            {{ __($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Types')</label>
                                <select name="type_id" class="form-control select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}" @selected(request()->type_id == $type->id)>
                                            {{ __($type->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Shift')</label>
                                <select name="shift_id" class="form-control select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}" @selected(request()->shift_id == $shift->id)>
                                            {{ __($shift->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Location')</label>
                                <select name="location_id" class="form-control select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" @selected(request()->location_id == $location->id)>
                                            {{ __($location->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45">
                                    <i class="fas fa-filter"></i>@lang('Filter')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card  ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title | Employer')</th>
                                    <th>@lang('Vacancy')</th>
                                    <th>@lang('Deadline')</th>
                                    <th>@lang('Total Applications')</th>
                                    <th>@lang('Featured')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                    <tr>
                                        <td>
                                            <span class="d-block">{{ __(@$job->title) }}</span>
                                            <a class="text--small"
                                                href="{{ route('admin.employers.detail', $job->employer_id) }}">{{ __(@$job->employer->company_name) }}</a>
                                        </td>
                                        <td><span class="d-block">{{ __(@$job->vacancy) }}</span></td>
                                        <td><span class="text--small">{{ __(@$job->deadline) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.jobs.apply.list', $job->id) }}"
                                                class="badge badge--primary">
                                                {{ $job->total_apply }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($job->featured)
                                                <span class="badge badge--success">@lang('Yes')</span>
                                            @else
                                                <span class="badge badge--dark">@lang('No')</span> <br>
                                            @endif
                                        </td>
                                        <td> @php echo $job->statusBadge; @endphp </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--info" data-bs-toggle="dropdown"
                                                type="button" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                                @lang('Action')
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.jobs.details', $job->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                                @if ($job->status != Status::JOB_PENDING && $job->status != Status::JOB_REJECTED)
                                                    @if ($job->featured)
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.jobs.featured', $job->id) }}"
                                                            data-question="@lang('Are you sure to unfeatured this job?')">
                                                            <i class="las la-arrow-alt-circle-left"></i>
                                                            @lang('Unfeatured It')
                                                        </button>
                                                    @else
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.jobs.featured', $job->id) }}"
                                                            data-question="@lang('Are you sure to featured this job?')">
                                                            <i class="las la-arrow-alt-circle-right"></i>
                                                            @lang('Featured It')
                                                        </button>
                                                    @endif
                                                @endif
                                                @if ($job->status == Status::JOB_APPROVED || $job->status == Status::JOB_EXPIRED)
                                                    <a href="{{ route('admin.jobs.applicants', $job->id) }}"
                                                        class="dropdown-item">
                                                        <i class="las la-user-friends"></i>
                                                        @lang('Applicants')
                                                    </a>
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
                @if ($jobs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($jobs) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('style')
    <style>
        .dropdown-item {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-menu {
            padding: 0;
        }
    </style>
@endpush
