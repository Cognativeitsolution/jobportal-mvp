<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ gs()->siteName(__($pageTitle)) }}</title>

    @include('partials.seo')

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet" />

    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/magnifiq.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/slider-range.css') }}" rel="stylesheet" />

    @stack('style-lib')

    <link href="{{ asset($activeTemplateTrue . 'css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet" />

    @stack('style')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}">
</head>

@php echo loadExtension('google-analytics') @endphp

<body>
    @stack('fbComment')

    <div class="preloader-dot-loading">
        <div class="cssload-loading">
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
        </div>
    </div>

    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>

    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    @yield('panel')

    @include('Template::partials.frontend.cookie_card')

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/magnifiq-popup.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slider.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @include('partials.notify')

    @php echo loadExtension('tawk-chat') @endphp

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @stack('script')

    <script>
        (function($) {
            "use strict";

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('input,select');
            $.each(inputElements, function(index, element) {
                if (element.id) {
                    return false;
                }
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                if (element.id) {
                    return false;
                }
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });

            $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function(i, element) {
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });

            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });

            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });
        })(jQuery);
    </script>
</body>

</html>
