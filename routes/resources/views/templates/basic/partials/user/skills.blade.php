<div class="main-body__top">
    <div id="scrollspyHeading3">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">
                    @lang('Skills')
                    @if (@$user->profile_update_percent_list['skill'])
                        <span class="rate">
                            @lang('Add')
                            {{ @$user->profile_update_percent_list['skill'] }}%
                        </span>
                    @endif
                </h6>
                <button class="text--base skillBtn" data-skill="" data-action="{{ route('user.skill.update') }}" data-title="@lang('Add New Skill')">
                    @lang('Add skills')
                </button>
            </div>
            <p class="profile-dashboard-item__text">
                @if (@$user->profile_update_percent_list['skill'])
                    @lang('Recruiters seek candidates who possess specific key skills essential to the role.')
                @else
                    <ul class="skill-list">
                        @foreach ($user->userSkills ?? [] as $userSkill)
                            <li class="skill-list__item">
                                <strong>{{ __($userSkill->skill->name) }}</strong>
                                <strong class="text--base">{{ $userSkill->expertise }}%</strong>
                                <button class="edit--text text--warning ms-4 skillBtn" data-skill="{{ $userSkill }}"
                                    data-action="{{ route('user.skill.update', $userSkill->id) }}" data-title="@lang('Edit Skill')">
                                    <i class="las la-pen"></i>
                                </button>
                                <button class="edit--text text--danger ms-2 customConfirmationBtn"
                                    data-question="@lang('Are you sure to delete this skill?')"
                                    data-action="{{ route('user.skill.delete', $userSkill->id) }}">
                                    <i class="las la-trash-alt"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </p>
        </div>
    </div>
</div>

@include('Template::partials.modal.user.skill_modal')
