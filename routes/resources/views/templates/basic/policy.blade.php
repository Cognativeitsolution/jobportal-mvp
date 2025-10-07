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
                    @php  echo @$policy->data_values->details @endphp
                </div>
            </div>
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
