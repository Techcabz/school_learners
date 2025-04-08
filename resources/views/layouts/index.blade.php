<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCHOOL FORM 10 LEARNER’S AES MCES ') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    
    <!-- Fonts -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/default.css') }}" id="theme">
    <!-- Default theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"
        integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link
        href="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/sb-1.4.2/sl-1.6.2/datatables.min.css"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css">

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <link rel="stylesheet" href="{{ asset('css/alert/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.webp') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    @livewireStyles
</head>

<body style="margin: 0; padding: 0">

    <div class="fix-header card-no-border fix-sidebar">
        @include('layouts.navbar')
        <div id="main-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/sb-1.4.2/sl-1.6.2/datatables.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/he.min.js"></script>


    <script src="{{ asset('node_modules/jssor.slider-28.1.0.min.js') }}"></script>
    <script src="{{ asset('node_modules/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('node_modules/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('node_modules/jquery.validate.js') }}"></script>
    <script src="{{ asset('node_modules/alertify.min.js') }}"></script>
    <script src="{{ asset('node_modules/jquery.redirect.js') }}"></script>
    <script src="{{ asset('js/slider.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
    <script src="{{ asset('js/datatable/table.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/v/bs4/dt-2.0.5/datatables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        // Define the asset URL in a Blade section dada
        var tableScriptUrl = "{{ asset('js/datatable/table.js') }}";

      

        function triggerFileInput() {
            document.getElementById('fileInput').click();
        }

        function alertSwift(icon, position, title) {
            const Toast = Swal.mixin({
                toast: true,
                position: position,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: title
            });
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('closeModal', (event) => {
                loadScript(tableScriptUrl);
            });

            Livewire.on('editModal', (event) => {
                loadScript(tableScriptUrl);
            });

            Livewire.on('saveModal', (event) => {
                loadScript(tableScriptUrl, function() {
                    if (event.status === 'success' || event.status === 'warning') {
                        alertSwift(event.status, event.position, event.message);
                    }
                });
            });

            Livewire.on('destroyModal', (event) => {
                loadScript(tableScriptUrl, function() {
                    alertSwift(event.status, event.position, event.message);
                    $(event.modal).modal('hide');
                });
            });

            Livewire.on('updateModal', (event) => {
                loadScript(tableScriptUrl, function() {
                    alertSwift(event.status, event.position, event.message);
                });
            });

            Livewire.on('messageModal', (event) => {
                loadScript(tableScriptUrl, function() {
                    alertSwift(event.status, event.position, event.message);
                });
            });

            function loadScript(url, callback) {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = url;

                script.onload = function() {
                    if (callback) callback();
                };
                document.body.appendChild(script);
            }
        });
    </script>


    <script>
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        });
    </script>
    @livewireScripts
</body>

</html>
