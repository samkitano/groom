@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.front')

@section('title', ucfirst(__('routes.maintenance')))

@section('seo', '')

@section('content')
    <div class="container">
        <div class="row">
            <div class="jumbotron">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores atque beatae consequatur cumque enim, esse harum impedit mollitia neque nesciunt nostrum obcaecati officia, praesentium quibusdam quidem sit, veritatis? Inventore, repellendus.
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Travaux</h1>
                <p style="text-align: justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid, atque cupiditate deleniti dolor dolores iste magni veritatis. Assumenda consequuntur, incidunt? Architecto consectetur culpa deserunt eius enim fuga modi quam.
                </p>

                <h1>Raffraichissemant</h1>
                <p style="text-align: justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid deleniti earum itaque non quidem, soluta! Culpa deserunt eveniet fuga impedit itaque maiores nostrum officia quas reiciendis suscipit? Dolore, dolorum, perferendis!
                </p>

                <h1>Décoration</h1>
                <p style="text-align: justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias assumenda at, beatae consectetur consequuntur deserunt dolor inventore magnam molestias mollitia neque, nesciunt nisi omnis quaerat quia sint soluta suscipit veritatis?
                </p>

                <h1>Organissation d'événement</h1>
                <p style="text-align: justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam architecto asperiores atque dicta eligendi error iste itaque labore, nam nesciunt nulla odit pariatur quas quia quisquam sapiente temporibus tenetur.
                </p>
            </div>
        </div>
    </div>
@endsection
