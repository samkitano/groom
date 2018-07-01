@php
    $locale = app()->getLocale();
    $curr_native = config('laravellocalization.supportedLocales.'.app()->getLocale().'.native');
@endphp

@extends('layouts.front')

@section('title', $intro->title)

@section('seo', '')

@section('content')
    <section class="app-intro"{{ $introCss ? 'style="'.$introCss.'"' : '' }}>
        <h1>{{ $intro->title }}</h1>
        <p>{{ $intro->body }}</p>
    </section>

    <section class="app-services-list">
        @foreach($services as $service)
            <a class="goto-page" href="{{ "/{$locale}/".LaravelLocalization::transRoute('routes.services').'/'.$service->slug }}">
                <article class="listed-service">
                    <div class="service" style="background:url('{{ url('img').'/'.$service->bg }}') no-repeat center;background-size:cover">
                        <div class="service-text">
                            <h2>{{ $service->title }}</h2>
                            <h4>{{ $service->teaser }}</h4>
                        </div>
                    </div>
                </article>
            </a>
        @endforeach
    </section>
@endsection
