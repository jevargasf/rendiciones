<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ $title ? $title . ' | app' : 'Defecto' }}
    </title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.12/lottie.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- BOOTSTRAP 5.3 -->
    <link href="https://cdn.rancagua.cl/assets/bootstrap/5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert -->
    <link href="https://cdn.rancagua.cl/assets/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdn.rancagua.cl/assets/fontawesome-6.4.0/css/fontawesome.min.css" rel="stylesheet">
    <link href="https://cdn.rancagua.cl/assets/fontawesome-6.4.0/css/all.min.css" rel="stylesheet">

    <!-- datatables -->
    <link href="https://cdn.rancagua.cl/assets/datatables/DataTables-1.13.4/css/dataTables.bootstrap5.min.css"
        rel="stylesheet">
    <link href="https://cdn.rancagua.cl/assets/datatables/Buttons-2.3.6/css/buttons.bootstrap5.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/chosen.jquery.js') }}" defer></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}">

</head>

<body>

  

    {{ $slot }}

    <script>
        @if ($errors->any())
            function mostrarMensajeError() {
                Swal.fire({
                    title: 'Error',
                    text: {!! json_encode($errors->first()) !!},
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#7066e0',
                    customClass: {
                        confirmButton: 'swal-warning'
                    }
                })
            }
            window.addEventListener('load', mostrarMensajeError);
        @endif

        @if (session('success'))
            function mostrarMensajeExito() {
                Swal.fire({
                    title: 'Éxito',
                    text: {!! json_encode(session('success')) !!},
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#7066e0',
                    customClass: {
                        confirmButton: 'swal-success'
                    }
                })
            }
            window.addEventListener('load', mostrarMensajeExito);
        @endif

        @if (session('warning'))
            function mostrarMensajeExito() {
                Swal.fire({
                    title: 'Éxito',
                    text: {!! json_encode(session('warning')) !!},
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#7066e0',
                    customClass: {
                        confirmButton: 'swal-warning'
                    }
                })
            }
            window.addEventListener('load', mostrarMensajeExito);
        @endif

        @if (session('error'))
            function mostrarMensajeError() {
                Swal.fire({
                    title: 'Error',
                    text: {!! json_encode(session('error')) !!},
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#7066e0',
                    customClass: {
                        confirmButton: 'swal-warning'
                    }
                })
            }
            window.addEventListener('load', mostrarMensajeError);
        @endif

        @if (session('info'))
            function mostrarMensajeInfo() {
                Swal.fire({
                    title: 'Información',
                    text: {!! json_encode(session('info')) !!},
                    icon: 'info',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#7066e0',
                    customClass: {
                        confirmButton: 'swal-info'
                    }
                })
            }
            window.addEventListener('load', mostrarMensajeInfo);
        @endif

        $(document).ready(function() {
            $('.chosen-select').chosen({
                width: '100%'
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SCRIPT BOOTSTRAP 5.3 -->
    <script src="https://cdn.rancagua.cl/assets/bootstrap/5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sweetalert2 -->
    <script src="https://cdn.rancagua.cl/assets/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- Fontawesome -->
    <script src="https://cdn.rancagua.cl/assets/fontawesome-6.4.0/js/fontawesome.min.js"></script>

    <!-- datatables -->
    <script src="https://cdn.rancagua.cl/assets/datatables/JSZip-2.5.0/jszip.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/pdfmake-0.2.7/pdfmake.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/pdfmake-0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/DataTables-1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/DataTables-1.13.4/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/Buttons-2.3.6/js/dataTables.buttons.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/Buttons-2.3.6/js/buttons.bootstrap5.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/Buttons-2.3.6/js/buttons.html5.js"></script>
    <script src="https://cdn.rancagua.cl/assets/datatables/Buttons-2.3.6/js/buttons.print.js"></script>

</body>

</html>
