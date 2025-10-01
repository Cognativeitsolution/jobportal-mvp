@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Email Verification')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text"
                                            name="resume_percentage[email_verification]"
                                            value="{{ gs('resume_percentage')['email_verification'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Mobile Verification')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text"
                                            name="resume_percentage[mobile_verification]"
                                            value="{{ gs('resume_percentage')['mobile_verification'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Preferred Location')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text"
                                            name="resume_percentage[preferred_location]"
                                            value="{{ gs('resume_percentage')['preferred_location'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Resume')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[resume]"
                                            value="{{ gs('resume_percentage')['resume'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Company & Job Title')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text"
                                            name="resume_percentage[company_job_title]"
                                            value="{{ gs('resume_percentage')['company_job_title'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Department')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[department]"
                                            value="{{ gs('resume_percentage')['department'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Industry Type')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[industry_type]"
                                            value="{{ gs('resume_percentage')['industry_type'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Photo Upload')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[photo_upload]"
                                            value="{{ gs('resume_percentage')['photo_upload'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Education')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[education]"
                                            value="{{ gs('resume_percentage')['education'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Language')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[language]"
                                            value="{{ gs('resume_percentage')['language'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Summary')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[summary]"
                                            value="{{ gs('resume_percentage')['summary'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Resume Headline')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text"
                                            name="resume_percentage[resume_headline]"
                                            value="{{ gs('resume_percentage')['resume_headline'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('personal Details')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text"
                                            name="resume_percentage[personal_detail]"
                                            value="{{ gs('resume_percentage')['personal_detail'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Skill')</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="resume_percentage[skill]"
                                            value="{{ gs('resume_percentage')['skill'] }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
