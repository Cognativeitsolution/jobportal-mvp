@php
    $adContent = getContent('ad02.content', true);
    $bannerHeading = styleSelectedWord(@$adContent->data_values->heading ?? '', 2, true);
@endphp

<div class="create_resume_sec">
    <div class="container">

        <div class="sec_wrapper"
            @if (@$adContent->data_values->has_image && @$adContent->data_values->image) style="background-image: url('{{ getImage('assets/images/frontend/ad02/' . @$adContent->data_values->image) }}'); background-size: cover; background-position: center;" @endif>
            <div class="row">
                <div class="col-12">
                    <div class="sec_txt">
                        {{-- Optional small text --}}
                        @if (!empty($adContent->data_values->subheading))
                            <p>{{ __(@$adContent->data_values->subheading) }}</p>
                        @endif

                        {{-- Heading --}}
                        <h3>
                            {{ @$bannerHeading[0] }}
                            <span class="text--base title-style">
                                @php echo @$bannerHeading[1]; @endphp
                            </span>
                        </h3>

                        {{-- Description --}}
                        <p>{{ __(@$adContent->data_values->description) }}</p>
                    </div>

                    {{-- Button --}}
                    @if (!empty($adContent->data_values->button_text))
                        <div class="sec_btn">
                            <a href="{{ @$adContent->data_values->button_link ?? 'javascript:;' }}">
                                {{ __(@$adContent->data_values->button_text) }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
