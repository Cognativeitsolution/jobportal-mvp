@if ($jobs)

    @foreach ($jobs ?? [] as $job)
        <div class="col-lg-6  wow fadeInRight" data-wow-duration="2s">
            <div class="feature-item">
                <a href="{{ route('company.profile', @$job->employer->slug) }}"
                    class="feature-item__thumb skeleton less-border">
                    <img src="{{ getImage(getFilePath('employer') . '/' . @$job->employer->image, getFileSize('employer')) }}"
                        alt="image">
                </a>
                <div class="feature-item__content ">
                    <div class="d-flex flex-wrap justify-content-between gap-2 align-items-start">
                        <div>
                            <h5 class="feature-item__title skeleton">
                                <a href="{{ route('job.details', $job->id) }}">
                                    {{ strLimit(__($job->title), 35) }}
                                </a>
                            </h5>
                            <a href="{{ route('company.profile', $job->employer->slug) }}"
                                class="feature-item__name skeleton">
                                {{ __(@$job->employer->company_name) }}
                            </a>
                        </div>
                        <div class="feature-item__time skeleton less-border">{{ diffForHumans($job->created_at) }}</div>
                    </div>
                    <ul class="text-list ">
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-map-marker"></i></span>
                            {{ __(@$job->location->name) }}, {{ __(@$job->city->name) }}
                        </li>
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-briefcase"></i></span>
                            {{ $job->jobLocationName() }}
                        </li>
                        <li class="text-list__item skeleton">
                            <span class="text-list__icon"><i class="las la-money-bill"></i></span>
                            {{ $job->salary_amount }}
                        </li>
                    </ul>
                    <div class="feature-item__bottom d-flex flex-wrap justify-content-between gap-2 ">
                        <div class="job-category skeleton">
                            <span class="badge badge--success">
                                {{ __(@$job->type->name) }}
                            </span>
                            <span class="badge badge--danger">
                                @lang('Deadline'): {{ showDateTime($job->deadline, 'd M, Y') }}
                            </span>
                        </div>
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
@endif
