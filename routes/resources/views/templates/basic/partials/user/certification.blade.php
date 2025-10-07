<div class="accomplishment-card">
    <div class="accomplishment-item m-0 wow fadeInUp" data-wow-duration="2s">
        <div class="accomplishment-item__top">
            <h6 class="title">@lang('Certification')</h6>
            <button class="text--base certificationBtn" data-certification=""
                data-action="{{ route('user.certification.store') }}" data-title="@lang('Add Certification')">
                @lang('Add')
            </button>
        </div>
        @if (@$user->userCertifications->count() > 0)
            <div>
                @foreach ($user->userCertifications as $userCertification)
                    <div class="row emp-list data-list">
                        <div class="title d-flex justify-content-between align-items-center mb-2">
                            <span class="info-title text--base">{{ __($userCertification->name) }}</span>
                            <div class="d-flex gap-2">
                                <button class="edit--text btn-edit text--warning certificationBtn"
                                    data-action="{{ route('user.certification.store', $userCertification->id) }}"
                                    data-certification="{{ $userCertification }}" data-title="@lang('Edit Certification')">
                                    <i class="las la-pen"></i>
                                </button>
                                <button type="button" class="edit--text btn-edit text--danger customConfirmationBtn"
                                    data-action="{{ route('user.certification.delete', $userCertification->id) }}"
                                    data-question="@lang('Are you sure to delete this certification?')">
                                    <i class="las la-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="item">
                                <p class="emp-info">
                                    {{ __($userCertification->institute) }}
                                </p>
                            </div>
                            <div class="item">
                                <p class="emp-info">
                                    {{ getAmount($userCertification->duration) }} @lang('Months')
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="accomplishment-item__text">
                @lang('Add details of certifications you have completed')
            </p>
        @endif
        @include('Template::partials.modal.user.certification_modal')
    </div>
</div>
