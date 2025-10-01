@php
    $bannerContent = getContent('banner.content', true);
    $bannerHeading = styleSelectedWord(@$bannerContent->data_values->heading ?? '', 2, true);
@endphp
<section class="banner-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="banner-content">
                    <h1 class="banner-content__title   wow fadeInUp" data-wow-duration="2s">
                        {{ @$bannerHeading[0] }}
                        <span class="text--base title-style">
                            <span class="title-shape">
                                <img src="{{ asset($activeTemplateTrue . 'images/shapes/t-1.png') }}" alt="shape-image">
                            </span>
                            <span class="title-shape-two">
                                <img src="{{ asset($activeTemplateTrue . 'images/shapes/t-2.png') }}" alt="shape-image">
                            </span>
                            @php echo @$bannerHeading[1]; @endphp
                        </span>
                    </h1>
                    <p class="banner-content__desc wow fadeInUp" data-wow-duration="2s">
                        {{ __(@$bannerContent->data_values->subheading) }}
                    </p>
                    <div class="banner-form-wrapper">
                        @include('Template::partials.frontend.banner_search_form')
                        <div class="banner-shape">
                            <x-thumb-image shapeClass="shape" fileName="{{ @$bannerContent->data_values->image_one }}" />
                            <x-thumb-image shapeClass="shape-two" fileName="{{ @$bannerContent->data_values->image_two }}" />
                            <x-thumb-image shapeClass="shape-three" fileName="{{ @$bannerContent->data_values->image_three }}" />
                            <x-thumb-image shapeClass="shape-four" fileName="{{ @$bannerContent->data_values->image_four }}" />
                            <x-thumb-image shapeClass="shape-five" fileName="{{ @$bannerContent->data_values->image_five }}" />
                            <x-thumb-image shapeClass="shape-nine" fileName="{{ @$bannerContent->data_values->image_six }}" />

                            <x-shape shapeClass="shape-six" fileName="b-2" />
                            <x-shape shapeClass="shape-seven" fileName="b-2" />
                            <x-shape shapeClass="shape-eight" fileName="b-1" />
                            <x-shape shapeClass="shape-ten" fileName="b-1" />
                            <x-shape shapeClass="shape-eleven" fileName="b-3" />
                            <x-shape shapeClass="shape-twelve" fileName="b-3" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
