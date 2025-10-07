<div class="career-profile">
    <h6 class="name wow fadeInUp" data-wow-duration="2s">
        @lang('Present Address')
        <button class="edit-text presentAddressBtn">
            <i class="las la-pen"></i>
        </button>
    </h6>
    <p class="career-profile__text wow fadeInUp" data-wow-duration="2s">
        @lang('This information is important for employers to know you better.')
    </p>
    <div class="career-profile__wrapper">
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('Address')</p>
            @if (@$user->address)
                <span class="profile-list-item__data">{{ __($user->address) }}</span>
            @else
                <button class="profile-list-item__link presentAddressBtn">
                    @lang('Add address')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('State')</p>
            @if (@$user->state)
                <span class="profile-list-item__data">{{ __($user->state) }}</span>
            @else
                <button class="profile-list-item__link presentAddressBtn">
                    @lang('Add State')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('City')</p>
            @if (@$user->city)
                <span class="profile-list-item__data">{{ __($user->city) }}</span>
            @else
                <button class="profile-list-item__link presentAddressBtn">
                    @lang('Add city')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('Zip Code')</p>
            @if (@$user->zip)
                <span class="profile-list-item__data">{{ __($user->zip) }}</span>
            @else
                <button class="profile-list-item__link presentAddressBtn">
                    @lang('Add zip')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('Country')</p>
            @if (@$user->country_name)
                <span class="profile-list-item__data">{{ __($user->country_name) }}</span>
            @else
                <button class="profile-list-item__link presentAddressBtn">
                    @lang('Add country')
                </button>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.present_address_modal')
