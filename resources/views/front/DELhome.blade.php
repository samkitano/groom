@php
    $locale = app()->getLocale();
    $curr_native = config('laravellocalization.supportedLocales.'.app()->getLocale().'.native');
@endphp

@extends('layouts.front')

@section('title', ucfirst(__('routes.home')))

@section('seo', '')

@section('content')
    @foreach($modules as $module)
        <article class="app-module" style="{{ $module->style }}">
            <h1>{{ $module->title }}</h1>
            <p>{!! $module->body !!}</p>

            @if($module->more)
                <p><a href="{{ "/{$locale}/".LaravelLocalization::transRoute("routes.{$module->more}") }}">{{ __('groom.learn_more') }}</a></p>
            @endif
        </article>

{{--
        @foreach($module->sections as $section)
            @if($section->published)
                <a class="goto-page"
                   href="{{ "/{$locale}/".LaravelLocalization::transRoute("routes.{$module->name}").'#'.$section->slug }}">
                    <article class="listed-service">
                        <div class="service" style="{{ $section->style }}">
                            <div class="service-text">
                                <h2>{{ $section->title }}</h2>
                                <h4>{{ $section->teaser }}</h4>
                            </div>
                        </div>
                    </article>
                </a>
            @endif
        @endforeach
--}}
    @endforeach
@endsection
