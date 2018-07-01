@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.front')

@section('title', ucfirst(__('routes.lease')))

@section('seo', '')

@section('content')
    <div class="container">
        <div class="row">
            <div class="jumbotron">
                Avec une fort experience dans l'hotelerie haut de gamme
                HOME CONFORT vous assure une qualité de service reguliere et exceptionnelle.
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Check in </h1>
                <p style="text-align: justify">
                    Apres avoir controlé  l'état d'accueil de votre bien, propreté, chauffage, aération,
                    bouteille de vin de bienvenu par exemple,
                    nous prenons contact avec votre locataire pour l'heure d'arriver et gérons tout retard
                    éventuel. <br>
                    Nous faisons systematiquement un état des lieux précis avec les vacanciers, vaisselle,
                    électromanager et autre commodité, sans oublier les recommandation du bon fonctionnement des lieux
                    donner par le propriétaire au par avant. <br>
                </p>

                <h1>Conseillez votre locataire</h1>
                <p style="text-align: justify">
                    Nous avons également le plaisir de pouvoir renseiller votre client pour tout information
                    sur le quartier, la ville ou la region. <br>
                    Nous gerons tout situation d'urgence, clé cassé, panne de l'éléctroménager, etc <br>
                    Afin d'optimiser le confort de vos locataire
                    nous communiquons nos coordonnées et restons disponible 24H/24 et 7j/7.
                </p>

                <h1>Check out</h1>
                <p style="text-align: justify">
                    Une fois avoir eu comfirmation de l'heure du départ des vacanciers,
                    nous rédigeons l'état des lieux de sortie avec ces derniers. <br>
                    Pour facilité le départ nous proposons au propriétaire une option "Garde clé"
                    et l'informons de la sortie des locataires par E-mail ou téléphone.
                </p>

                <h1>Remise en état</h1>
                <p style="text-align: justify">
                    Pour finir, une remise en état parfait de votre bien sera effectué:
                    <ul>
                    <li>Ménage de sols et vitres</li>
                    <li>Degraissage de l'éléctroménager</li>
                    <li>Détartrage des sanitaires</li>
                    <li>Blanchisseries</li>
                    <li>Rangement général des interieurs et extérieurs</li>
                </ul>
                </p>
            </div>
        </div>
    </div>
@endsection
