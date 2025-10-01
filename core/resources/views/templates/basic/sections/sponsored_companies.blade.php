@php
    $sponsoredCompaniesContent = getContent('sponsored_companies.content', true);
    $sponsoredCompaniesElements = getContent('sponsored_companies.element');
@endphp
<div class="sponsor-section my-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h3 class="section-heading__title  wow fadeInUp" data-wow-duration="2s">
                        @php echo styleSelectedWord(@$sponsoredCompaniesContent->data_values->heading ?? ''); @endphp
                    </h3>
                </div>
            </div>
        </div>
        <div class="sponsor-item-slider  sponsorSlider wow fadeInUp" data-wow-duration="2s">
            @foreach (@$sponsoredCompaniesElements ?? [] as $sponsoredCompaniesElement)
                <div class="sponsor-card">
                    <div class="sponsor-item">
                        <div class="sponsor-item__thumb d-flex justify-content-center">
                            <img src="{{ frontendImage('sponsored_companies', @$sponsoredCompaniesElement->data_values->image, '60x60') }}"
                                 alt="sponsored-company-image">
                        </div>
                        <div class="sponsor-item__content">
                            <h6 class="sponsor-item__title">
                                {{ __(@$sponsoredCompaniesElement->data_values->company_name) }}
                            </h6>
                            <span class="sponsor-item__location">
                                <span class="icon">
                                    @php echo @$sponsoredCompaniesElement->data_values->icon; @endphp
                                </span>
                                {{ __(@$sponsoredCompaniesElement->data_values->location) }}
                            </span>
                            <p class="sponsor-item__description">
                                {{ __(@$sponsoredCompaniesElement->data_values->short_description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.sponsorSlider').slick({
                dots: false,
                arrows: true,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 1,
                prevArrow: '<button type="button" class="slick-prev"> <i class="las la-angle-left"></i> </button>',
                nextArrow: '<button type="button" class="slick-next"> <i class="las la-angle-right"></i> </button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .sponsor-item__description {
            margin-top: 10px;
            font-size: 14px;
            font-weight: 400;
        }
    </style>
@endpush
