<x-app title="Selección de perfil">

    <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">

        <div class="w-75">
            <div class="card-header text-center">
                <h3 class="text-center mb-2">Selección de Perfil</h3>
            </div>
            <div class="card-body">
                @if (!empty($alertas))
                    <div class="alert alert-danger" role="alert">
                        @foreach ($alertas as $alerta)
                            {{ $alerta }}<br>
                        @endforeach
                    </div>
                @endif

                @if (!empty($perfiles))
                    <form method="POST" action="{{ url('perfiles') }}" id="login" autocomplete="off">
                        @csrf
                        <input type="hidden" name="perfil" id="perfilSeleccionado" value="">
                        <input type="hidden" name="btnIngresar" value="1">
                        <div class="container px-0 my-5">
                            <div class="d-flex justify-content-center row g-4">
                                @foreach ($perfiles as $perfil)
                                    <div class="col-lg-3">
                                        <div class="card perfil-card text-center shadow-sm"
                                            onclick="seleccionarPerfil('{{ $perfil['perfil_id_km'] }}')">
                                            <div class="avatar mt-3">{{ substr($perfil['nombre_perfil'], 0, 1) }}</div>
                                            <div class="card-body">
                                                <h5>{{ $perfil['nombre_perfil'] }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="container col-12 col-lg-5">
                            <div class="d-flex justify-content-center text-end">
                                <a href="{{ config('app.auth') }}" class="btn btn-link mt-3" style="width: 70%">Volver
                                    Autenticación</a>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-warning text-center" style="width: 70%">No se encontraron perfiles.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .avatar {
            width: 80px;
            height: 80px;
            background-color: #d0ebff;
            color: #0d6efd;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            margin: 0 auto;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid #0d6efd;
        }

        .perfil-card {
            cursor: pointer;
        }

        .card.active {
            background-color: #e0e0e0;
            border: 1px solid #0d6efd;
            transform: scale(1.05) !important;
        }

        .active .avatar {
            background-color: #f0f0f0;
            color: #bdbbbb
        }

        .btn-link {
            text-decoration: none !important;
            color: #666 !important;
        }
    </style>

    <script>
        function seleccionarPerfil(perfilId) {
            document.getElementById('perfilSeleccionado').value = perfilId;

            document.getElementById('login').submit();
        }
    </script>

</x-app>
