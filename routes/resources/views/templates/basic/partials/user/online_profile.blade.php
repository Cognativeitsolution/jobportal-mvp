<div class="accomplishment-card">
    <div class="accomplishment-item m-0 wow fadeInUp" data-wow-duration="2s">
        <div class="accomplishment-item__top">
            <h6 class="title">@lang('Online Profile')</h6>
            <button class="text--base onlineProfileBtn" data-online_profile=""
                data-action="{{ route('user.online.profile.store') }}" data-title="@lang('Add Online Profile')">
                @lang('Add')
            </button>
        </div>
        @if ($user->userOnlineProfiles->count() > 0)
            <ul class="skill-list">
                @foreach ($user->userOnlineProfiles as $userOnlineProfile)
                    <li class="skill-list__item">
                        <a href="{{ $userOnlineProfile->link }}" target="_blank">
                            <strong>{{ __($userOnlineProfile->social_media_name) }}</strong>
                        </a>
                        <button class="edit--text  text--warning onlineProfileBtn ms-4"
                            data-action="{{ route('user.online.profile.store', $userOnlineProfile->id) }}"
                            data-online_profile="{{ $userOnlineProfile }}" data-title="@lang('Edit Online Profile')">
                            <i class="las la-pen"></i>
                        </button>
                        <button class="edit--text text--danger customConfirmationBtn ms-2"
                            data-action="{{ route('user.online.profile.delete', $userOnlineProfile->id) }}"
                            data-question="@lang('Are You sure to delete this online profile?')">
                            <i class="las la-trash-alt"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="accomplishment-item__text">
                @lang('Add link to online professional profiles (e.g. Github, Linkedin, etc.)')
            </p>
        @endif
    </div>
</div>

@include('Template::partials.modal.user.online_profile_modal')
