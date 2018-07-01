@extends('layouts.front')

@section('title', $content->title)

@section('seo', '')

@section('content')
    {{ dump($content->body) }}
@endsection
