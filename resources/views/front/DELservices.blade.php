@extends('layouts.front')

@section('title', $service->title)

@section('seo', '')

@section('content')
    {{ $service->body }}
@endsection
