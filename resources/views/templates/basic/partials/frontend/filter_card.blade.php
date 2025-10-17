<div class="filter-sidebar">
    <span class="sidebar-filter__close d-lg-none d-block"><i class="las la-times"></i></span>
    <div class="sidebar-header wow fadeInUp" data-wow-duration="2s">
        <h6 class="sidebar-header__filter">
            @lang('All Filters')
        </h6>
        <span class="sidebar-header__text">
            @lang('Applied')
            (<span class="filterCount">0</span>)
        </span>
    </div>
    <div class="accordion sidebar--acordion">
        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#search1"
                        aria-expanded="true">
                        @lang('Search')
                    </button>
                </h2>
                <div id="search1" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <ul class="filter-block__list">
                            <li class="filter-block__item">
                                <div class="filter-block__select">
                                    <div class="search-box">
                                        <input type="text" class="form--control" name="search"
                                            value="{{ $search ?? '' }}" placeholder="@lang('Search by job title')">
                                        <button type="submit" class="search-box__button">
                                            <i class="las la-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                        aria-expanded="true">
                        @lang('Location')
                    </button>
                </h2>
                <div id="location" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="filter-block__select">
                            <select class="form--control select2" name="city">
                                <option value="" selected>@lang('All')</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(request()->city_id == $city->id || @$requestData['city_id'] == $city->id)>
                                        {{ __($city->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($categories->count())
            <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#department" aria-expanded="true">
                            @lang('Category')
                        </button>
                    </h2>
                    <div id="department" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <ul class="filter-block__list">
                                <li class="filter-block__item">
                                    <div class="form--check">
                                        <input class="form-check-input" @checked(!@$requestData['category_id']) value=""
                                            type="checkbox" id="category_all">
                                        <label class="form-check-label" for="category_all">
                                            <span class="label-text">@lang('All')</span>
                                        </label>
                                    </div>
                                </li>
                                @foreach ($categories as $category)
                                    <li class="filter-block__item">
                                        <div class="form--check">
                                            <input class="form-check-input" name="category_id[]"
                                                value="{{ $category->id }}" type="checkbox"
                                                id="category{{ $category->id }}" @checked(@$requestData['category_id'] == $category->id)>
                                            <label class="form-check-label" for="category{{ $category->id }}">
                                                <span class="label-text">{{ __($category->name) }}</span>
                                                <span class="label-text">({{ $category->job_count }})</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <span class="load-more-button">@lang('Load More') </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($roles->count())
            <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#role"
                            aria-expanded="true">
                            @lang('Role')
                        </button>
                    </h2>
                    <div id="role" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <ul class="filter-block__list">
                                <li class="filter-block__item">
                                    <div class="form--check">
                                        <input class="form-check-input" @checked(!@$requestData['role_id']) value=""
                                            type="checkbox" id="role_all">
                                        <label class="form-check-label" for="role_all">
                                            <span class="label-text">@lang('All')</span>
                                        </label>
                                    </div>
                                </li>
                                @foreach ($roles as $role)
                                    <li class="filter-block__item">
                                        <div class="form--check">
                                            <input class="form-check-input" name="role_id[]"
                                                value="{{ $role->id }}" type="checkbox"
                                                id="role_{{ $role->id }}" @checked(@$requestData['role_id'] == $role->id)>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                <span class="label-text">{{ __($role->name) }}</span>
                                                <span class="label-text">({{ $role->jobs_count }})</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <span class="load-more-button">@lang('Load More')</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#Level" aria-expanded="true">
                        @lang('Work Mode')
                    </button>
                </h2>
                <div id="Level" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <ul class="filter-block__list">
                            <li class="filter-block__item">
                                <div class="form--check">
                                    <input class="form-check-input" type="checkbox" value="" checked
                                        id="all_job_location_type">
                                    <label class="form-check-label" for="all_job_location_type">
                                        <span class="label-text">@lang('All')</span>
                                    </label>
                                </div>
                            </li>
                            <li class="filter-block__item">
                                <div class="form--check">
                                    <input class="form-check-input" name="job_location_type[]" type="checkbox"
                                        value="{{ Status::ONSITE }}" id="on_site">
                                    <label class="form-check-label" for="on_site">
                                        <span class="label-text">@lang('On-site')</span>
                                    </label>
                                </div>
                            </li>
                            <li class="filter-block__item">
                                <div class="form--check">
                                    <input class="form-check-input" name="job_location_type[]" type="checkbox"
                                        value="{{ Status::REMOTE }}" id="remote">
                                    <label class="form-check-label" for="remote">
                                        <span class="label-text">@lang('Hybrid')</span>
                                    </label>
                                </div>
                            </li>
                            <li class="filter-block__item">
                                <div class="form--check">
                                    <input class="form-check-input" name="job_location_type[]" type="checkbox"
                                        value="{{ Status::HYBRID }}" id="hybrid">
                                    <label class="form-check-label" for="hybrid">
                                        <span class="label-text">@lang('Remote')</span>
                                    </label>
                                </div>
                            </li>
                            <li class="filter-block__item">
                                <div class="form--check">
                                    <input class="form-check-input" name="job_location_type[]" type="checkbox"
                                        value="{{ Status::FIELD }}" id="field">
                                    <label class="form-check-label" for="field">
                                        <span class="label-text">@lang('Field')</span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if ($minAge && $maxAge)
            <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#topic" aria-expanded="true">
                            @lang('Age Range')
                        </button>
                    </h2>
                    <div id="topic" class="accordion-collapse show collapse">
                        <div class="accordion-body">
                            <div class=" custom--range">
                                <div id="slider-range" class="custom--range__range"></div>
                                <div class="custom--range__content d-flex flex-wrap justify-content-betwwen">
                                    <input type="text" class="custom--range__prices" id="range_amount"
                                        name="age_range">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($jobTypes->count())
            <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#job_type" aria-expanded="true">
                            @lang('Job Type')
                        </button>
                    </h2>
                    <div id="job_type" class="accordion-collapse show collapse">
                        <div class="accordion-body">
                            <ul class="filter-block__list">
                                <li class="filter-block__item">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="all_job_type" @checked(!@$requestData['type_id'])>
                                        <label class="form-check-label" for="all_job_type">
                                            <span class="label-text">@lang('All')</span>
                                        </label>
                                    </div>
                                </li>
                                @foreach ($jobTypes as $type)
                                    <li class="filter-block__item">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="type_id[]"
                                                value="{{ $type->id }}" id="type_{{ $type->id }}"
                                                @checked(@$requestData['type_id'] == $type->id)>
                                            <label class="form-check-label" for="type_{{ $type->id }}">
                                                <span class="label-text">{{ __($type->name) }}</span>
                                                <span class="label-text">({{ $type->job_count }})</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                                <li class="load-more-button">@lang('Load more')</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($jobExperiences->count())
            <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#experience" aria-expanded="true">
                            @lang('Experience')
                        </button>
                    </h2>
                    <div id="experience" class="accordion-collapse show collapse">
                        <div class="accordion-body">
                            <ul class="filter-block__list">
                                <li class="filter-block__item">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="all_job_experience" checked>
                                        <label class="form-check-label" for="all_job_experience">
                                            <span class="label-text">@lang('All')</span>
                                        </label>
                                    </div>
                                </li>
                                @foreach ($jobExperiences as $jobExperience)
                                    <li class="filter-block__item">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox"
                                                name="job_experience_id[]" value="{{ $jobExperience->id }}"
                                                id="job_experience_{{ $jobExperience->id }}">
                                            <label class="form-check-label"
                                                for="job_experience_{{ $jobExperience->id }}">
                                                <span class="label-text">{{ __($jobExperience->name) }}</span>
                                                <span class="label-text">({{ $jobExperience->job_count }})</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                                <li class="load-more-button">@lang('Load more')</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($jobShifts->count())
            <div class="filter-block wow fadeInUp" data-wow-duration="2s">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#shift" aria-expanded="true">
                            @lang('Shift')
                        </button>
                    </h2>
                    <div id="shift" class="accordion-collapse show collapse">
                        <div class="accordion-body">
                            <ul class="filter-block__list">
                                <li class="filter-block__item">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="all_shift" checked>
                                        <label class="form-check-label" for="all_shift">
                                            <span class="label-text">@lang('All')</span>
                                        </label>
                                    </div>
                                </li>
                                @foreach ($jobShifts as $jobShift)
                                    <li class="filter-block__item">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="shift_id[]"
                                                value="{{ $jobShift->id }}" id="shift_{{ $jobShift->id }}">
                                            <label class="form-check-label" for="shift_{{ $jobShift->id }}">
                                                <span class="label-text">{{ __($jobShift->name) }}</span>
                                                <span class="label-text">({{ $jobShift->job_count }})</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                                <li class="load-more-button">@lang('Load more')</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="filter-block wow fadeInUp" data-wow-duration="2s">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#keywords" aria-expanded="true">
                        @lang('Keywords')
                    </button>
                </h2>
                <div id="keywords" class="accordion-collapse show collapse">
                    <div class="accordion-body">
                        <ul class="filter-block__list">
                            <li class="filter-block__item">
                                <span
                                    class="feature-item__time allKeywordFilterBtn {{ !@$requestData['keyword'] ? 'active' : '' }}">
                                    @lang('All')
                                </span>
                            </li>

                            @if (!empty(@$requestData['keyword']))
                                <li class="filter-block__item">
                                    <span class="feature-item__time keywordFilterBtn active">
                                        {{ __(@$requestData['keyword']) }}
                                    </span>
                                </li>
                            @endif

                            @foreach ($keywords as $keyword)
                                <li class="filter-block__item">
                                    <span
                                        class="feature-item__time keywordFilterBtn {{ strtolower(@$requestData['keyword']) == strtolower($keyword->keyword) ? 'd-none' : '' }}">
                                        {{ __($keyword->keyword) }}
                                    </span>
                                </li>
                            @endforeach
                            <li class="load-more-button load-two">@lang('Load more')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('style')
    <style>
        .filter-block__list {
            max-height: 393px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .load-more-button {
            margin-top: 10px;
            text-align: left;
            font-size: 1rem;
            justify-content: start;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        /* Scrollbar for the list */
        .filter-block__list::-webkit-scrollbar {
            width: 5px;
            height: 8px;
        }

        .filter-block__list::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 4px;
        }

        .filter-block__list::-webkit-scrollbar-thumb {
            background-color: #88888854;
            border-radius: 4px;
        }

        .filter-block__list::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .filter-block__list::-webkit-scrollbar-corner {
            background-color: #f1f1f1;
        }
    </style>
@endpush
