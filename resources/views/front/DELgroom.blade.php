@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.front')

@section('title', ucfirst(__('routes.groom')))

@section('seo', '')

@section('content')
    <div class="container">
        <div class="row">
            <div class="jumbotron">
                Par soussi du bien etre, la priorité de
                HOME CONFORT est de vous assuré un bien propre et surveiller
                avec une equipe professionnelle et discrete.
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Nettoyage fréquent interieure et exterieur</h1>
                <p style="text-align: justify">
                    Pour une meilleur longevité des lieux, nous nous occupons d'entretenir le bien
                    en les aérant regulierement, les dépoussieant... <br>
                    Concernant les exterieures, (terrasse, jardin, piscine, etc) il est important qu'un travaille
                    regulier soit effectuer pour conserver un environement naturel agréable.
                </p>

                <h1>Control de l'electromenager</h1>
                <p style="text-align: justify">
                    Pour assurer la tranquillité de votre sejour et vous laisser livre a vos distraction,
                    HOME CONFORT vérifie l'état des generales des appareil ainsi que leur garantie.
                    Nous tiendrons au courant le propriétaire de tout panne et proposerons des solutions eventuelle.
                </p>

                <h1>Verification du bon fonctionnement des instalation général</h1>
                <p style="text-align: justify">

                </p>

                <h1>Surveillance reguliere et aléatoire des lieux</h1>
                <p style="text-align: justify">

                </p>
            </div>
        </div>
    </div>
@endsection
