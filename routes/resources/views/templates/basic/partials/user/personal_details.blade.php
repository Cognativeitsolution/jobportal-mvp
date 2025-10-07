<div  id="scrollspyHeading11">
    <div class="career-profile">
        <h6 class="name wow fadeInUp" data-wow-duration="2s">
            @lang('Personal Details')
            <button class="edit-text personalDetailBtn">
                <i class="las la-pen"></i>
            </button>
        </h6>
        <p class="career-profile__text wow fadeInUp" data-wow-duration="2s">
            @lang('This information is important for employers to know you better.')
        </p>
        <div class="career-profile__wrapper">
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Gender')</p>
                @if (@$user->gender)
                    <span class="profile-list-item__data">
                        @if ($user->gender == Status::MALE)
                            @lang('Male')
                        @elseif($user->gender == Status::FEMALE)
                            @lang('Female')
                        @else
                            @lang('Other')
                        @endif
                    </span>
                @else
                    <button class="profile-list-item__link personalDetailBtn">
                        @lang('Add gender')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Marital Status')</p>
                @if (@$user->married_status)
                    <span class="profile-list-item__data">
                        @if ($user->married_status == Status::SINGLE)
                            @lang('Single')
                        @elseif($user->married_status == Status::MARRIED)
                            @lang('Married')
                        @elseif($user->married_status == Status::DIVORCED)
                            @lang('Divorced')
                        @else
                            @lang('Separated')
                        @endif
                    </span>
                @else
                    <button class="profile-list-item__link personalDetailBtn">
                        @lang('Add marital status')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Career Break')</p>
                <span class="profile-list-item__data">
                    @if (@$user->career_break == Status::YES)
                        @lang('Yes')
                    @else
                        @lang('No')
                    @endif
                </span>
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Date of Birth')</p>
                @if (@$user->birth_date)
                    <span class="profile-list-item__data">{{ showDateTime($user->birth_date, 'd M, Y') }}</span>
                @else
                    <button class="profile-list-item__link personalDetailBtn">
                        @lang('Add Date of birth')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('Blood Group')</p>
                @if (@$user->blood_group)
                    <span class="profile-list-item__data">{{ $user->blood_group }}</span>
                @else
                    <button class="profile-list-item__link personalDetailBtn">
                        @lang('Add Blood Group')
                    </button>
                @endif
            </div>
            <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
                <p class="profile-list-item__title">@lang('National ID')</p>
                @if (@$user->national_id)
                    <span class="profile-list-item__data">{{ $user->national_id }}</span>
                @else
                    <button class="profile-list-item__link personalDetailBtn">
                        @lang('Add National ID')
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@include('Template::partials.modal.user.personal_detail_modal')
