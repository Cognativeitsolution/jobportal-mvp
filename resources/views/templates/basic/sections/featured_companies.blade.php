@php
    $featuredCompanyContent = getContent('featured_companies.content', true);
    $industries = App\Models\Industry::active()
        ->whereHas('employers', function ($employer) {
            $employer->where('is_featured', Status::YES);
        })
        ->take(10)
        ->orderByDesc('id')
        ->get();
@endphp
@if ($industries->count())
    <div class="company-section  my-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h3 class="section-heading__title wow fadeInUp" data-wow-duration="2s">
                            @php echo styleSelectedWord(@$featuredCompanyContent->data_values->heading ?? '', 2); @endphp
                        </h3>
                    </div>
                </div>
            </div>
            <ul class="tab-list">
                <li class="tab-list__item wow fadeInUp" data-wow-duration="2s">
                    <button class="tab-list__link featuredCompaniesBtn active"
                            data-action="{{ route('featured.companies') }}">
                        @lang('All')
                    </button>
                </li>
                @foreach ($industries ?? [] as $industry)
                    <li class="tab-list__item wow fadeInUp" data-wow-duration="2s">
                        <button class="tab-list__link featuredCompaniesBtn"
                                data-action="{{ route('featured.companies', $industry->id) }}">
                            {{ __($industry->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="featuredCompanies"></div>
        </div>
    </div>

    @push('script')
        <script>
            (function($) {
                'use strict';

                getFeaturedCompanies();

                $('.featuredCompaniesBtn').on('click', function() {
                    let url = $(this).data('action');
                    $('.featuredCompaniesBtn.active').removeClass('active');
                    $(this).addClass('active');
                    getFeaturedCompanies(url);
                });

                function getFeaturedCompanies(url = null) {
                    if (url == null) {
                        url = $('.featuredCompaniesBtn.active').data('action');
                    }
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            $('.featuredCompanies').html(response);
                            window.loadFeaturedCompaniesSlickSlider();
                            setTimeout(function() {
                                $('.skeleton').removeClass('skeleton');
                            }, 1000);
                        }
                    });
                }
            })(jQuery)
        </script>
    @endpush
@endif
