<div class="filter-body__content">
    @if ($jobs->count())
        @foreach ($jobs as $job)
            <div class="feature-item  wow fadeInUp" data-wow-duration="2s">
                <a href="{{ route('company.profile', $job->employer->slug) }}" class="feature-item__thumb skeleton">
                    <img src="{{ getImage(getFilePath('employer') . '/' . $job->employer->image, getFileSize('employer')) }}" alt="image">
                </a>
                <div class="feature-item__content">
                    <div class="d-flex flex-wrap justify-content-between gap-2 align-items-start">
                        <div>
                            <h5 class="feature-item__title skeleton">
                                <a href="{{ route('job.details', $job->id) }}">
                                    {{ __($job->title) }}
                                </a>
                            </h5>
                            <a href="{{ route('company.profile', $job->employer->slug) }}"
                               class="feature-item__name skeleton">
                                {{ __($job->employer->company_name) }}
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="feature-item__time skeleton less-border">
                                {{ diffForHumans($job->created_at) }}
                            </span>
                            <button data-action="{{ route('user.favorite.item', $job->id) }}" type="button" class="card-icon favoriteBtn skeleton less-border">
                                @if ($job->favoriteItems->count())
                                    <i class="fas fa-bookmark"></i>
                                @else
                                    <i class="far fa-bookmark"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                    <p class="feature-item__desc skeleton">
                        {{ __(@$job->short_description) }}
                    </p>
                    <ul class="text-list">
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-map-marker"></i></span>
                            {{ __($job->location->name) }}, {{ __($job->city->name) }}
                        </li>
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-briefcase"></i></span>
                            @php echo $job->jobLocationName(); @endphp
                        </li>
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-money-bill"></i></span>
                            {{ $job->salary_amount }}
                        </li>
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-users"></i></span>
                            {{ $job->job_application_count ?? 0 }} @lang('Applicants')
                        </li>
                    </ul>
                    <div class="feature-item__bottom d-flex align-items-end justify-content-between gap-2">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge badge--success skeleton less-border">
                                {{ __($job->type->name) }}
                            </span>
                            <span class="badge badge--danger skeleton less-border">
                                {{ showDateTime($job->deadline, 'd M, Y') }}
                            </span>
                        </div>
                        <a href="{{ route('job.details', $job->id) }}"
                           class="btn btn-outline--base skeleton less-border">
                            @lang('Explore')
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @include('Template::partials.empty', ['message' => 'No jobs found'])
    @endif
</div>
@if ($jobs->hasPages())
    <div class="row align-items-center mt-4">
        {{ paginateLinks($jobs) }}
    </div>
@endif
