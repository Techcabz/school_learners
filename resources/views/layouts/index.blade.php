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


    @livewireStyles
</head>

<body class="fix-header card-no-border fix-sidebar">


    <div id="main-wrapper">
        @include('layouts.navbar')
        @yield('content')
    </div>


    <footer class="footer" style="margin-top:20px"> 
        <div class="d-flex justify-content-center">
           <p> © 2025. All Rights Reserved. &nbsp; Developed by ? </p> 
        </div>
    </footer>

    @include('layouts.libs.js')
    @livewireScripts
</body>

</html>
