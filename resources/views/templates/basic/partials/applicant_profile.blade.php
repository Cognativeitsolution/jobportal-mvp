@php
    $skills = App\Models\UserSkill::where('user_id', $user->id)->orderByDesc('id')->get();
    $educations = App\Models\EducationalQualification::where('user_id', $user->id)->orderByDesc('id')->get();
    $employments = App\Models\EmploymentHistory::where('user_id', $user->id)->orderByDesc('id')->get();
@endphp
<div class="profile-wrapper">
    <div class="profile">
        <div class="profile__thumb">
            <img src="{{ getProfileImage($user->image) }}" alt="user-image">
        </div>
        <div class="profile-content">
            <div>
                <h5 class="profile-content__name">{{ __($user->fullname) }}</h5>
                <p class="mt-2 fs-14 flex-align gap-1">
                    <span class="text-list__icon"><i class="las la-user"></i></span>
                    @if ($user->work_status == Status::WORK_STATUS_EXPERIENCE)
                        {{ __($user->designation) }}
                    @elseif($user->work_status == Status::WORK_STATUS_FRESHER)
                        @lang('Fresher')
                    @else
                        @lang('Not mentioned')
                    @endif
                </p>
                @if (@$userAppliedJob)
                    <div class="profile-content__list">
                        <div>
                            <span class="title">@lang('Application Date')</span>
                            <p class="text">{{ showDateTime($userAppliedJob->created_at, 'd M, Y') }}</p>
                        </div>
                        <div>
                            <span class="title">@lang('Expected Salary')</span>
                            <p class="text">{{ showAmount($userAppliedJob->expected_salary) }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="text-end">
                @if (@$userAppliedJob && @$userAppliedJob->status == Status::JOB_APPLY_PENDING)
                    <div class="btn-wrapper">
                        <button
                            class="btn-outline--base btn btn--sm {{ $userAppliedJob->status == Status::JOB_APPLY_PENDING ? '' : 'd-none' }} approveBtn"
                            data-question="@lang('Are you sure to select this applicant?')">
                            <span class="icon"><i class="fas fa-user-check"></i></span> @lang('Select')
                        </button>
                        <button
                            class="btn-outline--secondary btn btn--sm {{ $userAppliedJob->status == Status::JOB_APPLY_PENDING ? '' : 'd-none' }} draftBtn"
                            data-question="@lang('Are you sure to draft this applicant?')">
                            <span class="icon"><i class="far fa-bookmark"></i></span> @lang('Draft')
                        </button>
                    </div>
                @endif
                @if (@$userAppliedJob && @$userAppliedJob->status == Status::JOB_APPLY_DRAFT)
                    <div class="btn-wrapper justify-content-end">
                        <button class="btn-outline--base btn approveBtn btn--sm" data-question="@lang('Are you sure to select this applicant?')">
                            <span class="icon"><i class="fas fa-user-check"></i></span> @lang('Select')
                        </button>
                    </div>
                @endif

                @if (@$userAppliedJob->resume)
                    <a class="download-link" href="{{ asset('upload/resume/' . @$userAppliedJob->resume) }}" download>
                        @lang('CV Download')
                        <span class="icon text--base"><i class="las la-download"></i></span>
                    </a>
                @elseif ($user->resume)
                    <a class="download-link" href="{{ route('resume.download', $user->id) }}" download>
                        @lang('CV Download')
                        <span class="icon text--base"><i class="las la-download"></i></span>
                    </a>
                @endif

            </div>
        </div>
    </div>
</div>
<div class="candidate-profile">
    <div class="candidate-profile__left">
        <div class="about education-qualification">
            <h6 class="education-qualification__title">@lang('ABOUT CANDIDATE')</h6>
            <p class="about__desc">
                @php echo nl2br(__($user->summary)); @endphp
            </p>
        </div>
        <div class="award-list mt-5">
            <h6 class="award-list__title">
                @lang('EMPLOYMENT')
            </h6>
            @foreach ($employments ?? [] as $employment)
                <div class="award-list__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="award-list__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($employment->designation) }}</p>
                                <span class="year">
                                    @if ($employment->currently_work)
                                        {{ showDateTime($employment->start_date, 'M Y') }}
                                        @lang('to Present')
                                    @else
                                        {{ showDateTime($employment->start_date, 'M Y') }}
                                        -
                                        {{ showDateTime($employment->end_date, 'M Y') }}
                                    @endif
                                </span>
                            </div>
                            <span class="award-list__content-text">{{ __($employment->company_name) }}</span>
                            <div class="d-flex align-items-center">
                                <p class="award-list__desc me-2">{{ __($employment->department) }}</p>
                                |
                                <p class="award-list__desc ms-2">{{ __(@$employment->type->name) }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="award-list__desc">
                        @php echo nl2br($employment->responsibilities); @endphp
                    </p>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('EDUCATION')
            </h6>
            @foreach ($educations ?? [] as $education)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($education->educationDegree->name) }}</p>
                                <span class="year">
                                    {{ $education->passing_year }}
                                    ({{ $education->duration }} @lang('Year'))
                                </span>
                            </div>
                            <span class="education-qualification__content-text">
                                {{ __($education->institute) }}
                            </span>
                            <p class="education-qualification__desc">
                                {{ __(@$education->educationGroup->name) }}
                            </p>
                            <p class="education-qualification__desc">
                                {{ $education->cgpa_or_marks }}
                                (@lang('Scale') - {{ $education->scale }})
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('PROJECTS')
            </h6>
            @foreach ($user->userProjects ?? [] as $userProject)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($userProject->title) }}</p>
                                @php echo $userProject->statusBadge; @endphp
                            </div>
                            <span class="education-qualification__content-text">
                                <a href="{{ $userProject->link }}" target="_blank">
                                    {{ $userProject->link }}
                                    <i class="las la-external-link-alt"></i>
                                </a>
                            </span>
                            <p class="education-qualification__desc">
                                {{ __($userProject->details) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('IT SKILLS')
            </h6>
            @foreach ($user->userItSkills ?? [] as $userItSkill)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($userItSkill->name) }}</p>
                                <span class="year">
                                    {{ $userItSkill->version }}
                                    (@lang('Version'))
                                </span>
                            </div>
                            <span class="education-qualification__content-text">
                                @lang('Experience') {{ $userItSkill->year }}.{{ $userItSkill->month }}
                                @lang('year')
                            </span>
                            <p class="education-qualification__desc">
                                @lang('Last used'): {{ $userItSkill->last_used }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('PRESENTATION')
            </h6>
            @foreach ($user->userPresentations ?? [] as $userPresentation)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($userPresentation->title) }}</p>
                            </div>
                            <span class="education-qualification__content-text">
                                <a href="{{ $userPresentation->url }}" target="_blank">
                                    {{ $userPresentation->url }}
                                    <i class="las la-external-link-alt"></i>
                                </a>
                            </span>
                            <p class="education-qualification__desc">
                                {{ __($userPresentation->description) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('CERTIFICATION')
            </h6>
            @foreach ($user->userCertifications ?? [] as $userCertification)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($userCertification->name) }}</p>
                            </div>
                            <span class="education-qualification__content-text">
                                {{ __($userCertification->institute) }}
                            </span>
                            <p class="education-qualification__desc">
                                {{ getAmount($userCertification->duration) }} @lang('Months')
                                (@lang('Duration'))
                            </p>
                            <p class="education-qualification__desc">
                                {{ __($userCertification->location) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('WHITE PAPER / RESEARCH PUBLICATION / JOURNAL ENTRY')
            </h6>
            @foreach ($user->userPublications ?? [] as $userPublication)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($userPublication->title) }}</p>
                            </div>
                            <span class="education-qualification__content-text">
                                <a href="{{ $userPublication->url }}" target="_blank">
                                    {{ $userPublication->url }}
                                    <i class="las la-external-link-alt"></i>
                                </a>
                            </span>
                            <p class="education-qualification__desc">
                                {{ showDateTime($userPublication->published_date, 'd M, Y') }}
                            </p>
                            <p class="education-qualification__desc">
                                {{ __($userPublication->publication_details) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="education-qualification mt-5">
            <h6 class="education-qualification__title">
                @lang('PATENT')
            </h6>
            @foreach ($user->userPatents ?? [] as $userPatent)
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="title">{{ __($userPatent->title) }}</p>
                                @php echo $userPatent->statusBadge; @endphp
                            </div>
                            <span class="education-qualification__content-text">
                                <a href="{{ $userPatent->url }}" target="_blank">
                                    {{ $userPatent->url }}
                                    <i class="las la-external-link-alt"></i>
                                </a>
                            </span>
                            @if ($userPatent->status == Status::PATENT_ISSUED)
                                <p class="education-qualification__desc">
                                    {{ showDateTime($userPatent->issued_date, 'd M, Y') }}
                                </p>
                            @endif
                            <p class="education-qualification__desc">
                                {{ __($userPatent->details) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="candidate-profile__right">
        <div class="skill-wrapper education-qualification mt-0">
            <h6 class="skill-wrapper__title">@lang('Skills')</h6>
            <div class="candidate-skill-list">
                @foreach ($skills ?? [] as $skill)
                    <div class=">
                        <p class="candidate-skill-list__item">
                        <span class="text">{{ __($skill->skill->name) }}</span>
                        <span class="number">{{ $skill->expertise }}% </span>
                        </p>
                        <div class="progress progress--base">
                            <div class="progress-bar" role="progressbar" aria-label="Animated striped example"
                                aria-valuenow="{{ $skill->expertise }}" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $skill->expertise }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="education-qualification">
            <h6 class="education-qualification__title">
                @lang('Contact')
            </h6>
            <div class="education-qualification__item">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="education-qualification__content">
                        <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="info-item-wrapper__icon"><i class="las la-envelope"></i></span>
                                <span class="text">@lang('Email')</span>
                            </div>
                            <p class="title">
                                {{ $user->email }}
                            </p>
                        </div>
                        <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="info-item-wrapper__icon"><i class="las la-phone"></i></span>
                                <span class="text">@lang('Phone')</span>
                            </div>
                            <p class="title">
                                {{ $user->mobileNumber }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->userOnlineProfiles->count())
            <div class="education-qualification mt-4">
                <h6 class="education-qualification__title">
                    @lang('Online Profile')
                </h6>
                <ul class="skill-list">
                    @foreach ($user->userOnlineProfiles ?? [] as $userOnlineProfile)
                        <li class="skill-list__item px-3">
                            <a href="{{ $userOnlineProfile->link }}" target="_blank">
                                <strong>{{ __($userOnlineProfile->social_media_name) }}</strong>
                                <i class="las la-external-link-alt"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="education-qualification">
            <h6 class="education-qualification__title">
                @lang('Present Address')
            </h6>
            <div class="education-qualification__item">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="education-qualification__content address-box">
                        <div class="d-flex align-items-center address-box__title flex-wrap gap-3">
                            <p class="title">{{ __($user->address) }}</p>
                        </div>
                        <p class="education-qualification__desc address-box__desc">
                            {{ __($user->state) }},
                            {{ __($user->city) }}
                        </p>
                        <p class="education-qualification__desc address-box__desc">
                            {{ __($user->zip) }},
                            {{ __($user->country_name) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->permanent_address)
            <div class="education-qualification address-box-wrapper mt-4">
                <h6 class="education-qualification__title">
                    @lang('Permanent Address')
                </h6>
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content address-box">
                            <div class="d-flex align-items-center address-box__title flex-wrap gap-3">
                                <p class="title">{{ __($user->permanent_address['address']) }}</p>
                            </div>
                            <p class="education-qualification__desc address-box__desc">
                                {{ __($user->permanent_address['state']) }},
                                {{ __($user->permanent_address['city']) }}
                            </p>
                            <p class="education-qualification__desc address-box__desc">
                                {{ __($user->permanent_address['zip']) }},
                                {{ __($user->permanent_address['country']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="education-qualification">
            <h6 class="education-qualification__title">
                @lang('Personal Information')
            </h6>
            <div class="education-qualification__item">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="education-qualification__content">
                        @if ($user->gender)
                            <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="info-item-wrapper__icon">
                                        <i class="las la-mars"></i>
                                    </span>
                                    <span class="text">@lang('Gender')</span>
                                </div>
                                <p class="title">
                                    @if ($user->gender == Status::MALE)
                                        @lang('Male')
                                    @elseif($user->gender == Status::FEMALE)
                                        @lang('Female')
                                    @else
                                        @lang('Other')
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if ($user->married_status)
                            <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="info-item-wrapper__icon">
                                        <i class="las la-ring"></i>
                                    </span>
                                    <span class="text">@lang('Marital Status')</span>
                                </div>
                                <p class="title">
                                    @if ($user->married_status == Status::SINGLE)
                                        @lang('Single')
                                    @elseif($user->married_status == Status::MARRIED)
                                        @lang('Married')
                                    @elseif($user->married_status == Status::DIVORCED)
                                        @lang('Divorced')
                                    @elseif($user->married_status == Status::SEPARATED)
                                        @lang('Separated')
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if ($user->blood_group)
                            <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="info-item-wrapper__icon">
                                        <i class="las la-tint"></i>
                                    </span>
                                    <span class="text">@lang('Blood Group')</span>
                                </div>
                                <p class="title">
                                    {{ $user->blood_group }}
                                </p>
                            </div>
                        @endif
                        @if ($user->national_id)
                            <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="info-item-wrapper__icon">
                                        <i class="las la-id-card"></i>
                                    </span>
                                    <span class="text">@lang('NID Number')</span>
                                </div>
                                <p class="title">
                                    {{ $user->national_id }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if ($user->userLanguages->count())
            <div class="education-qualification mt-4">
                <h6 class="education-qualification__title">
                    @lang('Language')
                </h6>
                <div class="education-qualification__item">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="education-qualification__content">
                            @foreach ($user->userLanguages ?? [] as $userLanguage)
                                <div class="info-item-wrapper d-flex align-items-center flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text">{{ __($userLanguage->name) }}</span>
                                    </div>
                                    <p class="title">
                                        @if ($userLanguage->proficiency == Status::LANGUAGE_BEGINNER)
                                            @lang('Beginner')
                                        @elseif ($userLanguage->proficiency == Status::LANGUAGE_PROFICIENT)
                                            @lang('Proficient')
                                        @else
                                            @lang('Expert')
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('style')
    <style>
        .info-item-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 10px;
        }

        .info-item-wrapper:last-child {
            margin-bottom: 0;
        }

        .candidate-profile__right .education-qualification {
            border-bottom: 1px solid hsl(var(--border-color));
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .candidate-profile__right .education-qualification:last-child {
            border-bottom: 0;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .language-box.skill-list {
            gap: 10px;
        }

        .language-box.skill-list .skill-list__item {
            background-color: hsl(var(--white));
        }

        .education-qualification__content {
            width: 100%;
        }

        .info-item-wrapper__icon {
            width: 30px;
            height: 30px;
            background: hsl(var(--base)/.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: hsl(var(--base));
            font-size: 16px;
        }

        .info-item-wrapper .text {
            font-size: 14px;
            font-weight: 500;
            color: hsl(var(--heading-color));
        }

        .address-box__title .title {
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .address-box__desc {
            margin-bottom: 5px;
            color: hsl(var(--heading-color));
        }

        .address-box-wrapper {
            border-bottom: 1px solid hsl(var(--border-color));
            padding-bottom: 20px;
        }

        .btn-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .download-link {
            padding: 8px;
            color: hsl(var(--text-color));
        }

        .profile-content__list {
            display: flex;
            align-items: flex-start;
            gap: 5px 32px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .profile-content__list .title {
            font-size: 13px;
            font-weight: 400;
        }

        .profile-content__list .text {
            color: hsl(var(--heading-color));
            font-weight: 600;
        }

        .candidate-skill-list__item {
            font-size: 12px !important;
            font-weight: 600;
        }
    </style>
@endpush
