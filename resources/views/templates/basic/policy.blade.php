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
        </div>
        @if (!empty(@$policy->faqs) && count(@$policy->faqs))
            <!-- Faqs Section Start -->
            <div class="faqs_sec">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="txt">
                                <h2 class="text-center mb-3 mb-lg-4">Frequently Asked Questions</h2>
                            </div>
                            <div class="accordion" id="accordionExample">
                                @foreach (@$policy->faqs as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                                                aria-controls="collapse{{ $index }}">
                                                {{ __(@$faq->question) }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" class="accordion-collapse collapse show"
                                            aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p class="mb-0">
                                                    {{ __(@$faq->answer) }}

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Faqs Section End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('style')
    <style>
        .section-heading {
            margin-bottom: 40px;
        }
    </style>
@endpush
