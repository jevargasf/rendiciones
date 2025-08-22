<x-app title="Usuarios">
    @vite(['resources/css/app.css'])

    <style>
        .input-group-text {
            font-size: 14px;
        }
    </style>

    <x-header />

    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">Usuarios</h5>
            <div class="table-responsive">
                <table id="table_id" class="table table-striped mx-auto">
                    <thead>
                        <tr>
                            <th class="td-5 text-center">#</th>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th class="td-5 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $item)
                            <tr>
                                <td class="td-5"> {{ $item->id }} </td>
                                <td> {{ $item->nombres . ' ' . $item->apellido_paterno . ' ' . $item->apellido_materno }}
                                </td>
                                <td> {{ $item->email }} </td>
                                <td> {{ $item->telefono }} </td>
                                <td class="td-5">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button class="btn-accion me-1 view-user" data-id="{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-accion edit-user" data-id="{{ $item->id }}">
                                            <i class="fas fa-pen-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="editarModalLabel"><i class="fa-solid fa-file-lines me-2"></i>
                        Editar Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <form id="editUserForm">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" id="usuario_id" name="usuario_id">

                        <div class="container">
                            <div id="contenidoModal" class="p-4 rounded">

                                <div class="mb-3">
                                    <label for="run" class="form-label required fw-bold">RUN</label>
                                    <input type="text" class="form-control" id="run" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="nombres" class="form-label required fw-bold">Nombre completo</label>
                                    <input type="text" class="form-control" id="nombres" readonly>
                                </div>

                                <label class="form-label required fw-bold">
                                    Unidad
                                </label>
                                <div id="unidad-container">
                                    <div class="input-group mb-2">
                                        <select class="form-control" name="fk_unidad_id" id="fk_unidad_id">
                                            <option value="" disabled selected>Seleccione...</option>
                                            @foreach ($unidades as $unidad)
                                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill"
                            data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left me-2"></i>Cerrar</button>
                        <button type="submit" class="btn btn-app px-4 py-2 rounded-pill">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Editar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detallesUsuarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="detallesUsuarioModalLabel"><i class="fa-solid fa-user me-2"></i>
                        Detalles Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="container">
                        <div id="contenidoDetalles" class="p-4 border rounded bg-light shadow-sm">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">ID</th>
                                        <td id="detalle_id"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">RUN</th>
                                        <td id="detalle_run"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nombres</th>
                                        <td id="detalle_nombres"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Apellido Paterno</th>
                                        <td id="detalle_apellido_paterno"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Apellido Materno</th>
                                        <td id="detalle_apellido_materno"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Teléfono</th>
                                        <td id="detalle_telefono"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Correo Electrónico</th>
                                        <td id="detalle_email"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Unidad</th>
                                        <td id="detalle_unidad"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Perfil KM</th>
                                        <td id="detalle_perfil_km"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-start p-3 border-top bg-light">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill"
                        data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left me-2"></i>Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.edit-user').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    if (!userId) return;

                    fetch(`${window.apiBaseUrl}usuarios/detalles/${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }

                            document.getElementById('usuario_id').value = data.id;
                            document.getElementById('run').value = data.run;

                            document.getElementById('nombres').value = data.nombres + ' ' + data
                                .apellido_paterno + ' ' + data.apellido_materno;

                            document.getElementById('fk_unidad_id').value = data.fk_unidad_id;

                            const editarModal = new bootstrap.Modal(document.getElementById(
                                'editarModal'));
                            editarModal.show();
                        })
                        .catch(error => {
                            console.error('Error al obtener el usuario:', error);
                            alert('Ocurrió un error al cargar los datos del usuario.');
                        });
                });
            });

        });

        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const userId = document.getElementById('usuario_id').value;
            const formData = new FormData(this);

            fetch(window.apiBaseUrl + `usuarios/actualizar/${userId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $("#editar").modal("hide");
                        Swal.fire({
                            title: "Éxito",
                            text: "Usuario editado exitosamente.",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                            customClass: {
                                confirmButton: "swal-success",
                            },
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        alert('Error al actualizar el usuario');
                    }
                })
                .catch(error => console.error('Error al actualizar el usuario:', error));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const modal = new bootstrap.Modal(document.getElementById('detallesUsuarioModal'));

            document.querySelectorAll('.view-user').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    if (!userId) return;

                    fetch(`${window.apiBaseUrl}usuarios/detalles/${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }

                            const set = (id, value) => {
                                const el = document.getElementById(id);
                                if (!el) return;
                                if (value) {
                                    el.textContent = value;
                                    el.classList.remove('text-muted');
                                } else {
                                    el.textContent = 'No disponible';
                                    el.classList.add('text-muted');
                                }
                            };

                            set('detalle_id', data.id);
                            set('detalle_run', data.run);
                            set('detalle_nombres', data.nombres);
                            set('detalle_apellido_paterno', data.apellido_paterno);
                            set('detalle_apellido_materno', data.apellido_materno);
                            set('detalle_telefono', data.telefono);
                            set('detalle_email', data.email);
                            set('detalle_unidad', data.unidad);
                            set('detalle_perfil_km', data.id_perfil_km);

                            modal.show();
                        })
                        .catch(error => {
                            console.error('Error al obtener detalles del usuario:', error);
                            alert('No se pudieron cargar los detalles.');
                        });
                });
            });
        });
    </script>

    <x-footer />

</x-app>
