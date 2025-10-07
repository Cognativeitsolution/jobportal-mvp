<form action="{{ route('employer.job.basic', @$job->id) }}" method="POST" class="disableSubmission">
    @csrf
    <div class="card-item">
        <div class="card-item__header">
            <h6 class="card-item__title">@lang('Basic Information')
            </h6>
        </div>
        <div class="card-item__inner">
            <div class="row align-items-end">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form--label required">@lang('Job Title')</label>
                        <input class="form--control" name="title" type="text"
                               value="{{ old('title', @$job->title) }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label required">@lang('Category')</label>
                        <select class="form--control select2" name="category_id" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', @$job->category_id) == $category->id)>
                                    {{ __($category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Role')</label>
                        <select class="form--control select2" name="role_id" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                            @foreach ($roles ?? [] as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id', @$job->role_id) == $role->id)>
                                    {{ __($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label required">@lang('Job Type')</label>
                        <select class="form--control select2" name="type_id"
                                data-minimum-results-for-search="-1" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected(old('type_id', @$job->type_id) == $type->id)>
                                    {{ __($type->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label required">@lang('Job Location Type')</label>
                        <select class="form--control select2" name="job_location_type"
                                data-minimum-results-for-search="-1" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                            <option value="{{ Status::ONSITE }}" @selected(old('job_location_type', @$job->job_location_type) == Status::ONSITE)>
                                @lang('On-site')
                            </option>
                            <option value="{{ Status::REMOTE }}" @selected(old('job_location_type', @$job->job_location_type) == Status::REMOTE)>
                                @lang('Remote')
                            </option>
                            <option value="{{ Status::FIELD }}" @selected(old('job_location_type', @$job->job_location_type) == Status::FIELD)>
                                @lang('Field')
                            </option>
                            <option value="{{ Status::HYBRID }}" @selected(old('job_location_type', @$job->job_location_type) == Status::HYBRID)>
                                @lang('Hybrid')
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label required">@lang('City')</label>
                        <select class="form--control select2" name="city_id" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                            @foreach ($cities as $city)
                                <option data-locations='@json($city->address)'
                                        value="{{ $city->id }}" @selected(old('city_id', @$job->city_id) == $city->id)>
                                    {{ __($city->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label required">@lang('Location')</label>
                        <select class="form--control select2" id="location" name="location_id" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="company-profile-wrapper__btn justify-content-end">
        <button class="btn btn--base btn--lg" type="submit">
            @lang('Next') <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</form>
