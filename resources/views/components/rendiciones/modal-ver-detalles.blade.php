<!-- Módulo para "Ver Detalles" con pestañas -->
<div class="modal fade" id="modalVerDetallesRendicion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
        <div class="modal-content shadow-md rounded-4 overflow-hidden">
            <!-- Encabezado -->
            <div class="modal-header modal-header-app">
                <h6 class="modal-title fw-bold" id="modalVerDetallesRendicionLabel">
                    Detalle de rendición
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <!-- Información general -->
            <div class="modal-body p-3 d-flex flex-column">
                <label for="informacion_organizacion" class="form-label fw-bold"></label>
                <p id="informacion_organizacion" class="form-control shadow-sm" readonly rows="4">
                    <i class="bi bi-clipboard-check me-1"></i>
                    
                </p>
            </div>

            <!-- Pestañas de detalles -->
            <div class="modal-body p-0 detalle-container">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs bg-light px-3 pt-1" id="detalleTabsRendicion" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab1-rendicion"
                            type="button" role="tab">
                            Detalle de rendición
                        </button>
                    </li>    
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab2-rendicion"
                            type="button" role="tab">
                            Acciones realizadas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab3-rendicion-tab" data-bs-toggle="tab"
                            data-bs-target="#tab3-rendicion" type="button" role="tab">
                            Notificaciones
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab4-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab4-rendicion"
                            type="button" role="tab">
                            Otras subvenciones
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content pt-4 px-4 pb-2">
                    <!-- Pestaña detalle rendición -->
                    <div class="tab-pane fade active show" id="tab1-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0">
                            <input type="hidden" name="id" id="rendicion_id">
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
                                        <strong>Estado actual:</strong>
                                        <span class="dato-subrayado" id="detalle_estado_actual"></span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <label for="comentario_destino"
                                        class="col-sm-4 col-form-label fw-bold">Destino
                                        </label>
                                        <div class="col-sm-8">
                                            <textarea id="detalle_destino" class="form-control shadow-sm" rows="2" readonly>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <label class="col-sm-4 col-form-label fw-bold" for="estado_rendicion">Cambiar estado</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select-sm shadow-sm" id="estados_rendicion"
                                            style="min-width: 160px" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="row mt-4 align-items-start">
                                    <label for="comentario_detalle"
                                        class="col-sm-2 col-form-label fw-bold">
                                        Comentario
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control form-control-sm shadow-sm" id="comentario_detalle" rows="3" 
                                            placeholder="Descripción que se desee comentar o detalle de documentos adjuntos que serán validados" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pestaña 1 - Acciones realizadas -->
                    <div class="tab-pane fade" id="tab2-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                                <table id="table_acciones_rendicion" class="table table-striped">
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

                    <!-- Pestaña 3 - Notificaciones -->
                    <div class="tab-pane fade" id="tab3-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                                <table id="table_notificaciones_rendicion" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th>Destinatario</th> -->
                                            <th>Fecha envío</th>
                                            <th>Hora envío</th>
                                            <th>Leído</th>
                                            <th>Fecha lectura</th>
                                            <th>Hora lectura</th>
                                        </tr>
                                    </thead>
                                </table>
                        </div>
                    </div>
                    <!-- Pestaña subvenciones anteriores -->
                    <div class="tab-pane fade" id="tab4-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                                <table id="table_anteriores_rendicion" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Decreto</th>
                                            <th>Monto</th>
                                            <th>Destino</th>
                                            <!-- <th>Estado</th> -->
                                        </tr>
                                </table>
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
                <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnCambiarEstado"
                    type="submit">
                    Cambiar estado
                </button>
            </div>
        </div>
    </div>
</div>
