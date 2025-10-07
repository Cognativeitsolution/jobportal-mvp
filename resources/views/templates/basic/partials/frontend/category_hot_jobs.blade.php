@foreach ($jobs as $job)
    <div class="col-xl-3 col-sm-6 item-one wow fadeInUp" data-wow-duration="2s">
        <div class="feature-item item-two">
            <div class="d-flex justify-content-between  align-items-start gap-2">
                <a href="{{ route('company.profile', @$job->employer->slug) }}" class="feature-item__thumb skeleton">
                    <img src="{{ getImage(getFilePath('employer') . '/' . @$job->employer->image, getFileSize('employer')) }}"
                         alt="employer-image">
                </a>
                <span class="feature-item__time skeleton less-border">
                    {{ __(@$job->type->name) }}
                </span>
            </div>
            <div class="feature-item__content">
                <a href="{{ route('company.profile', @$job->employer->slug) }}" class="feature-item__name skeleton">
                    {{ __(@$job->employer->company_name) }}
                </a>
                <h6 class="feature-item__title skeleton">
                    <a href="{{ route('job.details', $job->id) }}">
                        {{ __($job->title) }}
                    </a>
                </h6>
                <span class="sponsor-item__location skeleton">
                    <span class="icon"><i class="las la-map-marker"></i></span>
                    {{ __(@$job->location->name) }}, {{ __(@$job->city->name) }}
                </span>
                <p class="feature-item__desc skeleton">
                    {{ strLimit(__($job->short_description), 50) }}
                </p>
                <div class="feature-item__bottom">
                    <ul class="text-list">
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon">
                                <i class="las la-briefcase"></i>
                            </span>
                            {{ $job->jobLocationName() }}
                        </li>
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon">
                                <i class="las la-money-bill"></i>
                            </span>
                            {{ $job->salary_amount }}
                        </li>
                    </ul>
                    <button data-action="{{ route('user.favorite.item', $job->id) }}" type="button"
                            class="card-icon favoriteBtn skeleton less-border">
                        @if ($job->favoriteItems->count())
                            <i class="fas fa-bookmark"></i>
                        @else
                            <i class="far fa-bookmark"></i>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@if ($jobs->count() >= 8)
    <a href="{{ route('job.category', @$id) }}" class="load-more-button wow fadeInUp" data-wow-duration="2s">
        @lang('Show All Jobs')
        <span class="load-more-button__icon"><i class="las la-arrow-right"></i></span>
    </a>
@endif
