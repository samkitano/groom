<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="NOINDEX,NOFOLLOW,NOYDIR,NOODP,NOARCHIVE">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - Admin</title>

        <script src="{{ asset('js/admin.js') }}" defer></script>

        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    </head>

    <body>
        <div id="app">
            <App base-dir='{{ basename(base_path()) }}'
                 app-name='{{ config('app.name') }}'
                 :user='{{ auth()->user() }}'/>
        </div>
    </body>
</html>
