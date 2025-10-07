<div class="main-body__top">
    <div id="scrollspyHeading5">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">
                    @lang('Education')
                    @if (@$user->profile_update_percent_list['education'])
                        <span class="rate">
                            @lang('Add')
                            {{ @$user->profile_update_percent_list['education'] }}%
                        </span>
                    @endif
                </h6>
                <button class="text--base educationBtn" data-action="{{ route('user.education.store') }}"
                    data-education="" data-title="@lang('Add Education')">
                    @lang('Add Education')
                </button>
            </div>
            @if (@$user->profile_update_percent_list['education'])
                <p class="profile-dashboard-item__text">
                    @lang('Your qualifications help employers know your educational background.')
                </p>
            @else
                <div>
                    @foreach ($userEducations as $education)
                        <div class="row emp-list data-list">
                            <div class="title d-flex justify-content-between align-items-center">
                                <span class="info-title text--base">{{ __($education->educationLevel->name) }}</span>
                                <div class="d-flex gap-2">
                                    <button class="edit--text btn-edit text--warning educationBtn"
                                        data-action="{{ route('user.education.store', $education->id) }}"
                                        data-education="{{ $education }}" data-title="@lang('Edit Education')">
                                        <i class="las la-pen"></i>
                                    </button>
                                    <button type="button"
                                        class="edit--text btn-edit text--danger customConfirmationBtn"
                                        data-action="{{ route('user.education.delete', $education->id) }}"
                                        data-question="@lang('Are you sure to delete this education level?')">
                                        <i class="las la-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="item">
                                    <p class="item__title">@lang('Exam/Degree')</p>
                                    <p class="emp-info">
                                        <span class="emp-info__style"> : </span>
                                        {{ __($education->educationDegree->name) }}
                                    </p>
                                </div>
                                <div class="item">
                                    <p class="item__title">@lang('University/Institute')</p>
                                    <p class="emp-info"> <span class="emp-info__style"> : </span>
                                        {{ __($education->institute) }}</p>
                                </div>
                                <div class="item">
                                    <p class="item__title">@lang('Major/Group')</p>
                                    <p class="emp-info"> <span class="emp-info__style"> : </span>
                                        {{ __($education->educationGroup->name) }}</p>
                                </div>
                                <div class="item">
                                    <p class="item__title">@lang('CGPA/Marks')</p>
                                    <p class="emp-info"> <span class="emp-info__style"> : </span>
                                        {{ $education->cgpa_or_marks }}</p>
                                </div>
                                <div class="item prefill">
                                    <p class="item__title">@lang('Scale')</p>
                                    <p class="emp-info"> <span class="emp-info__style"> : </span>
                                        {{ $education->scale }}</p>
                                </div>
                                <div class="item prefill">
                                    <p class="item__title">@lang('Duration')</p>
                                    <p class="emp-info"> <span class="emp-info__style"> : </span>
                                        {{ $education->duration }} @lang('Year')</p>
                                </div>
                                <div class="item prefill">
                                    <p class="item__title">@lang('Passing year')</p>
                                    <p class="emp-info"> <span class="emp-info__style"> : </span>
                                        {{ $education->passing_year }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.education_modal')
