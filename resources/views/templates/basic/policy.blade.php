@extends('Template::layouts.frontend')
@section('content')
    <div class="my-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading wow fadeInUp" data-wow-duration="2s">
                        <h3 class="section-heading__title">
                            {{ __(@$policy->data_values->title) }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12  wow fadeInUp" data-wow-duration="2s">
                    @php echo @$policy->data_values->details @endphp
                </div>
            </div>
            <!-- Faqs Section Start -->
            <div class="faqs_sec">
                <div class="row">
                    <div class="col-12">
                        <div class="txt">
                            <h2 class="text-center mb-3 mb-lg-4">Frequently Asked Questions</h2>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="mb-0">
                                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam eligendi
                                            consequatur ea maiores, obcaecati quaerat officiis id velit. Ad consequuntur
                                            earum accusantium quidem! Esse obcaecati dicta expedita minima quasi? Impedit.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Accordion Item #2
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="mb-0">
                                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam eligendi
                                            consequatur ea maiores, obcaecati quaerat officiis id velit. Ad consequuntur
                                            earum accusantium quidem! Esse obcaecati dicta expedita minima quasi? Impedit.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Accordion Item #3
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="mb-0">
                                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam eligendi
                                            consequatur ea maiores, obcaecati quaerat officiis id velit. Ad consequuntur
                                            earum accusantium quidem! Esse obcaecati dicta expedita minima quasi? Impedit.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Faqs Section Start -->
        </div>
    </div>
@endsection

@push('style')
    <style>
        .section-heading {
            margin-bottom: 40px;
        }
    </style>
@endpush
