<x-app title="Login">
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])

    @if (session('error'))
        <script>
            function mostrarMensaje() {
                Swal.fire({
                    title: 'Error',
                    text: {!! json_encode(session('error')) !!},
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#7066e0',
                })
            }
            window.addEventListener('load', mostrarMensaje);
        </script>
    @endif

    <div class="d-flex vh-100">
        <div class="col-lg-3 col-md-offset-2 col-xl-offset-3 col-sm-12 mt-mb-auto">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7">
                        <img src="{{ asset('img/auth/logo.png') }}" class="d-inline-block" alt="Logo" width="100%">
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}" id="login" autocomplete="off">
                    @csrf
                    <div class="row justify-content-center">
                        <h6 class="text-center mb-5">Gestión KM</h6>

                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9 mb-2">
                            <label class="mb-2">Ingrese su RUN</label>
                            <input class="form-control  mb-2" type="text" name="acceso_rut" id="acceso_rut"
                                value="" autocomplete="off" placeholder="Ej: 12.345.678-9" autofocus>
                            <label class="mb-2">Ingrese su contraseña</label>
                            <input class="form-control mb-4" name="acceso_clave" id="acceso_clave" type="password">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-ptb">Ingresar al sistema</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="img-lateral col-md-9 d-none d-md-block"></div>
    </div>
</x-app>
