@extends('Template::layouts.app')
@section('panel')
    @include('Template::partials.frontend.header')
    <main>
        @yield('content')
    </main>
    @include('Template::partials.frontend.footer')
@endsection

@push('script')
    <script>
        (function($) {
            $(document).on('click', '.favoriteBtn', function() {
                let thisBtn = $(this);
                @if (authUser())
                    $.ajax({
                        url: $(this).data('action'),
                        type: 'GET',
                        success: function(response) {
                            thisBtn.html(response.icon);
                            notify('success', response.notify.success);
                        }
                    });
                @else
                    window.location.href = $(this).data('action');
                @endif
            });
        })(jQuery)
    </script>
@endpush
