<div class="main-body__top">
    <div id="scrollspyHeading2">
        <div class="profile-dashboard-item m-0 wow fadeInUp" data-wow-duration="2s">
            <div class="profile-dashboard-item__top">
                <h6 class="title">
                    @lang('Headline')
                    <span class="rate">
                        @if (@$user->profile_update_percent_list['resume_headline'])
                            @lang('Add')
                            {{ $user->profile_update_percent_list['resume_headline'] }}%
                        @else
                            <button class="edit--text btn-edit text--warning" data-bs-toggle="modal"
                                    data-bs-target="#headlineModal">
                                <i class="las la-pen"></i>
                            </button>
                        @endif
                    </span>
                </h6>
                @if (@$user->profile_update_percent_list['resume_headline'])
                    <button class="text--base" data-bs-toggle="modal" data-bs-target="#headlineModal">
                        @lang('Add headline')
                    </button>
                @endif
            </div>
            <p class="profile-dashboard-item__text">
                @if (@$user->profile_update_percent_list['resume_headline'])
                    @lang('The headline is the first thing employers notice in your profile. Create a concise introduction that highlights your strengths.')
                @else
                    {{ __($user->resume_headline) }}
                @endif
            </p>
        </div>
    </div>
</div>
@include('Template::partials.modal.user.headline_modal')
