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
                        Rendidas
                    </button>

                    <button class="nav-link" id="nav-pendientes-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-pendientes" type="button" role="tab" aria-controls="nav-pendientes"
                        aria-selected="false">
                        Pendientes
                    </button>

                    <button class="nav-link" id="nav-observadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-observadas" type="button" role="tab" aria-controls="nav-observadas"
                        aria-selected="false">
                        Observadas
                    </button>

                    <button class="nav-link" id="nav-rechazadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-rechazadas" type="button" role="tab" aria-controls="nav-rechazadas"
                        aria-selected="false">
                        Rechazadas
                    </button>
                </div>
            </nav>

            <!-- Tabla de contenidos -->
            <div class="tab-content" id="nav-tabContent">
                <!-- RENDIDAS -->
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
                        <i class="fas fa-sort me-1"></i> Opciones
                    </th>
                                </tr>
                            </thead> 
                            <tbody>
                                @forelse ($rendiciones as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->organizacion }}</td>
                                        <td>{{ $item->subvencion->decreto }}</td>
                                        <td>865501</td>
                                        <td class="monto" data-valor="{{ $item->subvencion->monto }}">${{ number_format($item->subvencion->monto, 0, ',', '.') }}</td>
                                        <td class="td-5">

                                        <!-- REVISAR ACÁ LA FUNCIONALIDAD DEL BOTÓN VER DETALLE -->
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        data-subvencion="{{ $item->subvencion_id }}"
                                                
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
                                                <p class="mb-0">No hay rendiciones rendidas</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PESTAÑA PENDIENTES -->
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
                        <i class="fas fa-sort me-1"></i> Opciones
                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendientes as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->organizacion }}</td>
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
                                                <p class="mb-0">No hay rendiciones pendientes</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- OBSERVADAS -->
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
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($observadas as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->organizacion }}</td>
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
                                                <p class="mb-0">No hay rendiciones observadas</p>
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
                                    <th class="fw-normal"><i class="fas fa-sort me-1"></i> Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rechazadas as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->subvencion->rut_formateado }}</td>
                                        <td>{{ $item->subvencion->organizacion }}</td>
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

        // Funcionalidad del buscador para rendiciones
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscadorRendiciones');
            
            // IDs de todas las tablas de rendiciones
            const tablasIds = ['table_id', 'table_pendientes', 'table_observadas', 'table_rechazadas'];
            
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
            }

            // Función para filtrar todas las tablas
            function filtrarTodasLasTablas(termino) {
                tablasIds.forEach(tablaId => {
                    filtrarFilasEnTabla(tablaId, termino);
                });
            }

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
