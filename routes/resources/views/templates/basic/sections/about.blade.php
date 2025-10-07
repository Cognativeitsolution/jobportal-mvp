@php
    $aboutContent = getContent('about.content', true);
    $aboutElements = getContent('about.element');
@endphp
<div class="about-section my-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="about-wrapper">
                    <div class="about-left">
                        <div class="about-left__thumb wow fadeInRight" data-wow-duration="2s">
                            <img src="{{ frontendImage('about', @$aboutContent->data_values->image, '585x470') }}" alt="about-image">
                            <a href="{{ @$aboutContent->data_values->video_link }}" class="play-button">
                                <span class="icon"><i class="las la-play"></i></span>
                            </a>
                        </div>
                        <x-shape shapeClass="about-left__shape" fileName="r-1" />
                        <x-shape shapeClass="about-left__shape-two" fileName="about-1" />
                    </div>
                    <div class="about-right  wow fadeInLeft" data-wow-duration="2s">
                        <h2 class="about-right__title">
                            @php echo styleSelectedWord(@$aboutContent->data_values->heading ?? '', 2); @endphp
                        </h2>
                        <p class="about-right__desc">
                            {{ __(@$aboutContent->data_values->subheading) }}
                        </p>
                        <ul class="info-list">
                            @foreach ($aboutElements ?? [] as $aboutElement)
                                <li class="info-list__item">{{ __($aboutElement->data_values->title) }}</li>
                            @endforeach
                        </ul>
                        <div class="about-right__btn">
                            <a href="{{ url(@$aboutContent->data_values->button_url) }}" class="btn btn--base btn--lg">
                                {{ __(@$aboutContent->data_values->button_text) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
