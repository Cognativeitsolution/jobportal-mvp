@php
    $topHotJobContent = getContent('top_hot_job.content', true);
    $hotJobCategories = App\Models\Category::active()
        ->whereHas('job', function ($query) {
            $query->where('status', Status::JOB_APPROVED);
        })
        ->take(5)
        ->get();
@endphp
<div class="job-section my-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h3 class="section-heading__title   wow fadeInUp" data-wow-duration="2s">
                        @php echo styleSelectedWord(@$topHotJobContent->data_values->heading ?? '', 2); @endphp
                    </h3>
                </div>
            </div>
        </div>
        @if ($hotJobCategories->count())
            <ul class="tab-list wow fadeInUp" data-wow-duration="2s">
                <li class="tab-list__item">
                    <button class="tab-list__link categoryHotJobBtn active" data-action="{{ route('category.hot.jobs') }}">@lang('All')</button>
                </li>
                @foreach ($hotJobCategories ?? [] as $category)
                    <li class="tab-list__item">
                        <button class="tab-list__link categoryHotJobBtn" data-action="{{ route('category.hot.jobs', $category->id) }}">
                            {{ __($category->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="row gy-4 feature-item-wrapper justify-content-center showHotJob"></div>
        @endif
    </div>
</div>

@if ($hotJobCategories->count())
    @push('script')
        <script>
            (function($) {
                'use strict';

                getCategoryHotJob();

                $('.categoryHotJobBtn').on('click', function() {
                    let url = $(this).data('action');
                    $('.categoryHotJobBtn.active').removeClass('active');
                    $(this).addClass('active');
                    getCategoryHotJob(url);
                });

                function getCategoryHotJob(url = null) {
                    if (url == null) {
                        url = $('.categoryHotJobBtn.active').data('action');
                    }
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            $('.showHotJob').html(response);
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
