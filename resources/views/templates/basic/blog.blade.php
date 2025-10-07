@extends('Template::layouts.frontend')
@php
    $blogContent = getContent('blog.content', true);
@endphp
@section('content')
    <div class="blog-section my-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading  wow fadeInUp" data-wow-duration="2s">
                        <h3 class="section-heading__title">
                            @php echo styleSelectedWord(@$blogContent->data_values->heading ?? ''); @endphp
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($blogs ?? [] as $blog)
                    <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="2s">
                        @include('Template::partials.frontend.blog_card')
                    </div>
                @endforeach
            </div>
            @if ($blogs->hasPages())
                <div class="row align-items-center mt-4">
                    {{ paginateLinks($blogs) }}
                </div>
            @endif
        </div>
    </div>

    @if ($page->secs != null)
        @foreach (json_decode($page->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection
