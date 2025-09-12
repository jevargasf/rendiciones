<!-- Módulo para "Ver Detalles" con pestañas -->
<div class="modal fade" id="modalVerDetalles" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
        <div class="modal-content shadow-md rounded-4 overflow-hidden">
            <!-- Encabezado -->
            <div class="modal-header modal-header-app">
                <h6 class="modal-title fw-bold" id="modalVerDetallesLabel">
                    Detalle de subvención
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <!-- Información general -->
            <div class="modal-body p-3 d-flex flex-column">
                <label for="informacion_organizacion" class="form-label fw-bold"></label>
                <p id="informacion_organizacion" class="form-control shadow-sm" readonly rows="4">
                    <i class="bi bi-people-fill me-1"></i>
                    
                </p>
            </div>

            <!-- Pestañas de detalles -->
            <div class="modal-body p-0 detalle-container">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs bg-light px-3 pt-1" id="detalleTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab"
                            data-bs-target="#tab1" type="button" role="tab">
                            Detalle de Subvención
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                            type="button" role="tab">
                            Acciones realizadas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                            type="button" role="tab">
                            Subvenciones anteriores
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab4-tab" data-bs-toggle="tab"
                            data-bs-target="#tab4" type="button" role="tab">
                            Datos de la organización
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content pt-4 px-4 pb-2">
                    <!-- Pestaña detalles -->
                    <div class="tab-pane fade active show" id="tab1" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <strong>Fecha Decreto:</strong>
                                        <span class="dato-subrayado" id="detalle_fecha_decreto"></span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>N° Decreto:</strong>
                                        <span class="dato-subrayado" id="detalle_decreto"></span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>Monto:</strong>
                                        <span class="dato-subrayado" id="detalle_monto"></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <strong>Fecha asignación:</strong>
                                        <span class="dato-subrayado" id="detalle_fecha_asignacion"></span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>Seguimiento:</strong>
                                        <span class="dato-subrayado" id="detalle_usuario">Iniciada</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-start">
                                <label for="comentario_destino"
                                    class="col-sm-2 col-form-label fw-bold">Destino</label>
                                <div class="col-sm-10">
                                    <textarea id="detalle_destino" class="form-control shadow-sm" rows="4" readonly>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña acciones -->
                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="table-responsive">
                                <table
                                    id="table_acciones_realizadas"
                                    class="table table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> Fecha
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Acción realizada
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Usuario
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle_acciones">
                                        <!-- Formato fila -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay detalle acción (no aparece botón) -->
                    <div id="ver-detalle" class="overlay-detalle d-none">
                        <div
                            class="detalle-box modal-content shadow-md rounded-4 overflow-hidden"
                        >
                            <div class="modal-header modal-header-app">
                                <h6 class="modal-title fw-bold">Detalle de acción</h6>
                                <button
                                    type="button"
                                    class="btn-close btn-close-white"
                                    onclick="cerrarDetalle()"
                                    aria-label="Cerrar"
                                ></button>
                            </div>
                            <div class="p-4">
                                <p>
                                    <strong>Usuario:</strong>
                                    <span id="detalle-usuario">—</span>
                                </p>
                                <div class="row mt-4 align-items-start">
                                    <label
                                        for="detalle-comentario"
                                        class="col-sm-2 col-form-label fw-bold"
                                        >Comentario</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea
                                            id="detalle-comentario"
                                            class="form-control"
                                            rows="4"
                                            readonly
                                            placeholder="Lorem ipsum…"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="text-muted small mt-4">
                                    <span id="detalle-fecha">Fecha: —</span>
                                    <span class="mx-2">|</span>
                                    <span id="detalle-hora">Hora: —</span>
                                </div>
                                <div class="mt-4 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="cerrarDetalle()">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña subvenciones anteriores -->
                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="table-responsive">
                                <table id="table_subvenciones_anteriores" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i>#
                                            </th>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i>Fecha
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i>Decreto
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i>Monto
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i>Destino
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle_anteriores">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña datos organización -->
                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="row" id="detalle_organizacion">
                                <div class="col-md-6">
                                    <p><strong>Datos de la organización</strong></p>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>PJ Municipal</td>
                                                <td id="organizacion_pj_municipal"></td>
                                            </tr>
                                            <tr>
                                                <td>PJ Registro Civil</td>
                                                <td id="organizacion_pj_reg_civil"></td>
                                            </tr>
                                            <tr>
                                                <td>Nombre</td>
                                                <td id="organizacion_nombre"></td>
                                            </tr>
                                            <tr>
                                                <td>Dirección</td>
                                                <td id="organizacion_direccion"></td>
                                            </tr>
                                            <tr>
                                                <td>RUT</td>
                                                <td id="organizacion_rut"></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo</td>
                                                <td id="organizacion_tipo"></td>
                                            </tr>
                                            <tr>
                                                <td>Teléfono</td>
                                                <td id="organizacion_telefono"></td>
                                            </tr>
                                            <tr>
                                                <td>Correo electrónico</td>
                                                <td id="organizacion_correo"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Directiva vigente</strong></p>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Presidente</td>
                                                <td id="organizacion_presidente"></td>
                                            </tr>
                                            <tr>
                                                <td>Tesorero</td>
                                                <td id="organizacion_tesorero"></td>
                                            </tr>
                                            <tr>
                                                <td>Secretario</td>
                                                <td id="organizacion_secretario"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light d-flex justify-content-end py-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1"
                        data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark me-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
