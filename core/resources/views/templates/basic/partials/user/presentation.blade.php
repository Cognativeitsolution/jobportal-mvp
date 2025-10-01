<div class="accomplishment-card">
    <div class="accomplishment-item m-0 wow fadeInUp" data-wow-duration="2s">
        <div class="accomplishment-item__top">
            <h6 class="title">
                @lang('Presentation')
            </h6>
            <button class="text--base presentationBtn" data-action="{{ route('user.presentation.store') }}"
                data-presentation="" data-title="@lang('Add Presentation')">
                @lang('Add')
            </button>
        </div>
        @if (@$user->userPresentations->count() > 0)
            <div>
                @foreach ($user->userPresentations as $userPresentation)
                    <div class="row emp-list data-list">
                        <div class="title d-flex justify-content-between align-items-center mb-2">
                            <span class="info-title text--base">{{ __($userPresentation->title) }}</span>
                            <div class="d-flex gap-2">
                                <button class="edit--text btn-edit  text--warning presentationBtn"
                                    data-action="{{ route('user.presentation.store', $userPresentation->id) }}"
                                    data-presentation="{{ $userPresentation }}" data-title="@lang('Edit Presentation')">
                                    <i class="las la-pen"></i>
                                </button>
                                <button type="button" class="edit--text btn-edit text--danger customConfirmationBtn"
                                    data-action="{{ route('user.presentation.delete', $userPresentation->id) }}"
                                    data-question="@lang('Are you sure to delete this presentation?')">
                                    <i class="las la-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="item">
                                <p class="emp-info">
                                    {{ __($userPresentation->description) }}
                                </p>
                            </div>
                            <div class="item">
                                <p class="emp-info">
                                    <a href="{{ $userPresentation->url }}" target="_blank">
                                        {{ $userPresentation->url }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="accomplishment-item__text">
                @lang('Add links to your online presentations (e.g. Slide-share presentation links etc.)')
            </p>
        @endif
    </div>
</div>

@include('Template::partials.modal.user.presentation_modal')
