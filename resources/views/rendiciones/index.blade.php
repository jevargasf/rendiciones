<x-app title="Rendiciones">
    <x-header />


    <!-- Encabezado principal -->
    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">
                Rendiciones
            </h5>

            <!-- Buscador -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; z-index: 10;"></i>
                        <input type="text" class="form-control ps-5" id="buscadorRendiciones" 
                               placeholder="Buscar en rendiciones (RUT, organización, decreto, monto...)" 
                               autocomplete="off" style="padding-left: 45px;">
                    </div>
                </div>
            </div>

            <!-- Tablas -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-rendidas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-rendidas" type="button" role="tab" aria-controls="nav-rendidas"
                        aria-selected="true">
                        En revisión
                    </button>

                    <button class="nav-link" id="nav-pendientes-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-pendientes" type="button" role="tab" aria-controls="nav-pendientes"
                        aria-selected="false">
                        Objetada
                    </button>

                    <button class="nav-link" id="nav-observadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-observadas" type="button" role="tab" aria-controls="nav-observadas"
                        aria-selected="false">
                        Aprobada
                    </button>

                    <button class="nav-link" id="nav-rechazadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-rechazadas" type="button" role="tab" aria-controls="nav-rechazadas"
                        aria-selected="false">
                        Rechazada
                    </button>
                </div>
            </nav>

            <!-- Tabla de contenidos -->
            <div class="tab-content" id="nav-tabContent">
                <!-- EN REVISIÓN -->
                <div class="tab-pane fade show active" id="nav-rendidas" role="tabpanel"
                    aria-labelledby="nav-rendidas-tab" tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_id" class="table table-striped mx-auto">  <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_id")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                                        <th class="text-center fw-normal">
                        <i class="fas fa-sort me-1"></i> #
                    </th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Monto</th>
                                                        <th class="text-center fw-normal">
                        Opciones
                    </th>
                                </tr>
                            </thead> 
                            <tbody>
                                @forelse ($rendiciones as $index => $item)
                                    <tr>
                                        <td class="td-5">{{ $index + 1 }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->nombre_organizacion }}</td>
                                        <td>{{ $item->subvencion->decreto }}</td>
                                        <td>865501</td>
                                        <td class="monto" data-valor="{{ $item->subvencion->monto }}">${{ number_format($item->subvencion->monto, 0, ',', '.') }}</td>
                                        <td class="td-5">

                                        <!-- REVISAR ACÁ LA FUNCIONALIDAD DEL BOTÓN VER DETALLE -->
                                            <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        data-subvencion="{{ $item->subvencion_id }}"
                                                
                                                        {{-- Guarda el ID del registro para usarlo en JavaScript --}}></i>
                                                </button>
                                                <!-- Eliminar -->
                                                <button class="btn btn-danger btn-accion btn-eliminar-rendicion" 
                                                    title="Eliminar" type="button" data-rendicion-id="{{ $item->id }}">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p class="mb-0">No hay rendiciones en revisión</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PESTAÑA OBJETADAS -->
                <div class="tab-pane fade" id="nav-pendientes" role="tabpanel" aria-labelledby="nav-pendientes-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_pendientes" class="table table-striped mx-auto">
                            <thead>
                                <tr>
                                                        <th class="text-center fw-normal">
                        <i class="fas fa-sort me-1"></i> #
                    </th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Monto</th>
                                                        <th class="text-center fw-normal">
                        Opciones
                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendientes as $index => $item)
                                    <tr>
                                        <td class="td-5">{{ $index + 1 }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->nombre_organizacion }}</td>
                                        <td>{{ $item->subvencion->decreto }}</td>
                                        <td>346544</td>
                                        <td class="monto" data-valor="{{ $item->subvencion->monto }}">${{ number_format($item->subvencion->monto, 0, ',', '.') }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        {{-- Guarda el ID del registro para usarlo en JavaScript --}}></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p class="mb-0">No hay rendiciones objetadas</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- APROBADAS -->
                <div class="tab-pane fade" id="nav-observadas" role="tabpanel" aria-labelledby="nav-observadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_observadas" class="table table-striped mx-auto"> <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_observadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i>#
                                    </th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Monto</th>
                                    <th class="fw-normal">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($observadas as $index => $item)
                                    <tr>
                                        <td class="td-5">{{ $index + 1 }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->nombre_organizacion }}</td>
                                        <td>{{ $item->subvencion->decreto }}</td>
                                        <td>346544</td>
                                        <td class="monto" data-valor="{{ $item->subvencion->monto }}">${{ number_format($item->subvencion->monto, 0, ',', '.') }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        {{-- Guarda el ID del registro para usarlo en JavaScript --}}></i>
                                                </button>
                                                <!--    <button type="button" class="btn btn-accion btn-link align-baseline"
                                                    data-bs-toggle="modal" data-bs-target="#modalVer">
                                                    <i class="bi bi-search"></i>
                                                </button> Antiguo boton  -->

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p class="mb-0">No hay rendiciones aprobadas</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--Pestaña Tabla Rechazadas-->

                <div class="tab-pane fade" id="nav-rechazadas" role="tabpanel" aria-labelledby="nav-rechazadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_rechazadas" class="table table-striped mx-auto"> <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i>#
                                    </th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Monto</th>
                                    <th class="fw-normal">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rechazadas as $index => $item)
                                    <tr>
                                        <td class="td-5">{{ $index + 1 }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->nombre_organizacion }}</td>
                                        <td>{{ $item->subvencion->decreto }}</td>
                                        <td>346544</td>
                                        <td class="monto" data-valor="{{ $item->subvencion->monto }}">${{ number_format($item->subvencion->monto, 0, ',', '.') }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p class="mb-0">No hay rendiciones rechazadas</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /Encabezado principal -->

    <!-- Modal Ver Detalles de Rendición -->
    <x-rendiciones.modal-ver-detalles />

    <!-- Modal Eliminar Rendición -->
    <div class="modal fade" id="modalEliminarRendicion" tabindex="-1" aria-labelledby="modalEliminarRendicionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="modalEliminarRendicionLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Eliminar Rendición
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Advertencia:</strong> Esta acción eliminará la rendición y devolverá la subvención al estado inicial.
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold mb-3">Datos de la Rendición:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Número:</strong> <span id="eliminarRendicionNumero">-</span></p>
                                <p><strong>RUT:</strong> <span id="eliminarRendicionRut">-</span></p>
                                <p><strong>Organización:</strong> <span id="eliminarRendicionOrganizacion">-</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Decreto:</strong> <span id="eliminarRendicionDecreto">-</span></p>
                                <p><strong>Monto:</strong> <span id="eliminarRendicionMonto">-</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmarEliminacionRendicion" class="form-label fw-bold">
                            <input type="checkbox" class="form-check-input me-2" id="confirmarEliminacionRendicion">
                            Confirmo que deseo eliminar esta rendición
                        </label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
                        <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-danger px-4 py-2 rounded-pill" id="btnConfirmarEliminacionRendicion" disabled>
                        <i class="fas fa-times-circle me-2"></i>Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>







    <!-- Modal Formulario -->
    <div class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="modalFormTitulo">Cargando...</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="form">
                    <div class="modal-body p-4">
                        <div class="container">
                            <div class="p-4 rounded">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label required fw-bold">Título</label>
                                    <input type="text" class="form-control shadow-sm" id="titulo"
                                        name="titulo" required placeholder="Ej: Educación Rancagua empoderado..." />
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label required fw-bold">Descripción</label>
                                    <textarea class="form-control shadow-sm" id="descripcion" name="descripcion" rows="8" required
                                        placeholder="Ej: Potenciar y fomentar la educación ambiental..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill"
                            data-bs-dismiss="modal">
                            <i class="fa-solid fa-arrow-left me-2"></i>Cerrar
                        </button>
                        <button type="submit" class="btn btn-app px-4 py-2 rounded-pill shadow-sm"
                            id="btnForm">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal Formulario -->

    <!-- Footer -->
    <div class="row fixed-bottom bg-light" style="border-top: 1px solid #eee">
        <div class="col-md-12">
            <footer class="footer" style="padding: 10px !important; margin: 0px !important; font-size: 14px">
                <p class="text-center" style="margin: 0px !important; font-size: 13px; color: #666">
                    Departamento de Computación e Informática -
                    <a style="color: #333" target="_blank" href="http://www.rancagua.cl">Ilustre Municipalidad de
                        Rancagua</a>
                </p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/rendiciones.js') }}" defer></script> <!-- se llama el script relacionado con la página -->

    <!-- Aquí se eliminaron todos los scripts relacionados con funciones de JavaScript estáticas,(no había archivo antes de JS)
     ya que ahora se va a usar el archivo script src="asset('js/rendiciones.js'" defer></script. -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

        // Funcionalidad del buscador y ordenamiento para rendiciones
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscadorRendiciones');
            
            // IDs de todas las tablas de rendiciones
            const tablasIds = ['table_id', 'table_pendientes', 'table_observadas', 'table_rechazadas'];
            
            // Variables para el ordenamiento de cada tabla
            let ordenActual = {};
            
            // Función global para actualizar numeración en una tabla específica
            function actualizarNumeracion(tablaId) {
                const tabla = document.getElementById(tablaId);
                if (!tabla) return;
                const filasVisibles = Array.from(tabla.querySelectorAll('tbody tr')).filter(fila => fila.style.display !== 'none');
                filasVisibles.forEach((fila, index) => {
                    fila.cells[0].textContent = index + 1;
                });
            }
            
            // Función para inicializar ordenamiento en una tabla
            function inicializarOrdenamiento(tablaId) {
                const tabla = document.getElementById(tablaId);
                if (!tabla) return;
                
                const headers = tabla.querySelectorAll('thead th');
                
                // Función para ordenar una tabla específica
                function ordenarTabla(columna, direccion) {
                    const tbody = tabla.querySelector('tbody');
                    const filas = Array.from(tabla.querySelectorAll('tbody tr')).filter(fila => fila.style.display !== 'none');
                    
                    filas.sort((a, b) => {
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
                        } else if (columna === 6) { // Monto
                            const montoA = parseFloat(valorA.replace(/[^0-9]/g, ''));
                            const montoB = parseFloat(valorB.replace(/[^0-9]/g, ''));
                            comparacion = montoA - montoB;
                        } else { // Texto
                            comparacion = valorA.localeCompare(valorB, 'es', { numeric: true });
                        }
                        
                        return direccion === 'asc' ? comparacion : -comparacion;
                    });
                    
                    // Reorganizar las filas en el DOM
                    filas.forEach(fila => tbody.appendChild(fila));
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

                // Agregar event listeners a los headers (excepto Opciones)
                headers.forEach((header, index) => {
                    // No agregar ordenamiento a Opciones (última columna)
                    if (index < headers.length - 1) {
                        header.style.cursor = 'pointer';
                        header.addEventListener('click', function() {
                            const direccion = ordenActual[tablaId] && ordenActual[tablaId][index] === 'asc' ? 'desc' : 'asc';
                            ordenActual[tablaId] = { [index]: direccion };
                            ordenarTabla(index, direccion);
                            actualizarIconos(index, direccion);
                        });
                    }
                });
            }
            
            // Función para filtrar filas en una tabla específica
            function filtrarFilasEnTabla(tablaId, termino) {
                const tabla = document.getElementById(tablaId);
                if (!tabla) return;
                
                const filas = tabla.querySelectorAll('tbody tr');
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
                
                // No actualizar numeración después de filtrar - mantener numeración original
            }

            // Función para filtrar todas las tablas
            function filtrarTodasLasTablas(termino) {
                tablasIds.forEach(tablaId => {
                    filtrarFilasEnTabla(tablaId, termino);
                });
            }

            // Inicializar ordenamiento para todas las tablas
            tablasIds.forEach(tablaId => {
                inicializarOrdenamiento(tablaId);
            });

            // Evento de búsqueda en tiempo real
            buscador.addEventListener('input', function() {
                const termino = this.value.trim();
                filtrarTodasLasTablas(termino);
            });

            // Limpiar búsqueda con Escape
            buscador.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    filtrarTodasLasTablas('');
                }
            });
        });
    </script>

    <x-footer />
</x-app>
