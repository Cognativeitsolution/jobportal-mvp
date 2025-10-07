@extends('Template::layouts.frontend')
@section('content')
    <section class="my-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-xxl-8 col-lg-7">
                    <div class="blog-details">
                        <div class="blog-details__thumb wow fadeInUp" data-wow-duration="2s">
                            <img src="{{ frontendImage('blog', @$blog->data_values->image, '860x600') }}" class="fit-image" alt="blog-image">
                        </div>
                        <div class="blog-details__content">
                            <div class="d-flex align-items-center gap-3 flex-wrap wow fadeInUp" data-wow-duration="2s">
                                <span class="blog-item__text">
                                    <span class="blog-item__text-icon"><i class="fa-solid fa-calendar-check"></i></span>
                                    {{ showDateTime($blog->created_at, 'd F, Y') }}
                                </span>
                            </div>
                            <h3 class="blog-details__title wow fadeInUp" data-wow-duration="2s">{{ __($blog->data_values->title) }}</h3>
                            @php echo $blog->data_values->description_nic; @endphp
                            <div class="comment-form-area">
                                <div class="fb-comments" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>
                            </div>
                            @include('Template::partials.frontend.social_share', [
                                'title' => @$blog->data_values->title,
                                'description' => strLimit(@$blog->data_values->description, 200),
                                'image' => frontendImage('blog', @$blog->data_values->image, '860x605'),
                            ])
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar__bottom">
                            <div class="blog-sidebar">
                                <h6 class="blog-sidebar__title wow fadeInUp" data-wow-duration="2s">@lang('Related Posts')</h6>
                                @foreach ($recentBlogs ?? [] as $recentBlog)
                                    <div class="latest-blog wow fadeInUp" data-wow-duration="2s">
                                        <div class="latest-blog__thumb">
                                            <a href="{{ route('blog.details', @$recentBlog->slug) }}">
                                                <img src="{{ frontendImage('blog', @$recentBlog->data_values->image, '430x300') }}" class="fit-image" alt="blog-image">
                                            </a>
                                        </div>
                                        <div class="latest-blog__content">
                                            <span class="latest-blog__date">{{ showDateTime($recentBlog->created_at, 'd M, Y') }}</span>
                                            <h6 class="latest-blog__title">
                                                <a href="{{ route('blog.details', @$recentBlog->slug) }}">{{ __($recentBlog->data_values->title) }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
