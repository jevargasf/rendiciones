<header>
    <nav class="navbar navbar-expand-lg bg-app" style="background-color: var(--app-color);">
        <div class="container">
            <!-- brand -->
            <div class="navbar-header">
                <a class="navbar-brand text-brand" href="{{ route('estadisticas') }}">
                    <i class="fa-solid fa-seedling"></i>
                    PACCC
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('estadisticas') }}">Inicio</a>
                    </li>

                   
                </ul>
                <!-- Menú desplegable del perfil -->
                <ul
                    class="navbar-nav ms-auto d-flex flex-column-reverse align-items-start flex-md-row md:align-items-center">
                    @if (Session::get('perfiles'))
                        <li class="nav-item dropdown" style="position: relative;">
                            <a class="nav-link" href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user" style="font-size: 16px !important;"></i>
                            </a>
                            <ul class="dropdown-menu nav-profile" aria-labelledby="profileDropdown">
                                <li class="px-3 py-2">
                                    <span class="d-block user-name">{{ Session::get('usuario.nombres') }}
                                        {{ Session::get('usuario.apellido_paterno') }}
                                        {{ Session::get('usuario.apellido_materno') }}</span>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="post" action="{{ route('perfiles') }}">
                                        @csrf
                                        <button type="submit" name="btnSeleccionarPerfiles"
                                            class="dropdown-item d-flex align-items-center">
                                            <i class="fas fa-exchange-alt me-2"></i> Seleccionar perfil
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <!-- Icono de logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logoutButton">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutButton = document.getElementById('logoutButton');
            logoutButton.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Desea salir de la aplicación?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('logout') }}";
                    }
                });
            });
        });
    </script>
</header>
