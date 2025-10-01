@if ($job->jobKeywords->count())
    <div class="link-wrapper">
        <h6 class="link-wrapper__title wow fadeInUp" data-wow-duration="2">
            @lang('Keywords')
        </h6>
        <ul class="filter-block__list">
            @foreach ($job->jobKeywords ?? [] as $keyword)
                <li class="filter-block__item">
                    <a href="{{ route('job.keyword', $keyword->keyword) }}" class="feature-item__time">
                        {{ __($keyword->keyword) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    @push('style')
        <style>
            .filter-block__list {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
        </style>
    @endpush
@endif
