<div class="modal fade custom--modal fade-in-scale" id="onlineProfileModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Online Profile')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form disableSubmission">
                @csrf
                <div class="modal-body">
                    @if (@$profileSettingContent->data_values->online_profile_message)
                        <h6 class="modal-form__title plan-confirm-text">
                            <span>
                                {{ __(@$profileSettingContent->data_values->online_profile_message) }}
                            </span>
                        </h6>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Profile Name')</label>
                                <input type="text" class="form--control" name="social_media_name"
                                    value="{{ old('social_media_name') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label">@lang('Link')</label>
                                <input type="url" class="form--control" name="link" value="{{ old('link') }}"
                                    required>
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

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.onlineProfileBtn').on('click', function() {
                let onlineProfileData = $(this).data('online_profile');
                let onlineProfileModal = $('#onlineProfileModal');
                onlineProfileModal.find('form').attr('action', $(this).data('action'));
                onlineProfileModal.find('.modal-title').text($(this).data('title'));
                onlineProfileModal.find('[name="social_media_name"]').val(onlineProfileData ? onlineProfileData.social_media_name : '');
                onlineProfileModal.find('[name="link"]').val(onlineProfileData ? onlineProfileData.link : '');
                onlineProfileModal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
