@php
    $cities = App\Models\Location::city()->active()->get();
    $jobTypes = App\Models\Type::active()->get();
    $keywords = App\Models\Keyword::whereHasJobs()->inRandomOrder()->take(3)->pluck('keyword')->toArray();
@endphp
<form action="{{ route('job.filter') }}" method="POST" class="banner-form wow fadeInUp" data-wow-duration="2s">
    @csrf
    <div class="search-form">
        <span class="search-form__icon"><i class="las la-search"></i></span>
        <input type="text" class="form--control" name="keyword" placeholder="@lang('Search by keyword')">
    </div>
    <div class="search-form">
        <span class="search-form__icon"> <i class="las la-briefcase"></i> </span>
        <div class="search-form-select">
            <select class="select2 form--control" name="type_id" data-minimum-results-for-search="-1">
                <option selected value="">@lang('Select Job Type')</option>
                @foreach ($jobTypes as $type)
                    <option value="{{ $type->id }}">
                        {{ __($type->name) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="search-form">
        <span class="search-form__icon"> <i class="las la-map-marker"></i> </span>
        <div class="search-form-select">
            <select class=" select2 form--control" name="city_id">
                <option value="" selected>@lang('Select Location')</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">
                        {{ __($city->name) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="search-form">
        <button type="submit" class="btn btn--base pill w-100">@lang('Search Job')</button>
    </div>
</form>
@if ($keywords)
    <p class="banner-form-text wow fadeInUp" data-wow-duration="2s">
        <span class="text">
            @lang('Popular Searches'):
            @foreach ($keywords as $keyword)
                <a href="{{ route('job.keyword', $keyword) }}">
                    {{ __(keyToTitle($keyword)) }}
                </a>
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </span>
    </p>
@endif

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endpush

@push('style')
    <style>
        .banner-content .banner-form-wrapper .banner-form .search-form .select2-container .select2-selection--single .select2-selection__rendered {
            padding: 0 !important;
            font-size: 16px !important;
            font-weight: 400;
        }
    </style>
@endpush
