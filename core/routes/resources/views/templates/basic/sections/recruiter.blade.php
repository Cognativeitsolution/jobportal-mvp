@php
    $recruiterContent = getContent('recruiter.content', true);
@endphp

<div class="cta-section my-120  wow fadeInUp" data-wow-duration="2s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="cta-wrapper">
                    <div class="cta-shape">
                        <x-shape shapeClass="cta-shape__one" fileName="r-1" />
                        <x-shape shapeClass="cta-shape__two" fileName="cta-1" />
                        <x-shape shapeClass="cta-shape__three" fileName="r-1" />
                        <x-shape shapeClass="cta-shape__four" fileName="cta-1" />
                    </div>
                    <div class="cta-content  wow fadeInRight" data-wow-duration="2s">
                        <h2 class="cta-content__title">{{ __(@$recruiterContent->data_values->heading) }}</h2>
                        <p class="cta-content__text">{{ __(@$recruiterContent->data_values->subheading) }}</p>
                        <div class="cta-content__btn">
                            <a href="{{ url(@$recruiterContent->data_values->button_url) }}" class="btn btn--base btn--lg">
                                {{ __(@$recruiterContent->data_values->button_text) }}
                            </a>
                        </div>
                    </div>
                    <div class="cta-thumb wow fadeInLeft" data-wow-duration="2s">
                        <img src="{{ frontendImage('recruiter', @$recruiterContent->data_values->image, '400x345') }}" alt="recruiter-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
