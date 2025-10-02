<x-app title="Rendiciones">
    <x-header />

    <!-- Encabezado principal -->
    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">
                Rendiciones
            </h5>

            <!-- Buscador -->
            <div class="row mb-3" id="contenedor_busqueda">
            </div>

            <!-- Tablas -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-revision-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-revision" type="button" role="tab" aria-controls="nav-revision"
                        aria-selected="true">
                        En revisión
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

                    <button class="nav-link" id="nav-aprobadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-aprobadas" type="button" role="tab" aria-controls="nav-aprobadas"
                        aria-selected="false">
                        Aprobadas
                    </button>
                </div>
            </nav>

            <!-- Tabla de contenidos -->
            <div class="tab-content" id="nav-tabContent">
                <!-- EN REVISIÓN -->
                <div class="tab-pane fade show active" id="nav-revision" role="tabpanel"
                    aria-labelledby="nav-revision-tab" tabindex="0">
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
                                    <!-- <th>Estado</th> -->
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- PESTAÑA PENDIENTES DATATABLE -->
                <div class="tab-pane fade" id="nav-observadas" role="tabpanel" aria-labelledby="nav-observadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_observadas" class="table table-striped align-middle w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>RUT</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Destino</th>
                                    <!-- <th>Estado</th> -->
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- OBSERVADAS DATATABLE-->
                <div class="tab-pane fade" id="nav-rechazadas" role="tabpanel" aria-labelledby="nav-rechazadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_rechazadas" class="table table-striped align-middle w-100">
                            <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_observadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>RUT</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Destino</th>
                                    <!-- <th>Estado</th> -->
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!--Pestaña Tabla Rechazadas con DATATABLE-->

                <div class="tab-pane fade" id="nav-aprobadas" role="tabpanel" aria-labelledby="nav-aprobadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_aprobadas" class="table table-striped align-middle w-100">
                            <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>RUT</th>
                                    <th>Organización</th>
                                    <th>Decreto</th>
                                    <th>Monto</th>
                                    <th>Destino</th>
                                    <!-- <th>Estado</th> -->
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

    <!-- Modal Editar -->
    <x-rendiciones.modal-editar />

    <!-- Modal Cambiar Estado -->
    <x-rendiciones.modal-cambiar-estado/>
    
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
    <script src="{{ asset('js/rendiciones.js') }}" defer></script> <!-- se llama el script relacionado con la página -->

    <!-- Aquí se eliminaron todos los scripts relacionados con funciones de JavaScript estáticas,(no había archivo antes de JS)
     ya que ahora se va a usar el archivo script src="asset('js/rendiciones.js'" defer></script. -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

        // Funcionalidad del buscador y ordenamiento para rendiciones
        window.addEventListener('DOMContentLoaded', function() {
            // Prueba Data tables - Pestaña Rendiciones

            new DataTable('#table_revision', {
                data: @json($revision),
                order: [ 0, 'desc' ],
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
                        data: 'subvencion.data_organizacion.nombre_organizacion'
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
                            return `$${montoFormateado}`
                        }
                    },
                    { data: 'subvencion.destino' },
                    // { data: 'estado_rendicion.nombre' },
                    {
                        data: null,
                        ordeable: false,
                        searchable: false,
                        render: function(data, type, row){
                            id = row.id
                            subvencion_id = row.subvencion.id
                            return `
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <!-- Ver detalles -->
                                    <button class="btn btn-accion"
                                        onclick="verDetalleRendicion(${id}, this)" data-btn-estado="revision" 
                                        title="Ver detalles" type="button" data-rendicion-id="${id}"
                                        data-btn-estado="revision">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                    <!-- Editar -->
                                    <button class="btn btn-success btn-accion" 
                                        title="Editar" type="button"
                                        onclick="abrirModalEditar(${id}, this)"
                                        data-btn-estado="revision">
                                        <i class="fas fa-file-signature"> </i>
                                    </button>
                                    <!-- Rendir subvención -->
                                    <button class="btn btn-success btn-accion"
                                        onclick="abrirModalCambiarEstado(${subvencion_id})"
                                        title="Cambiar estado" type="button">
                                        <i class="fas fa-clipboard-check icon-static-blue"></i>
                                    </button>
                                    <!-- Eliminar -->
                                    <button class="btn btn-success btn-accion btn-eliminar-rendicion" 
                                        title="Eliminar" type="button" data-rendicion-id="${id}"
                                        data-btn-estado="revision">
                                        <i class="fas fa-times-circle"> </i>
                                    </button>
                                </div>

                            `
                        }
                    }
                ]
            });

            // Prueba Data Tables - Pestaña Pendientes //
            new DataTable('#table_observadas', {
                data: @json($observadas),
                order: [ 0, 'desc' ],
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
                        data: 'subvencion.data_organizacion.nombre_organizacion'
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
                            return `$${montoFormateado}`
                        }
                    },
                    { data: 'subvencion.destino' },
                    // { data: 'estado_rendicion.nombre' },
                    {
                        data: null,
                        ordeable: false,
                        searchable: false,
                        render: function(data, type, row){
                            id = row.id
                            subvencion_id = row.subvencion.id
                            return `
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <!-- Ver detalles -->
                                    <button class="btn btn-accion"
                                        onclick="verDetalleRendicion(${id}, this)"
                                        title="Ver detalles" type="button"
                                        data-btn-estado="observadas">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                    <!-- Editar -->
                                    <button class="btn btn-success btn-accion" 
                                        title="Editar" type="button" 
                                        onclick="abrirModalEditar(${id}, this)"
                                        data-btn-estado="observadas">
                                        <i class="fas fa-file-signature"> </i>
                                    </button>
                                    <!-- Rendir subvención -->
                                    <button class="btn btn-success btn-accion"
                                        onclick="abrirModalCambiarEstado(${subvencion_id})"
                                        title="Cambiar estado" type="button">
                                        <i class="fas fa-clipboard-check icon-static-blue"></i>
                                    </button>
                                </div>

                            `
                        }
                    }
                ]
            });

            new DataTable('#table_rechazadas', {
                data: @json($rechazadas),
                order: [ 0, 'desc' ],
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
                        data: 'subvencion.data_organizacion.nombre_organizacion',
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
                            return `$${montoFormateado}`
                        }
                    },
                    { data: 'subvencion.destino' },
                    // { data: 'estado_rendicion.nombre' },
                    {
                        data: null,
                        ordeable: false,
                        searchable: false,
                        render: function(data, type, row){
                            id = row.id
                            return `
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <!-- Ver detalles -->
                                    <button class="btn btn-accion"
                                        onclick="verDetalleRendicion(${id}, this)"
                                        title="Ver detalles" type="button"
                                        data-btn-estado="rechazadas">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                    <!-- Editar -->
                                    <button class="btn btn-success btn-accion" 
                                        title="Editar" type="button" 
                                        onclick="abrirModalEditar(${id}, this)"
                                        data-btn-estado="rechazadas">
                                        <i class="fas fa-file-signature"> </i>
                                    </button>
                                </div>

                            `
                        }
                    }
                ]
            });

            new DataTable('#table_aprobadas', {
                data: @json($aprobadas),
                order: [ 0, 'desc' ],
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
                        data: 'subvencion.data_organizacion.nombre_organizacion'
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
                            return `$${montoFormateado}`
                        }
                    },
                    { data: 'subvencion.destino' },
                    // { data: 'estado_rendicion.nombre' },
                    {
                        data: null,
                        ordeable: false,
                        searchable: false,
                        render: function(data, type, row){
                            id = row.id
                            return `
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <!-- Ver detalles -->
                                    <button class="btn btn-accion"
                                        onclick="verDetalleRendicion(${id}, this)"
                                        title="Ver detalles" type="button"
                                        data-btn-estado="aprobadas">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                    <!-- Editar -->
                                    <button class="btn btn-success btn-accion" 
                                        title="Editar" type="button" 
                                        onclick="abrirModalEditar(${id}, this)"
                                        data-btn-estado="aprobadas">
                                        <i class="fas fa-file-signature"> </i>
                                    </button>
                                </div>

                            `
                        }
                    }
                ]
            });

            $('.dataTables_filter input')
                .addClass('w-100 shadow-sm')
                .css({
                    'font-size': '0.875rem',
                    'margin-left': '0'
                }).attr('placeholder', 'Buscar en subvenciones (RUT, organización, decreto, destino, monto...)');
            $('.dataTables_filter label').addClass('w-100').css('margin-bottom', '0');

            if (localStorage.getItem('abrir_modal_detalles') === 'true'){                
                localStorage.removeItem('abrir_modal_detalles');
                const botonModalDetalles = document.querySelector('#table_revision > tbody > tr.odd > td:nth-child(8) > div > button:nth-child(3)');
                
                if (botonModalDetalles) {
                    botonModalDetalles.click();
                }
            }
        });
    </script>

    <x-footer />
</x-app>
