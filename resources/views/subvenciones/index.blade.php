<x-app title="Subvenciones">

    <x-header />
    <!-- Primer encabezado -->
    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">
                Subvenciones
                <a class="btn mb-1 font-weight-bold btn-app float-end" id="btnModal">
                    <i class="fa-solid fa-plus"></i> Agregar subvención
                </a>
            </h5>

            <!-- Buscador -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; z-index: 10;"></i>
                        <input type="text" class="form-control ps-5" id="buscadorSubvenciones" 
                               placeholder="Buscar en subvenciones (RUT, organización, decreto, destino, monto...)" 
                               autocomplete="off" style="padding-left: 45px;">
                    </div>
                </div>
            </div>

            <!-- Tabla con datos -->
            <div class="table-responsive">
                <table class="table table-striped mx-auto" id="table_id">
                    <thead>
                        <tr>
                            <th class="text-center fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                #
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Fecha
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                R.U.T
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Organización
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Decreto
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Monto
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Destino
                            </th>
                            <th class="text-center fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subvenciones as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->fecha_asignacion ? \Carbon\Carbon::parse($item->fecha_asignacion)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->rut }}</td>
                                <td>{{ $item->organizacion }}</td>
                                <td>{{ $item->decreto }}</td>
                                <td>${{ number_format($item->monto, 0, ',', '.') }}</td>
                                <td>{{ $item->destino }}</td>
                                <td class="text-center" style="white-space: nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                        <!-- Ver detalles -->
                                        <button class="btn btn-accion" data-bs-target="#modalVerDetalles"
                                            data-bs-toggle="modal" title="Ver detalles" type="button">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                        <!-- Editar -->
                                        <button class="btn btn-succes btn-accion" 
                                            title="Editar" type="button" 
                                            onclick="abrirModalEditar({{ $item->id }})">
                                            <i class="fas fa-file-signature"> </i>
                                        </button>
                                        <!-- Rendir subvención -->
                                        <button class="btn btn-success btn-accion"
                                            data-bs-target="#modalRendirsubvencion" data-bs-toggle="modal"
                                            title="Rendir subvención" type="button">
                                            <i class="fas fa-clipboard-check icon-static-blue"></i>
                                        </button>
                                        <!-- Eliminar -->
                                        <button class="btn btn-success btn-accion btn-eliminar-subvencion" 
                                            title="Eliminar" type="button" data-subvencion-id="{{ $item->id }}">
                                            <i class="fas fa-times-circle"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">No hay subvenciones</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            
            <!-- Modal Ver Detalles -->
            <x-subvenciones.modal-ver-detalles />
        </div>

        <!-- Modal Editar -->
        <x-subvenciones.modal-editar />
        <!-- Modal Rendir Subvención -->
        <x-subvenciones.modal-rendir />
    </div>
    <!-- Modal Agregar Subvención -->
    <x-subvenciones.modal-agregar />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('show.bs.modal', function(e) {

            const idsQueMuevo = ['modalRendirsubvencion'];

            if (idsQueMuevo.includes(e.target.id)) {

                if (e.target.parentElement !== document.body) {
                    document.body.appendChild(e.target);
                }
            }
        });
    </script>

    <script src="{{ asset('js/subvenciones.js') }}" defer></script>

    <script>
        // Funcionalidad del buscador
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscadorSubvenciones');
            const tabla = document.getElementById('table_id');
            const filas = tabla.querySelectorAll('tbody tr');

            // Función para filtrar filas
            function filtrarFilas(termino) {
                const terminoLower = termino.toLowerCase();
                
                filas.forEach(fila => {
                    const celdas = fila.querySelectorAll('td');
                    let coincide = false;
                    
                    // Buscar en todas las celdas excepto la última (opciones)
                    for (let i = 0; i < celdas.length - 1; i++) {
                        const texto = celdas[i].textContent.toLowerCase();
                        if (texto.includes(terminoLower)) {
                            coincide = true;
                            break;
                        }
                    }
                    
                    // Mostrar u ocultar fila
                    fila.style.display = coincide ? '' : 'none';
                });
            }

            // Evento de búsqueda en tiempo real
            buscador.addEventListener('input', function() {
                const termino = this.value.trim();
                filtrarFilas(termino);
            });

            // Limpiar búsqueda con Escape
            buscador.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    filtrarFilas('');
                }
            });
        });

        // Funcionalidad para eliminar subvenciones
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-eliminar-subvencion')) {
                const button = e.target.closest('.btn-eliminar-subvencion');
                const subvencionId = button.getAttribute('data-subvencion-id');
                
                // Mostrar SweetAlert de confirmación
                Swal.fire({
                    title: '¿Eliminar subvención?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarSubvencion(subvencionId);
                    }
                });
            }
        });

        // Función para eliminar subvención
        function eliminarSubvencion(id) {
            // Mostrar SweetAlert de carga
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espere',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar petición AJAX
            fetch('{{ route("subvenciones.eliminar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                   document.querySelector('input[name="_token"]')?.value
                },
                body: JSON.stringify({
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Recargar la página para actualizar la tabla
                        window.location.reload();
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar la subvención',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }


        /*
                          var table;
                          var modalElement = document.getElementById("modalForm");
                          var modal = modalElement ? new bootstrap.Modal(modalElement) : null;

                          document
                            .querySelector("#btnModal")
                            ?.addEventListener("click", function () {
                              modal.show();
                            });

                          document
                            .querySelector("#table_id")
                            ?.addEventListener("click", function (e) {
                              if (e.target && e.target.matches("i.fa-pen-square")) {
                                modal.show();
                              }
                            });  */
    </script>
    <div class="row fixed-bottom bg-light" style="border-top: 1px solid #eee">
        <div class="col-md-12">

        </div>
    </div>






















    <x-footer />


</x-app>
