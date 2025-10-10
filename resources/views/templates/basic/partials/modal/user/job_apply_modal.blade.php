@if (auth()->check())
    @php
        $user = auth()->user();
        $eligibility = true;
        // if ($job->gender && $user->gender != $job->gender) {
        //     $eligibility = false;
        // }

        // $birthDate = $user->birth_date;
        // $userAge = (int) Carbon\Carbon::parse($user->birth_date)->diffInYears(now());
        // if ($job->min_age > 0 && $job->min_age > $userAge) {
        //     $eligibility = false;
        // }

        // if ($job->max_age > 0 && $job->max_age < $userAge) {
        //     $eligibility = false;
        // }
    @endphp
    <div class="modal fade custom--modal fade-in-scale" id="applyModal">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __($job->title) }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($eligibility)
                        <div class="modal-form__title plan-confirm-text">
                            <h6 class="mb-2">
                                @lang('Please read this before applying')
                            </h6>
                            <span>
                                {{ gs('site_name') }} @lang('will not be responsible for any financial transactions or fraud by the company after applying through the website. We only connects companies and job seekers.')
                            </span>
                        </div>
                        <form action="{{ route('user.job.apply', request()->id) }}" method="POST" class="modal-form disableSubmission">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <div class="mb-2">
                                        <label class="form--label">@lang('Name')</label>
                                        <div class="input-group">
                                            <input type="text" class="form--control form-control" name="name"
                                                value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form--label">@lang('Email')</label>
                                        <div class="input-group">
                                            <input type="text" class="form--control form-control" name="email"
                                                value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form--label">@lang('Phone')</label>
                                        <div class="input-group">
                                            <input type="tel" class="form--control form-control" name="phone"
                                                value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form--label">@lang('Expected Salary')</label>
                                        <div class="input-group">
                                            <input type="text" class="form--control form-control" name="expected_salary"
                                                value="{{ old('expected_salary') }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-2 mt-3">
                                        <div class="input-group">
                                            <input type="radio" id="jobOrbitOption" name="resume_options" value="job_orbit"
                                                required checked>
                                            <label for="jobOrbitOption"
                                                class="form--label mb-0 ms-2">@lang('Job Orbit Resume')</label>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="input-group">
                                            <input type="radio" id="uploadOption" name="resume_options" value="upload" required>
                                            <label for="uploadOption"
                                                class="form--label mb-0 ms-2">@lang('Upload Resume')</label>
                                        </div>
                                    </div>

                                    <!-- By default hidden file upload field -->
                                    <div class="mb-2" id="uploadResumeField" style="display: none;">
                                        <label class="form--label">@lang('Upload Resume')</label>
                                        <div class="input-group">
                                            <input type="file" class="form--control form-control" id="resumeFile"
                                                name="resumeFile" value="{{ old('resumeFile') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn--base w-100">@lang('Apply Now')</button>
                            </div>
                        </form>
                    @else
                        <h6 class="text--danger">
                            <i class="las la-exclamation-circle"></i>
                            @lang('You are not eligible to apply')
                        </h6>
                        <div class="modal-form__title plan-confirm-text">
                            <h6 class="mb-2">
                                @lang('Hi'), {{ $user->fullname }}
                            </h6>
                            <span>
                                @lang('Thank you for your interest in the position. Unfortunately, you do not meet some of the mandatory requirements specified by the employer in the job application criteria. As a result, we are unable to proceed with your application at this time. We encourage you to review and update your CV to better align with the qualifications and requirements of future opportunities. Best of luck in your job search!')
                            </span>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            (function ($) {
                'use strict';

                $('.applyBtn').on('click', function () {
                    $('#applyModal').modal('show');
                })
            })(jQuery)
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const radioButtons = document.querySelectorAll('input[name="resume_options"]');
                const resumeFieldDiv = document.getElementById('uploadResumeField');
                const resumeInput = document.getElementById('resumeFile');

                radioButtons.forEach((radio) => {
                    radio.addEventListener('change', function () {
                        if (this.value === 'upload') {
                            resumeFieldDiv.style.display = 'block';
                            resumeInput.required = true;
                        } else {
                            resumeFieldDiv.style.display = 'none';
                            resumeInput.required = false;
                            resumeInput.value = ''; // Clear file input
                        }
                    });
                });

                // Initial state on page load
                const selected = document.querySelector('input[name="resume_options"]:checked');
                if (selected && selected.value === 'upload') {
                    resumeFieldDiv.style.display = 'block';
                    resumeInput.required = true;
                } else {
                    resumeFieldDiv.style.display = 'none';
                    resumeInput.required = false;
                }
            });
        </script>
    @endpush
@endif