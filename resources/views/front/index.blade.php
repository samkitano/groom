@extends('layouts.front')

@section('title', $page->title)

@section('seo')

@endsection

@section('content')
    <article class="app-page">
        @if($page->heading)
            <h1 class="app-page-heading">{!! $page->heading !!}</h1>
        @endif

        @if($page->body)
            <article class="app-page-body">
                {!! $page->body !!}
            </article>
        @endif

        @foreach($page->modules as $module)
            <aside class="{{ $module->css_class }}{{ $loop->index & 1 ? ' odd' : ' even' }}{{ $module->image ? ' has-image' : '' }}"
                   style="{{ $module->style }}">
                <div class="module-text">
                    <h1>{!! $module->title !!}</h1>
                    <p>{!! $module->body !!}</p>

                    @if($module->more)
                        <a href="{{ "/{$locale}/".__("routes.{$module->more}") }}">{{ __('groom.learn_more') }}</a>
                    @endif
                </div>

                @if($module->image && $module->image_outside)
                    @php
                        $img_url = url('img').'/'.$module->image;
                    @endphp

                    <div class="module-image"
                         role="img"
                         style="background: url('{{ $img_url }}') no-repeat center;background-size:cover;"
                    ></div>
                @endif
            </aside>
        @endforeach
    </article>
@endsection
