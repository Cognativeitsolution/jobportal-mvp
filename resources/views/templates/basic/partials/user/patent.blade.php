<div class="accomplishment-card">
    <div class="accomplishment-item m-0 wow fadeInUp" data-wow-duration="2s">
        <div class="accomplishment-item__top">
            <h6 class="title">
                @lang('Patent')
            </h6>
            <button class="text--base patentBtn" data-patent="" data-action="{{ route('user.patent.store') }}" data-title="@lang('Add Patent')">
                @lang('Add')
            </button>
        </div>
        @if (@$user->userPatents->count() > 0)
            <div>
                @foreach ($user->userPatents as $userPatent)
                    <div class="row emp-list data-list">
                        <div class="title d-flex justify-content-between align-items-center mb-2">
                            <span class="info-title text--base">{{ __($userPatent->title) }}</span>
                            <div class="d-flex gap-2">
                                <button class="edit--text btn-edit text--warning patentBtn"
                                    data-action="{{ route('user.patent.store', $userPatent->id) }}"
                                    data-patent="{{ $userPatent }}" data-title="@lang('Edit Patent')">
                                    <i class="las la-pen"></i>
                                </button>
                                <button type="button" class="edit--text btn-edit text--danger customConfirmationBtn"
                                    data-action="{{ route('user.patent.delete', $userPatent->id) }}"
                                    data-question="@lang('Are you sure to delete this patent?')">
                                    <i class="las la-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            @if ($userPatent->status == Status::PATENT_ISSUED)
                                <div class="item">
                                    <p class="emp-info">
                                        {{ showDateTime($userPatent->issued_date, 'd M, Y') }}
                                    </p>
                                </div>
                            @endif
                            <div class="item">
                                <p class="emp-info">{{ __($userPatent->details) }}</p>
                            </div>
                            <div class="item">
                                <p class="emp-info">
                                    <a href="{{ $userPatent->url }}" target="_blank">
                                        {{ $userPatent->url }}
                                    </a>
                                </p>
                            </div>
                            <div class="item">
                                <p class="emp-info">
                                    @php echo $userPatent->statusBadge; @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="accomplishment-item__text">
                @lang('Add details of patents you have filed')
            </p>
        @endif
    </div>
</div>

@include('Template::partials.modal.user.patent_modal')
