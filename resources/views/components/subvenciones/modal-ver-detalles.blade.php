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
                            Otras subvenciones
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
                                        <strong>Estado:</strong>
                                        <span class="dato-subrayado" id="detalle_usuario">No se ha iniciado una rendición</span>
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
                            <table id="table_acciones_subvencion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                        <th>Comentario</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Pestaña subvenciones anteriores -->
                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <table id="table_subvenciones_anteriores" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Decreto</th>
                                        <th>Monto</th>
                                        <th>Destino</th>
                                        <!-- <th>Estado</th> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!-- Pestaña datos organización -->
                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <p id="detalle_sin_datos" hidden></p>
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
