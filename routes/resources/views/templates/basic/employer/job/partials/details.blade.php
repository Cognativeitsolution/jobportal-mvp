<form action="{{ route('employer.job.details', $job->id) }}" method="POST" class="disableSubmission">
    @csrf
    <div class="card-item">
        <div class="card-item__header">
            <h6 class="card-item__title">@lang('Job Details')</h6>
        </div>
        <div class="card-item__inner">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form--label required">@lang('Short Description')</label>
                        <textarea class="form--control" name="short_description">{{ old('short_description', @$job->short_description) }}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form--label required">@lang('Description')</label>
                        <textarea class="form--control nicEdit" name="description" rows="8">{{ old('description', @$job->description) }}</textarea>
                    </div>
                </div>
                <div class="col-12 tokenize">
                    <div class="form-group">
                        <label class="form--label required">@lang('Keywords')</label>
                        <select class="form--control select2-auto-tokenize" name="keywords[]"
                                multiple="multiple" required>
                            @foreach (@$keywords ?? [] as $keyword)
                                <option data-keyword="{{ $keyword->keyword }}"
                                        value="{{ $keyword->keyword }}" @selected(in_array($keyword->keyword, old('keywords', @$selectedKeywords ?? [])))>
                                    {{ __($keyword->keyword) }}
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
            @lang('Finish') <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</form>
