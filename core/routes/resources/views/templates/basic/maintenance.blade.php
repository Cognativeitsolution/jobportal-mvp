@extends('Template::layouts.app')
@section('panel')
    <section class="maintenance-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="error-content text-center">
                        <div class="error-content__thumb">
                            <img src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}">
                        </div>
                        <div class="error-content__desc mt-4">
                            @php echo @$maintenance->data_values->description @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script>
            "use strict";
            (function($) {
                $('footer').remove();
                $('.top-notice').remove();
                $('body').addClass('bg-light').css({
                    "min-height": "100vh",
                    "display": "flex",
                    "justify-content": "center",
                    "align-items": "center",
                    "flex-direction": "column"
                });
            })(jQuery);
        </script>
    @endpush

    @push('style')
        <style>
            .maintenance-page {
                padding: 40px;
                background: transparent;
                border-radius: 10px;
            }
        </style>
    @endpush
