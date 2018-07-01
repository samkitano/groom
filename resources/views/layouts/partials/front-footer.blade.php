@php
    $locale = app()->getLocale();
@endphp

<footer class="app-footer">
    <a class="btn btn-lg btn-outline-info" href="{{ "/{$locale}/".LaravelLocalization::transRoute("routes.contact") }}">{{ __('groom.contact') }}</a>
</footer>
