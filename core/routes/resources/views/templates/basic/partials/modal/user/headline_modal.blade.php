<div class="modal fade custom--modal fade-in-scale" id="headlineModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Headline')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.resume.headline.update') }}" method="POST"
                  class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->headline_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->headline_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <label class="form--label">@lang('Headline')</label>
                                <input type="text" name="resume_headline" value="{{ $user->resume_headline }}"
                                       class="form--control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
