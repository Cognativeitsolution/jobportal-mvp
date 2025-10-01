<div class="row gy-3 justify-content-center">
    @if ($employers->count())
        @foreach ($employers as $employer)
            <div class="col-xl-6 wow fadeInUp" data-wow-duration="2s">
                <div class="sponsor-item item-two">
                    <a href="{{ route('company.profile', $employer->slug) }}" class="sponsor-item__thumb skeleton">
                        <img src="{{ getImage(getFilePath('employer') . '/' . @$employer->image, getFileSize('employer')) }}"
                             alt="employer-image">
                    </a>
                    <div class="sponsor-item__content">
                        <h6 class="sponsor-item__title skeleton">
                            <a href="{{ route('company.profile', $employer->slug) }}">
                                {{ __($employer->company_name) }}
                            </a>
                        </h6>
                        <span class="sponsor-item__location skeleton">
                            <span class="icon"><i class="las la-map-marker"></i></span>
                            {{ __(@$employer->city) }}, {{ __(@$employer->country_name) }}
                        </span>
                        @if (@$employer->industry)
                            <ul class="tag-list skeleton">
                                <li class="tag-list__item">
                                    <span class="tag-list__link">{{ __(@$employer->industry->name) }}</span>
                                </li>
                            </ul>
                        @endif
                        <a href="{{ route('company.profile', $employer->slug) }}" class="sponsor-item__icon skeleton">
                            <i class="las la-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @include('Template::partials.empty', ['message' => 'No jobs found'])
    @endif
</div>
@if ($employers->hasPages())
    <div class="row align-items-center mt-4">
        {{ paginateLinks($employers) }}
    </div>
@endif
