<div class="main-body__top">
    <div id="scrollspyHeading1">
        <h5 class="title wow fadeInUp" data-wow-duration="2s">
            @lang('Resume')
            @if (@$user->profile_update_percent_list['resume'])
                <span class="rate">
                    @lang('Add')
                    {{ $user->profile_update_percent_list['resume'] }}%
                </span>
            @endif
        </h5>
        @if (@$user->profile_update_percent_list['resume'])
            <p class="text  wow fadeInUp" data-wow-duration="2s">
                @lang('A significant number of recruiters identify potential candidates through their resumes.')
            </p>
        @else
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('user.resume.download') }}" class="btn btn-outline--base btn--sm">
                    <i class="fa-solid fa-download"></i> @lang('Download')
                </a>
                <button type="button" class="btn btn-outline--danger btn--sm  customConfirmationBtn"
                        data-action="{{ route('user.resume.delete') }}" data-question="@lang('Are you sure to delete this resume?')">
                    <i class="fa-regular fa-trash-can"></i> @lang('Delete')
                </button>
            </div>
        @endif
        <form action="{{ route('user.resume.update') }}" method="POST"
              class="resume-form disableSubmission wow fadeInUp" enctype="multipart/form-data" data-wow-duration="2s">
            @csrf
            <label class="resume-form__label">
                <input type="file" class="resume-form__file" name="resume" accept=".doc, .docs, .rtf, pdf">
                <span class="title gap-1">
                    @lang('Already have a resume?')
                    <span class="text--base">@lang('Upload resume')</span>
                </span>
                <span class="resume-form__text">
                    @lang('Supported Formats: doc, docx, rtf, pdf, upto 2 MB')
                </span>
            </label>
        </form>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            'use strict';
            $('[name="resume"]').on('change', function() {
                $('.resume-form').submit();
            });
        })(jQuery)
    </script>
@endpush
