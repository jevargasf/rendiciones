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
                        <i class="fas fa-search position-absolute"
                            style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; z-index: 10;"></i>
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
                        <table id="table_revision" class="table table-striped align-middle w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>RUT</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Destino</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- PESTAÑA PENDIENTES DATATABLE -->
                <div class="tab-pane fade" id="nav-pendientes" role="tabpanel" aria-labelledby="nav-pendientes-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_pendientes" class="table table-striped align-middle w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>R.U.T</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- OBSERVADAS DATATABLE-->
                <div class="tab-pane fade" id="nav-observadas" role="tabpanel" aria-labelledby="nav-observadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_observadas" class="table table-striped align-middle w-100">
                            <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_observadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>R.U.T</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!--Pestaña Tabla Rechazadas con DATATABLE-->

                <div class="tab-pane fade" id="nav-rechazadas" role="tabpanel" aria-labelledby="nav-rechazadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_rechazadas" class="table table-striped align-middle w-100">
                            <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>R.U.T</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
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
    <!-- <div class="modal fade" id="modalForm" tabindex="-1">
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
    </div> -->


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
            
            // Prueba Data tables - Pestaña Rendiciones
            new DataTable('#table_revision', {
                data: @json($revision),
                order: [],
                language: idioma ?? {},
                deferRender: true,
                responsive: true,
                columns: [
                    { data: 'id' },
                    { 
                        data: 'subvencion.fecha_asignacion',
                        render: function(d){
                            if (!d) return 'S/D';
                            fecha = new Date(d)
                            return fecha.toLocaleDateString()
                        }
                    },
                    { 
                        data: 'subvencion.rut',
                        render: // Formatear RUT
                            function formatearRut(rut){
                                rut = rut.replace(/\./g, '').replace('-', '');
                                cuerpo = rut.slice(0, -1)
                                dv = rut.slice(-1)

                                rutConPuntos = ''
                                i = cuerpo.length
                                while (i > 3){
                                    rutConPuntos = '.' + cuerpo.slice(i-3, i) + rutConPuntos
                                    i -= 3
                                }
                                rutConPuntos = cuerpo.slice(0, i) + rutConPuntos
                                return `${rutConPuntos}-${dv}`
                                }
                    },
                    { 
                        data: '',
                        defaultContent: 'S/D'
                    },
                    { data: 'subvencion.decreto' },
                    { 
                        data: 'subvencion.monto',
                        render: function(monto){
                            monto = monto.toString()
                            montoFormateado = ''
                            i = monto.length
                            while(i > 3){
                                montoFormateado = '.' + monto.slice(i-3, i) + montoFormateado
                                i -= 3
                            }
                            montoFormateado = monto.slice(0, i) + montoFormateado
                            return montoFormateado
                        }
                    },
                    { data: 'subvencion.destino' },
                    { data: 'estado_rendicion.nombre' },
                    {
                        data: null,
                        ordeable: false,
                        searchable: false,
                        render: function(data, type, row){
                            id = row.id
                            return `
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <!-- Ver detalles -->
                                    <button class="btn btn-accion" data-bs-target="#modalVerDetallesRendicion"
                                        onclick="verDetalleRendicion(${id})"
                                        data-bs-toggle="modal" title="Ver detalles" type="button">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                    <!-- Editar -->
                                    <button class="btn btn-success btn-accion" 
                                        title="Editar" type="button" 
                                        onclick="abrirModalEditar(${id})">
                                        <i class="fas fa-file-signature"> </i>
                                    </button>
                                    <!-- Eliminar -->
                                    <button class="btn btn-success btn-accion btn-eliminar-subvencion" 
                                        title="Eliminar" type="button" data-subvencion-id="${id}">
                                        <i class="fas fa-times-circle"> </i>
                                    </button>
                                </div>

                            `
                        }
                    }
                ]
            });

            // Prueba Data Tables - Pestaña Pendientes //
            new DataTable('#table_pendientes', {
                order: [],
                language: idioma ?? {},
                deferRender: true,
                responsive: true,
            });

            new DataTable('#table_observadas', {
                order: [],
                language: idioma ?? {},
                deferRender: true,
                responsive: true,
            });

            new DataTable('#table_rechazadas', {
                order: [],
                language: idioma ?? {},
                deferRender: true,
                responsive: true,
            });
            const buscador = document.getElementById('buscadorRendiciones');

            // IDs de todas las tablas de rendiciones
            const tablasIds = ['table_id', 'table_pendientes', 'table_observadas', 'table_rechazadas'];

            // Función para filtrar filas en una tabla específica
            // function filtrarFilasEnTabla(tablaId, termino) {
            //     const tabla = document.getElementById(tablaId);
            //     if (!tabla) return;

            //     const filas = tabla.querySelectorAll('tbody tr');
            //     const terminoLower = termino.toLowerCase();

            //     filas.forEach(fila => {
            //         const celdas = fila.querySelectorAll('td');
            //         let coincide = false;

            //         // Buscar en todas las celdas excepto la última (opciones)
            //         for (let i = 0; i < celdas.length - 1; i++) {
            //             const texto = celdas[i].textContent.toLowerCase();
            //             if (texto.includes(terminoLower)) {
            //                 coincide = true;
            //                 break;
            //             }
            //         }

            //         // Mostrar u ocultar fila
            //         fila.style.display = coincide ? '' : 'none';
            //     });
                
            //     // No actualizar numeración después de filtrar - mantener numeración original
            // }

            // Función para filtrar todas las tablas
            // function filtrarTodasLasTablas(termino) {
            //     tablasIds.forEach(tablaId => {
            //         filtrarFilasEnTabla(tablaId, termino);
            //     });
            // }

            // // Inicializar ordenamiento para todas las tablas
            // tablasIds.forEach(tablaId => {
            //     inicializarOrdenamiento(tablaId);
            // });

            // Evento de búsqueda en tiempo real
            // buscador.addEventListener('input', function() {
            //     const termino = this.value.trim();
            //     filtrarTodasLasTablas(termino);
            // });

            // // Limpiar búsqueda con Escape
            // buscador.addEventListener('keydown', function(e) {
            //     if (e.key === 'Escape') {
            //         this.value = '';
            //         filtrarTodasLasTablas('');
            //     }
            // });
        });
    </script>

    <x-footer />
</x-app>
