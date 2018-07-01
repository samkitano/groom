<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Groom - @yield('title')</title>

        @yield('seo')

        <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    </head>

    <body class="{{ Route::currentRouteName() }}">
        <main id="app">
            @include('layouts.partials.front-hero', ['route' => Route::currentRouteName()])
            @include('layouts.partials.lang-selector')
            {{--@include('layouts.partials.front-nav')--}}

            <section class="content">
                @yield('content')
            </section>

            @include('layouts.partials.front-footer')
        </main>

        <script src="{{ asset('js/front.js') }}"></script>

        @stack('scripts')
    </body>
</html>
