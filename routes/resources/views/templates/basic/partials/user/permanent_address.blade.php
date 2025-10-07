@php
    $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
@endphp
<div class="career-profile">
    <h6 class="name wow fadeInUp" data-wow-duration="2s">
        @lang('Permanent Address')
        <button class="edit-text permanentAddressBtn">
            <i class="las la-pen"></i>
        </button>
    </h6>
    <p class="career-profile__text wow fadeInUp" data-wow-duration="2s">
        @lang('This information is important for employers to know you better.')
    </p>
    <div class="career-profile__wrapper">
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('Address')</p>
            @if (@$user->permanent_address['address'])
                <span class="profile-list-item__data">{{ __($user->permanent_address['address']) }}</span>
            @else
                <button class="profile-list-item__link permanentAddressBtn">
                    @lang('Add address')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('State')</p>
            @if (@$user->permanent_address['state'])
                <span class="profile-list-item__data">{{ __($user->permanent_address['state']) }}</span>
            @else
                <button class="profile-list-item__link permanentAddressBtn">
                    @lang('Add state')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('City')</p>
            @if (@$user->permanent_address['city'])
                <span class="profile-list-item__data">{{ __($user->permanent_address['city']) }}</span>
            @else
                <button class="profile-list-item__link permanentAddressBtn">
                    @lang('Add city')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('Zip')</p>
            @if (@$user->permanent_address['zip'])
                <span class="profile-list-item__data">{{ __($user->permanent_address['zip']) }}</span>
            @else
                <button class="profile-list-item__link permanentAddressBtn">
                    @lang('Add zip code')
                </button>
            @endif
        </div>
        <div class="profile-list-item wow fadeInUp" data-wow-duration="2s">
            <p class="profile-list-item__title">@lang('Country')</p>
            @if (@$user->permanent_address['country'])
                <span class="profile-list-item__data">{{ __($user->permanent_address['country']) }}</span>
            @else
                <button class="profile-list-item__link permanentAddressBtn">
                    @lang('Add country')
                </button>
            @endif
        </div>
    </div>
</div>

@include('Template::partials.modal.user.permanent_address_modal')
