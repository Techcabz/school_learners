<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCHOOL FORM 10 LEARNER’S AES MCES ') }}</title>
    @include('layouts.libs.css')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .auth-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.2)), url('{{ asset('images/background.webp') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            /* This ensures it covers full viewport height */
            position: relative;
        }

        .wrapper {
            min-height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .footer {
            position: relative !important;
            bottom: 0 !important;
            width: 100% !important;
        }
    </style>
    @livewireStyles
</head>

<body class="fix-header card-no-border fix-sidebar">


    <div id="main-wrapper">
        @include('layouts.navbar')
        @yield('content')
    </div>


    <footer class="footer">
        <div class="d-flex justify-content-center">
            <p> © 2025. All Rights Reserved. &nbsp; Developed by BSIT 2025 </p>
        </div>
    </footer>

    @include('layouts.libs.js')
    @livewireScripts
</body>

</html>
