@extends('Template::layouts.frontend')
@section('content')
    <div class="my-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h3 class="section-heading__title">
                            @lang('Cookie Policy')
                        </h3>
                    </div>
                </div>
            </div>
            <p>
                @php echo @$cookie->data_values->description @endphp
            </p>
        </div>
    </div>
@endsection
