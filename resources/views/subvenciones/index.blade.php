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
                                Fecha asignación
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
                                Destino
                            </th>
                            <th class="text-center fw-normal">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subvenciones as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->fecha_asignacion ? \Carbon\Carbon::parse($item->fecha_asignacion)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->rut_formateado }}</td>
                                <td>{{ $item->nombre_organizacion }}</td>
                                <td>{{ $item->decreto }}</td>
                                <td>${{ number_format($item->monto, 0, ',', '.') }}</td>
                                <td>{{ $item->destino }}</td>
                                <td class="text-center" style="white-space: nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                        <!-- Ver detalles -->
                                        <button class="btn btn-accion" data-bs-target="#modalVerDetalles"
                                            onclick="verDetalleSubvencion({{ $item->id }})"
                                            data-bs-toggle="modal" title="Ver detalles" type="button">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                        <!-- Editar -->
                                        <button class="btn btn-success btn-accion" 
                                            title="Editar" type="button" 
                                            onclick="abrirModalEditar({{ $item->id }})">
                                            <i class="fas fa-file-signature"> </i>
                                        </button>
                                        <!-- Rendir subvención -->
                                        <button class="btn btn-success btn-accion"
                                            onclick="abrirModalRendir({{ $item->id }})"
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
        <!-- Modal Eliminar Subvención -->
        <x-subvenciones.modal-eliminar />
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
        // Funcionalidad del buscador y ordenamiento
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscadorSubvenciones');
            const tabla = document.getElementById('table_id');
            const filas = tabla.querySelectorAll('tbody tr');
            const headers = tabla.querySelectorAll('thead th');
            
            // Variables para el ordenamiento
            let ordenActual = {};
            let filasOriginales = Array.from(filas);

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

            // Función para ordenar la tabla
            function ordenarTabla(columna, direccion) {
                const tbody = tabla.querySelector('tbody');
                const filasArray = Array.from(filas).filter(fila => fila.style.display !== 'none');
                
                filasArray.sort((a, b) => {
                    const valorA = a.cells[columna].textContent.trim();
                    const valorB = b.cells[columna].textContent.trim();
                    
                    // Manejar diferentes tipos de datos
                    let comparacion = 0;
                    
                    if (columna === 0) { // Columna # (números)
                        comparacion = parseInt(valorA) - parseInt(valorB);
                    } else if (columna === 1) { // Fecha
                        const fechaA = new Date(valorA.split('/').reverse().join('-'));
                        const fechaB = new Date(valorB.split('/').reverse().join('-'));
                        comparacion = fechaA - fechaB;
                    } else if (columna === 5) { // Monto
                        const montoA = parseFloat(valorA.replace(/[^0-9]/g, ''));
                        const montoB = parseFloat(valorB.replace(/[^0-9]/g, ''));
                        comparacion = montoA - montoB;
                    } else { // Texto
                        comparacion = valorA.localeCompare(valorB, 'es', { numeric: true });
                    }
                    
                    return direccion === 'asc' ? comparacion : -comparacion;
                });
                
                // Reorganizar las filas en el DOM
                filasArray.forEach(fila => tbody.appendChild(fila));
                
                // Actualizar numeración secuencial
                actualizarNumeracion();
            }

            // Función para actualizar la numeración secuencial
            function actualizarNumeracion() {
                const filasVisibles = Array.from(filas).filter(fila => fila.style.display !== 'none');
                filasVisibles.forEach((fila, index) => {
                    fila.cells[0].textContent = index + 1;
                });
            }

            // Función para actualizar iconos de ordenamiento
            function actualizarIconos(columna, direccion) {
                headers.forEach((header, index) => {
                    const icono = header.querySelector('i.fas');
                    if (icono) {
                        if (index === columna) {
                            icono.className = direccion === 'asc' ? 'fas fa-sort-up me-1' : 'fas fa-sort-down me-1';
                        } else {
                            icono.className = 'fas fa-sort me-1';
                        }
                    }
                });
            }

            // Agregar event listeners a los headers (excepto Destino y Opciones)
            headers.forEach((header, index) => {
                // No agregar ordenamiento a Destino (índice 6) y Opciones (índice 7)
                if (index < 6) {
                    header.style.cursor = 'pointer';
                    header.addEventListener('click', function() {
                        const direccion = ordenActual[index] === 'asc' ? 'desc' : 'asc';
                        ordenActual = { [index]: direccion };
                        ordenarTabla(index, direccion);
                        actualizarIconos(index, direccion);
                    });
                }
            });

            // Evento de búsqueda en tiempo real
            buscador.addEventListener('input', function() {
                const termino = this.value.trim();
                filtrarFilas(termino);
                actualizarNumeracion();
            });

            // Limpiar búsqueda con Escape
            buscador.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    filtrarFilas('');
                    actualizarNumeracion();
                }
            });
        });

        // Funcionalidad para eliminar subvenciones
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-eliminar-subvencion')) {
                const button = e.target.closest('.btn-eliminar-subvencion');
                const subvencionId = button.getAttribute('data-subvencion-id');
                
                // Obtener datos de la subvención desde la fila
                const fila = button.closest('tr');
                const celdas = fila.querySelectorAll('td');
                
                // Llenar el modal con los datos de la subvención
                document.getElementById('advertencia_eliminar').innerHTML = `Al eliminar esta subvención, se eliminarán <strong>TODAS las subvenciones</strong> asociadas al decreto <strong>${celdas[4].textContent}</strong>. Esta acción no se puede deshacer.`
                document.getElementById('eliminarSubvencionId').textContent = celdas[0].textContent;
                document.getElementById('eliminarSubvencionRut').textContent = celdas[2].textContent;
                document.getElementById('eliminarSubvencionOrganizacion').textContent = celdas[3].textContent;
                document.getElementById('eliminarSubvencionDecreto').textContent = celdas[4].textContent;
                document.getElementById('eliminarSubvencionMonto').textContent = celdas[5].textContent;
                document.getElementById('eliminarSubvencionDestino').textContent = celdas[6].textContent;
                document.getElementById('confirmarDecreto').textContent = celdas[4].textContent;
                
                // Limpiar campos del modal
                document.getElementById('motivoEliminacion').value = '';
                document.getElementById('confirmarEliminacion').checked = false;
                document.getElementById('btnConfirmarEliminacion').disabled = true;
                
                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalEliminarSubvencion'));
                modal.show();
                
                // Guardar el ID para usar después
                document.getElementById('btnConfirmarEliminacion').setAttribute('data-subvencion-id', subvencionId);
            }
        });

        // Funcionalidad para habilitar/deshabilitar botón de confirmación
        document.addEventListener('input', function(e) {
            if (e.target.id === 'motivoEliminacion' || e.target.id === 'confirmarEliminacion') {
                const motivo = document.getElementById('motivoEliminacion').value.trim();
                const confirmado = document.getElementById('confirmarEliminacion').checked;
                const btnConfirmar = document.getElementById('btnConfirmarEliminacion');
                
                btnConfirmar.disabled = !(motivo.length > 0 && confirmado);
            }
        });

        // Funcionalidad para el botón de confirmación de eliminación
        document.addEventListener('click', function(e) {
            if (e.target.id === 'btnConfirmarEliminacion') {
                const subvencionId = e.target.getAttribute('data-subvencion-id');
                const motivo = document.getElementById('motivoEliminacion').value.trim();
                
                if (subvencionId && motivo) {
                    eliminarSubvencion(subvencionId, motivo);
                }
            }
        });

        // Función para eliminar subvención
        function eliminarSubvencion(id, motivo) {
            // Cerrar el modal primero
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarSubvencion'));
            modal.hide();
            
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
                    id: id,
                    motivo: motivo
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
