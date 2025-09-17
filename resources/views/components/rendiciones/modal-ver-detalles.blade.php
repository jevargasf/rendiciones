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
                <label for="informacion_rendicion" class="form-label fw-bold"></label>
                <p id="informacion_rendicion" class="form-control shadow-sm" readonly rows="4">
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

                            <div class="row mt-4 align-items-start">
                                <label for="comentario_destino"
                                    class="col-sm-2 col-form-label fw-bold">Destino</label>
                                <div class="col-sm-10">
                                    <textarea id="detalle_destino" class="form-control shadow-sm" rows="2" readonly>
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <label class="fw-bold small mb-1" for="estado_rendicion">Cambiar estado</label>
                            <select class="form-select form-select-sm shadow-sm" id="estados_rendicion"
                                style="min-width: 160px" required>
                                <option value="">Seleccione...</option>
                            </select>
                            </div>
                            <div class="ps-3 ps-sm-4 ps-md-5">
                                <div class="row gy-2 gx-0 align-items-start mt-2">
                                    <label for="comentario_detalle"
                                        class="col-3 col-sm-2 col-form-label fw-bold small mb-0">
                                        Comentario</label>
                                    <div class="col-9 col-sm-10 ps-0 pull-left-sm pull-left-md">
                                        <textarea class="form-control form-control-sm shadow-sm" id="comentario_detalle" rows="3" 
                                            placeholder="Descripción que se desee comentar o detalle de documentos adjuntos que serán validados" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pestaña 1 - Acciones realizadas -->
                    <div class="tab-pane fade" id="tab2-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="table-responsive">
                                <table
                                    id="table_acciones_rendicion"
                                    class="table table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> #
                                            </th>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> Fecha
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Hora
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Acción realizada
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Usuario
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_acciones_rendicion">
                                        <!-- Los datos se cargarán dinámicamente aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña 3 - Notificaciones -->
                    <div class="tab-pane fade" id="tab3-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="table-responsive">
                                <table id="table_notificaciones_rendicion" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> #
                                            </th>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> Fecha envío
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Hora envío
                                            </th>
                                            <!-- <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Resolución
                                            </th> -->
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Leído
                                            </th>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> Fecha lectura
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Hora lectura
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_notificaciones_rendicion">
                                        <!-- Los datos se cargarán dinámicamente aquí -->
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
                <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnCambiarEstado"
                    type="submit">
                    Cambiar estado
                </button>
            </div>
        </div>
    </div>
</div>
