<div  id="scrollspyHeading10">
    <div class="career-profile">
        <h6 class="name wow fadeInUp" data-wow-duration="2s">
            @lang('Career profile')
            <button class="edit-text careerBtn">
                <i class="las la-pen"></i>
            </button>
        </h6>
        <p class="career-profile__text wow fadeInUp" data-wow-duration="2s">
            @lang('Add details about your current and preferred career profile. This helps us personalize your job recommendations.')
        </p>
        <div class="career-profile__wrapper">
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Current industry')</p>
                @if (@$user->industry_id)
                    <span class="profile-list-item__data">{{ __(@$user->industry->name) }}</span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add current industry')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Department')</p>
                @if (@$user->department_id)
                    <span class="profile-list-item__data">{{ __(@$user->department->title) }}</span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add department')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Desired job type')</p>
                @if (@$user->desired_job_type)
                    <span class="profile-list-item__data">
                        {{ $user->desired_job_type == Status::PERMANENT ? trans('Permanent') : trans('Contractual') }}
                    </span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add desired job type')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Desired employment type')</p>
                @if (@$user->type_id)
                    <span class="profile-list-item__data">{{ __(@$user->type->name) }}</span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add desired employment type')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Preferred work location')</p>
                @if (@$user->location_id)
                    <span class="profile-list-item__data">{{ __(@$user->location->name) }}</span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add preferred work location')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Preferred shift')</p>
                @if (@$user->shift_id)
                    <span class="profile-list-item__data">{{ __(@$user->shift->name) }}</span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add preferred shift')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Expected salary')</p>
                @if (@$user->expected_salary && @$user->expected_salary > 0)
                    <span class="profile-list-item__data">{{ showAmount($user->expected_salary) }}</span>
                @else
                    <button class="profile-list-item__link careerBtn">
                        @lang('Add expected salary')
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@include('Template::partials.modal.user.career_modal')
