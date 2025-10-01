<div class="accomplishment-card">
    <div id="scrollspyHeading9">
        <div class="accomplishment-item m-0 wow fadeInUp " data-wow-duration="2s">
            <div class="accomplishment-item__top">
                <h6 class="title">
                    @lang('White paper / Research publication / Journal entry')
                </h6>
                <button class="text--base publicationBtn" data-action="{{ route('user.publication.store') }}"
                        data-publication="" data-title="@lang('Add Publication')">
                    @lang('Add')
                </button>
            </div>
            @if (@$user->userPublications->count() > 0)
                <div>
                    @foreach ($user->userPublications ?? [] as $userPublication)
                        <div class="row emp-list data-list">
                            <div class="title d-flex justify-content-between align-items-center mb-2">
                                <span class="info-title text--base">{{ __($userPublication->title) }}</span>
                                <div class="d-flex gap-2">
                                    <button class="edit--text btn-edit text--warning publicationBtn"
                                            data-action="{{ route('user.publication.store', $userPublication->id) }}"
                                            data-publication="{{ $userPublication }}" data-title="@lang('Edit Publication')">
                                        <i class="las la-pen"></i>
                                    </button>
                                    <button type="button"
                                            class="edit--text btn-edit text--danger customConfirmationBtn"
                                            data-action="{{ route('user.publication.delete', $userPublication->id) }}"
                                            data-question="@lang('Are you sure to delete this publication?')">
                                        <i class="las la-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="item">
                                    <p class="emp-info">
                                        {{ showDateTime($userPublication->published_date, 'd M, Y') }}
                                    </p>
                                </div>
                                <div class="item">
                                    <p class="emp-info">
                                        <a href="{{ $userPublication->url }}" target="_blank">
                                            {{ $userPublication->url }}
                                        </a>
                                    </p>
                                </div>
                                <div class="item">
                                    <p class="emp-info">{{ __($userPublication->publication_details) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="accomplishment-item__text">
                    @lang('Add links to your online publications.')
                </p>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.publication_modal')
