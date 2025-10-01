<div class="blog-item">
    <div class="blog-item__thumb">
        <a href="{{ route('blog.details', @$blog->slug) }}" class="blog-item__thumb-link">
            <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '430x300') }}" class="fit-image" alt="blog-image">
        </a>
    </div>
    <div class="blog-item__content">
        <ul class="text-list flex-align gap-3">
            <li class="text-list__item">{{ __(@$blog->data_values->category) }}</li>
            <li class="text-list__item">{{ showDateTime($blog->created_at, 'd M, Y') }}</li>
        </ul>
        <h5 class="blog-item__title">
            <a href="{{ route('blog.details', @$blog->slug) }}" class="blog-item__title-link">
                <span class="border-effect">{{ __($blog->data_values->title) }}</span>
            </a>
        </h5>
        <p class="blog-item__desc">{{ strLimit(strip_tags($blog->data_values->description_nic), 80) }}</p>
        <a class="blog-item__btn" href="{{ route('blog.details', $blog->slug) }}">
            @lang('Read More')
            <span class="btn-icon"><i class="las la-angle-right"></i></span>
        </a>
    </div>
</div>
