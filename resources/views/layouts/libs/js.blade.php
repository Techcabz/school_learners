<script src="{{ asset('assets/node_modules/jssor.slider-28.1.0.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/jquery.validate.js') }}"></script>

<script src="{{ asset('assets/node_modules/alertify.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/jquery.redirect.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>

<script src="{{ asset('js/slider.js') }}"></script>
<script src="{{ asset('js/alertify.min.js') }}"></script>
<script type="module" src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/chart/memo-chart.js') }}"></script>
<script src="{{ asset('js/chart/chart-area.js') }}"></script>
<script src=" {{ asset('js/chart/chart-pie.js') }}"></script>
<script src="{{ asset('js/datatables/dataTable.js') }}"></script>
<script src="{{ asset('js/datatables/dataTable1.js') }}"></script>
<script type="text/javascript">
    let jssor_1 = document.getElementById('jssor_1');
    if (jssor_1) {
        jssor_1_slider_init();
    }
</script>

{{-- 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
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

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script> --}}

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
