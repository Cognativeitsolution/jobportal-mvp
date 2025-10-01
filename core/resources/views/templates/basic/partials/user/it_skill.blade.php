<div class="main-body__top">
    <div id="scrollspyHeading6">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">
                    @lang('IT Skills')
                </h6>
                <button class="text--base itSkillBtn" data-action="{{ route('user.it.skill.update') }}"
                        data-user_it_skill="" data-title="@lang('Add IT Skill')">
                    @lang('Add New')
                </button>
            </div>
            @if (@$user->userItSkills->count() > 0)
                <div class="card-item__inner">
                    <table class="table table--responsive--xl mt-2">
                        <thead>
                            <tr>
                                <th>@lang('Skill or Software Name')</th>
                                <th>@lang('Version')</th>
                                <th>@lang('Last Used')</th>
                                <th>@lang('Experience')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->userItSkills as $userItSkill)
                                <tr>
                                    <td>{{ __($userItSkill->name) }}</td>
                                    <td>{{ $userItSkill->version }}</td>
                                    <td>{{ $userItSkill->last_used }}</td>
                                    <td>
                                        {{ $userItSkill->year }}.{{ $userItSkill->month }}
                                        @lang('Year')
                                    </td>
                                    <td>
                                        <div class="action-btn-wrapper">
                                            <div class="action-buttons">
                                                <button class="action-btn itSkillBtn" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Edit"
                                                        data-action="{{ route('user.it.skill.update', $userItSkill->id) }}"
                                                        data-user_it_skill="{{ $userItSkill }}" data-title="@lang('Edit IT Skill')">
                                                    <i class="las la-pen"></i>
                                                </button>
                                                <button class="action-btn text--danger customConfirmationBtn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Delete"
                                                        data-action="{{ route('user.it.skill.delete', $userItSkill->id) }}"
                                                        data-question="@lang('Are You sure to delete this IT skill?')">
                                                    <i class="las la-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="profile-dashboard-item__text">
                    @lang('Demonstrate your technical expertise by highlighting the software and skills in which you excel.')
                </p>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.it_skill_modal')
