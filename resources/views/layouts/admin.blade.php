<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased" style="background-color: #c8d9e8 !important;">
        @include('layouts.adminNavigation')

        <!-- Page Heading -->
        <header class="p-3 bg-white shadow-sm border-bottom">
            <div class="container-fluid d-flex justify-content-between">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="container my-4">
            {{ $slot }}
        </main>
    </body>
</html>
