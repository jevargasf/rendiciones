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
                        <button class="nav-link active" id="tab2-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab2-rendicion"
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
                        <button class="nav-link" id="tab4-rendicion-tab" data-bs-toggle="tab"
                            data-bs-target="#tab4-rendicion" type="button" role="tab">
                            Editar rendición
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content pt-4 px-4 pb-2">
                    <!-- Pestaña 1 - Acciones realizadas -->
                    <div class="tab-pane fade active show" id="tab2-rendicion" role="tabpanel">
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
                                                <i class="fas fa-sort me-1"></i> Fecha
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Hora
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Destino de recursos
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Estado
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

                    <!-- Pestaña 4 - Editar rendición -->
                    <div class="tab-pane fade" id="tab4-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="estado_rendicion_edit" class="form-label fw-bold">Estado de la rendición</label>
                                    <select class="form-select" id="estado_rendicion_edit" name="estado_rendicion_edit">
                                        <option value="">Seleccione un estado</option>
                                        <option value="3">Objetada</option>
                                        <option value="5">Aprobada</option>
                                        <option value="4">Rechazada</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="comentario_estado" class="form-label fw-bold">Comentario (opcional)</label>
                                    <textarea class="form-control" id="comentario_estado" name="comentario_estado" rows="3" placeholder="Ingrese un comentario sobre el cambio de estado..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light d-flex justify-content-end py-2">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1 me-2"
                    data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-2"></i>Cerrar
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-3 py-1" id="btn_guardar_cambios_rendicion">
                    <i class="fa-solid fa-save me-2"></i>Guardar cambios
                </button>
            </div>
        </div>
    </div>
</div>
