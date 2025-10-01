@if (gs('multi_language'))
    @php
        $selectedLanguage = App\Models\Language::where('code', config('app.locale'))->first();
        $languages = App\Models\Language::where('code', '!=', config('app.locale'))->get();
    @endphp
    <div class="custom--dropdown">
        <div class="custom--dropdown__selected dropdown-list__item">
            <div class="thumb">
                <img src="{{ getImage(getFilePath('language') . '/' . $selectedLanguage->image, getFileSize('language')) }}"
                     alt="country-image">
            </div>
            <span class="text">{{ __($selectedLanguage->name) }}</span>
        </div>
        @if (!blank($languages))
            <ul class="dropdown-list">
                @foreach ($languages as $language)
                    <li class="dropdown-list__item">
                        <a href="{{ route('lang', @$language->code) }}" class="thumb d-flex align-items-center">
                            <img src="{{ getImage(getFilePath('language') . '/' . $language->image, getFileSize('language')) }}"
                                 alt="language-image">
                            <span class="text">{{ __($language->name) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
