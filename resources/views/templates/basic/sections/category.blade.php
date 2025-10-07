@php
    $categoryContent = getContent('category.content', true);
    $query = App\Models\Category::active();
    $categories = (clone $query)
        ->withCount([
            'jobs' => function ($query) {
                $query->approved();
            },
        ])
        ->orderByDesc('jobs_count')
        ->take(8)
        ->get();
    $categoryCount = (clone $query)->count();
@endphp

<div class="category-section mb-120">
    <div class="container">
        <div class="category-wrapper wow fadeInUp" data-wow-duration="2s">
            <div class="section-heading">
                <h3 class="section-heading__title   wow fadeInUp" data-wow-duration="2s">
                    @php echo styleSelectedWord(@$categoryContent->data_values->heading ?? ''); @endphp
                </h3>
            </div>
            <div class="row gy-4">
                @foreach ($categories ?? [] as $category)
                    <div class="col-xl-3 col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="2s">
                        <a href="{{ route('job.category', $category->id) }}" class="category-item">
                            <div class="category-item__thumb">
                                <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}" alt="category-image">
                            </div>
                            <p class="category-item__title">{{ __($category->name) }}</p>
                            <p class="category-item__job">{{ @$category->jobs_count }} @lang('jobs available')
                                <span class="category-item__icon"><i class="fa-solid fa-arrow-right-long"></i></span>
                            </p>
                            <x-shape shapeClass="category-item__shape" fileName="c-1" />
                        </a>
                    </div>
                @endforeach
            </div>
            @if ($categoryCount > 8)
                <a href="{{ route('categories') }}" class="section-button wow fadeInUp w-100 text-center mt-4" data-wow-duration="2s">
                    @lang('All Categories')
                    <span class="load-more-button__icon"><i class="las la-arrow-right"></i></span>
                </a>
            @endif
        </div>
    </div>
</div>
