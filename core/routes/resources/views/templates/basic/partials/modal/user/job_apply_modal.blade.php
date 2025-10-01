@if (auth()->check())
    @php
        $user = auth()->user();
        $eligibility = true;
        if ($job->gender && $user->gender != $job->gender) {
            $eligibility = false;
        }

        $birthDate = $user->birth_date;
        $userAge = (int) Carbon\Carbon::parse($user->birth_date)->diffInYears(now());
        if ($job->min_age > 0 && $job->min_age > $userAge) {
            $eligibility = false;
        }

        if ($job->max_age > 0 && $job->max_age < $userAge) {
            $eligibility = false;
        }
    @endphp
    <div class="modal fade custom--modal fade-in-scale" id="applyModal">
        <div class="modal-dialog">
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
                                    <label class="form--label">@lang('Expected Salary')</label>
                                    <div class="input-group">
                                        <input type="text" class="form--control form-control" name="expected_salary" value="{{ old('expected_salary') }}" required>
                                        <span class="input-group-text">{{ gs('cur_text') }}</span>
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
            (function($) {
                'use strict';

                $('.applyBtn').on('click', function() {
                    $('#applyModal').modal('show');
                })
            })(jQuery)
        </script>
    @endpush
@endif
