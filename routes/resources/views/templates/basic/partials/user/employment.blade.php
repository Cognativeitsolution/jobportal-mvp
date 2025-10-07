<div class="main-body__top">
    <div id="scrollspyHeading4">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">
                    @lang('Employment')
                    @if (@$user->profile_update_percent_list['company_job_title'])
                        <span class="rate">
                            @lang('Add')
                            {{ @$user->profile_update_percent_list['company_job_title'] }}%
                        </span>
                    @endif
                </h6>
                <button class="text--base employmentBtn" data-action="{{ route('user.employment.store') }}"
                        data-employment="" data-title="@lang('Add Employment')">
                    @lang('Add Employment')
                </button>
            </div>
            @if (@$user->profile_update_percent_list['company_job_title'])
                <p class="profile-dashboard-item__text">
                    @lang('Your employment details will help recruiters understand your experience.')
                </p>
            @else
                <div>
                    @foreach ($employments as $employment)
                        <div class="row emp-list data-list">
                            <div class="title d-flex justify-content-between align-items-center">
                                <span class="info-title text--base">{{ __($employment->designation) }}</span>
                                <div class="d-flex gap-2">
                                    <button class="edit--text btn-edit text--warning employmentBtn"
                                            data-action="{{ route('user.employment.store', $employment->id) }}"
                                            data-employment="{{ $employment }}" data-title="@lang('Edit Employment')">
                                        <i class="las la-pen"></i>
                                    </button>
                                    <button class="edit--text btn-edit text--danger customConfirmationBtn"
                                            data-action="{{ route('user.employment.delete', $employment->id) }}"
                                            data-question="@lang('Are you sure to delete this employment details?')">
                                        <i class="las la-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="item">
                                    <p class="item__title">@lang('Company name')</p>
                                    <span class="emp-info">
                                        <span class="emp-info__style"> : </span>
                                        {{ __($employment->company_name) }}
                                    </span>
                                </div>
                                <div class="item">
                                    <p class="item__title">@lang('Department')</p>
                                    <span class="emp-info">
                                        <span class="emp-info__style"> : </span>
                                        {{ __($employment->department) }}
                                    </span>
                                </div>
                                <div class="item">
                                    <p class="item__title">@lang('Employment type')</p>
                                    <p class="emp-info">
                                        <span class="emp-info__style"> : </span>
                                        <span>{{ __(@$employment->type->name) }}</span>
                                    </p>
                                </div>
                                <div class="item">
                                    <p class="item__title">@lang('Time period')</p>
                                    <p class="emp-info">
                                        <span class="emp-info__style"> : </span>
                                        <span>
                                            @if ($employment->currently_work)
                                                {{ showDateTime($employment->start_date, 'M Y') }}
                                                @lang('to Present')
                                            @else
                                                {{ showDateTime($employment->start_date, 'M Y') }}
                                                <strong>@lang('to')</strong>
                                                {{ showDateTime($employment->end_date, 'M Y') }}
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                <div class="item prefill">
                                    <p class="item__title">@lang('Responsibilities')</p>
                                    <div class="emp-info">
                                        <span class="emp-info__style"> : </span>
                                        @php echo nl2br($employment->responsibilities); @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.employment_modal')
