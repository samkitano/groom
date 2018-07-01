@php
    $locale = app()->getLocale();
    $curr_native = config('laravellocalization.supportedLocales.'.app()->getLocale().'.native');
@endphp

<div class="lang-selector" id="lang_selector">
    <div class="langs">
        <div class="current-lang">
            <a class="lang-trigger"
               id="lang_trigger"
               href="#"><img
                               width="25"
                               height="17"
                               src="{{ url('flags').'/'.$locale.'.png' }}"
                               alt="{{ $curr_native }}"> <span>{{ $curr_native }}</span></a>
        </div>

        <div class="lang-choices">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if($localeCode != $locale)
                    <a rel="alternate"
                       hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                    ><span>
                        <img
                            width="25"
                            height="17"
                            src="{{ url('flags').'/'.$localeCode.'.png' }}"
                            alt="{{ $properties['native'] }}"><span class="native">{{ $properties['native'] }}</span>
                    </span></a>
                @endif
            @endforeach
        </div>
    </div>
</div>
