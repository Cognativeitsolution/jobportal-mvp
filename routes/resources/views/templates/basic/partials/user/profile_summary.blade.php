<div class="main-body__top">
    <div id="scrollspyHeading8">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">
                    @lang('Profile Summary')
                    <span class="rate">
                        @if (@$user->profile_update_percent_list['summary'])
                            @lang('Add')
                            {{ $user->profile_update_percent_list['summary'] }}%
                        @else
                            <button class="edit--text btn-edit text--warning" data-bs-toggle="modal"
                                data-bs-target="#summaryModal">
                                <i class="las la-pen"></i>
                            </button>
                        @endif
                    </span>
                </h6>
                @if (@$user->profile_update_percent_list['summary'])
                    <button class="text--base" data-bs-toggle="modal"
                        data-bs-target="#summaryModal">@lang('Add Profile Summary')</button>
                @endif
            </div>
            <p class="profile-dashboard-item__text">
                @if (@$user->summary)
                    @php echo nl2br(__($user->summary)); @endphp
                @else
                    @lang('Highlight your key career achievements to help employers know your potential.')
                @endif
            </p>
            @include('Template::partials.modal.user.summary_modal')
        </div>
    </div>
</div>
