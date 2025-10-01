<div class="sponsor-item-slider featuredCompaniesSlider wow fadeInUp" data-wow-duration="2s">
    @foreach ($featuredCompanies as $company)
        <div class="sponsor-card">
            <div class="sponsor-item">
                <a href="{{ route('company.profile', $company->slug) }}" class="sponsor-item__thumb skeleton">
                    <img src="{{ getImage(getFilePath('employer') . '/' . $company->image, getFileSize('employer')) }}"
                        alt="employer-image">
                </a>
                <div class="sponsor-item__content">
                    <h6 class="sponsor-item__title skeleton">
                        <a href="{{ route('company.profile', $company->slug) }}">{{ __($company->company_name) }}</a>
                    </h6>
                    <p class="sponsor-item__location skeleton">
                        <span class="icon"><i class="las la-map-marker"></i></span>
                        {{ __($company->city) }}, {{ __($company->country_name) }}
                    </p>
                    <p class="sponsor-item__desc skeleton">{{ strLimit(__(strip_tags($company->description)), 80) }}</p>
                    <a href="{{ route('company.jobs', $company->slug) }}"
                        class="btn sponsor-item__btn skeleton less-border">
                        @lang('View Jobs')
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
