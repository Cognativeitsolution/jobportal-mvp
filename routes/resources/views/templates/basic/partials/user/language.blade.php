<div class="career-profile">
    <h6 class="name wow fadeInUp" data-wow-duration="2s">
        @lang('Language')
        <button class="edit-text languageBtn" data-user_language="" data-action="{{ route('user.language.store') }}">
            <i class="las la-pen"></i>
        </button>
    </h6>
    <p class="career-profile__text wow fadeInUp" data-wow-duration="2s">
        @lang('This information is important for employers to know you better.')
    </p>

    @if (@$user->userLanguages->count() > 0)
        <ul class="skill-list mt-4">
            @foreach ($user->userLanguages as $userLanguage)
                <li class="skill-list__item">
                    <strong class="text--primary">{{ __($userLanguage->name) }}</strong>
                    <button class="text--warning edit--text ms-4 languageBtn" data-action="{{ route('user.language.store', $userLanguage->id) }}"
                        data-user_language="{{ $userLanguage }}">
                        <i class="las la-pen"></i>
                    </button>
                    <button class="text--danger edit--text ms-2 customConfirmationBtn" data-action="{{ route('user.language.delete', $userLanguage->id) }}"
                        data-question="@lang('Are You sure to delete this language?')">
                        <i class="las la-trash-alt"></i>
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@include('Template::partials.modal.user.language_modal')
