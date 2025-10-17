<form action="{{ route('employer.job.information', $job->id) }}" method="POST" class="disableSubmission">
    @csrf
    <div class="card-item">
        <div class="card-item__header">
            <h6 class="card-item__title">
                @lang('Job Information')
            </h6>
        </div>
        <div class="card-item__inner">
            <div class="row align-items-end">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Experience')</label>
                        <select class="form--control select2" name="job_experience_id"
                                data-minimum-results-for-search="-1" required>
                            <option value="" disabled selected>@lang('Select One')</option>
                            @foreach ($experiences as $experience)
                                <option value="{{ $experience->id }}" @selected(old('job_experience_id', @$job->job_experience_id) == $experience->id)>
                                    {{ __($experience->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Gender')</label>
                        <select class="form--control select2" name="gender"
                                data-minimum-results-for-search="-1" required>
                            <option value="0" selected>@lang('Select One')</option>
                            <option value="{{ Status::ANY_GENDER }}" @selected(old('gender', @$job->gender) == Status::ANY_GENDER)>
                                @lang('Any')
                            </option>
                            <option value="{{ Status::MALE }}" @selected(old('gender', @$job->gender) == Status::MALE)>
                                @lang('Male')
                            </option>
                            <option value="{{ Status::FEMALE }}" @selected(old('gender', @$job->gender) == Status::FEMALE)>
                                @lang('Female')
                            </option>
                            <option value="{{ Status::OTHERS }}" @selected(old('gender', @$job->gender) == Status::OTHERS)>
                                @lang('Others')
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Deadline')</label>
                        <input class="form--control" name="deadline" type="text"
                               value="{{ old('deadline') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label required">@lang('Shift')</label>
                        <select class="form--control select2" name="shift_id"
                                data-minimum-results-for-search="-1">
                            <option selected disabled>@lang('Select One')</option>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}" @selected(old('shift_id', @$job->shift_id) == $shift->id)>
                                    {{ __($shift->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label ">@lang('Vacancy')</label>
                        <input class="form--control" name="vacancy" type="number"
                               value="{{ old('vacancy', @$job->vacancy) }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label ">@lang('Salary Period')</label>
                        <select class="form--control select2" name="salary_period"
                                data-minimum-results-for-search="-1">
                            <option selected disabled>@lang('Select One')</option>
                            @foreach ($salaryPeriods as $salaryPeriod)
                                <option value="{{ $salaryPeriod->id }}" @selected(old('salary_period', @$job->salary_period) == $salaryPeriod->id)>
                                    {{ __($salaryPeriod->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Minimum Age')</label>
                        <div class="input-group">
                            <input class="form--control form-control" name="min_age" type="number"
                                   value="{{ old('min_age', @$job->min_age) }}">
                            <span class="input-group-text">@lang('Year')</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Maximum Age')</label>
                        <div class="input-group">
                            <input class="form--control form-control" name="max_age" type="number"
                                   value="{{ old('max_age', @$job->max_age) }}">
                            <span class="input-group-text">@lang('Year')</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 salaryTypeParent">
                    <div class="form-group">
                        <label class="form--label ">@lang('Salary Type')</label>

                        <select class="form--control select2" id="salary_type" name="salary_type"
                            data-minimum-results-for-search="-1" >
                            <option value="{{ Status::NEGOTIATION }}" @selected(old('salary_type', @$job->salary_type) == Status::NEGOTIATION)>
                                @lang('Negotiable')
                            </option>
                            <option value="{{ Status::RANGE }}" @selected(old('salary_type', @$job->salary_type) == Status::RANGE)>
                                @lang('Range')
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 salaryFrom d-none">
                    <div class="form-group">
                        <label class="form--label">@lang('Minimum')</label>
                        <div class="input-group">
                            <input class="form-control form--control" name="salary_from" type="number"
                                   value="{{ old('salary_from', getAmount(@$job->salary_from)) }}"
                                   step="any">
                            <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 salaryTo d-none">
                    <div class="form-group">
                        <label class="form--label">@lang('Maximum')</label>
                        <div class="input-group">
                            <input class="form-control form--control" name="salary_to" type="number"
                                   value="{{ old('salary_to', getAmount(@$job->salary_to)) }}"
                                   step="any">
                            <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 tokenize">
                    <div class="form-group">
                        <label class="form--label required">@lang('Skills')</label>
                        <select class="form--control select2-auto-tokenize" name="skills[]" multiple="multiple" required>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->name }}" @selected(in_array($skill->name, old('skills', @$job->skills ?? [])))>
                                    {{ __($skill->name) }}
                                </option>
                            @endforeach
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
