@php
    $featuredJobContent = getContent('featured_job.content', true);
    $featuredJobCategories = App\Models\Category::active()
        ->whereHas('job', function ($job) {
            $job->featured()->approved();
        })
        ->limit(8)
        ->get();
@endphp
<div class="feature-section my-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="section-heading__title wow fadeInUp" data-wow-duration="2s">
                        @php echo styleSelectedWord(@$featuredJobContent->data_values->heading ?? ''); @endphp
                    </h3>
                    <a href="{{ route('featured.jobs.list') }}" class="section-button wow fadeInUp" data-wow-duration="2s">
                        @lang('Show All')
                        <span class="section-button__icon"><i class="fa-solid fa-arrow-right-long"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="feature-wrapper">
            @if ($featuredJobCategories->count())
                <ul class="tab-list justify-content-start">
                    <li class="tab-list__item  wow fadeInUp" data-wow-duration="2s">
                        <button data-action="{{ route('featured.jobs') }}" class="tab-list__link active featuredJobBtn">
                            @lang('All')
                        </button>
                    </li>
                    @foreach ($featuredJobCategories ?? [] as $category)
                        <li class="tab-list__item">
                            <button class="tab-list__link featuredJobBtn" data-action="{{ route('featured.jobs', $category->id) }}">
                                {{ __($category->name) }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="row gy-4 showFeaturedJob"></div>
            @endif
        </div>
    </div>
</div>

@if ($featuredJobCategories->count())
    @push('script')
        <script>
            (function($) {
                'use strict';

                getFeaturedJob();

                $('.featuredJobBtn').on('click', function() {
                    let url = $(this).data('action');
                    $('.featuredJobBtn.active').removeClass('active');
                    $(this).addClass('active');
                    getFeaturedJob(url);
                });

                function getFeaturedJob(url = null) {
                    if (url == null) {
                        url = $('.featuredJobBtn.active').data('action');
                    }
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            $('.showFeaturedJob').html(response);
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
