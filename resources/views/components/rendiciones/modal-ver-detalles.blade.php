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
                        <button class="nav-link active" id="tab1-rendicion-tab" data-bs-toggle="tab"
                            data-bs-target="#tab1-rendicion" type="button" role="tab">
                            Detalle de Rendición
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
                        <button class="nav-link" id="tab4-rendicion-tab" data-bs-toggle="tab"
                            data-bs-target="#tab4-rendicion" type="button" role="tab">
                            Historial de estados
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content pt-4 px-4 pb-2">
                    <!-- Pestaña 1 - Detalle de Rendición -->
                    <div class="tab-pane fade active show" id="tab1-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <strong>Fecha de Rendición:</strong>
                                        <span class="dato-subrayado" id="detalle_fecha_rendicion">29/05/2025</span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>Estado:</strong>
                                        <span class="dato-subrayado" id="detalle_estado_rendicion">Rendida</span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>Monto:</strong>
                                        <span class="dato-subrayado" id="detalle_monto_rendicion">$150.000</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <strong>N° Movimiento:</strong>
                                        <span class="dato-subrayado" id="detalle_numero_movimiento">865501</span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>Persona Responsable:</strong>
                                        <span class="dato-subrayado" id="detalle_persona_responsable">María González</span>
                                    </p>
                                    <p class="mb-3">
                                        <strong>Cargo:</strong>
                                        <span class="dato-subrayado" id="detalle_cargo_persona">Tesorera</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-start">
                                <label for="comentario_rendicion"
                                    class="col-sm-2 col-form-label fw-bold">Comentarios</label>
                                <div class="col-sm-10">
                                    <textarea id="detalle_comentario_rendicion" class="form-control shadow-sm" rows="4" readonly>
                                        Rendición de gastos correspondiente al mes de mayo 2025, incluye materiales y servicios básicos para el funcionamiento de la organización.
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña 2 - Acciones realizadas -->
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
                                    <tbody>
                                        <tr>
                                            <td class="text-center px-2">1</td>
                                            <td class="text-center px-2">29/05/2025</td>
                                            <td class="px-2">14:30</td>
                                            <td class="px-2">Rendición aprobada</td>
                                            <td class="px-2">Carlos Mendoza</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center px-2">2</td>
                                            <td class="text-center px-2">28/05/2025</td>
                                            <td class="px-2">10:15</td>
                                            <td class="px-2">Rendición enviada</td>
                                            <td class="px-2">María González</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center px-2">3</td>
                                            <td class="text-center px-2">25/05/2025</td>
                                            <td class="px-2">16:45</td>
                                            <td class="px-2">Rendición creada</td>
                                            <td class="px-2">Sistema</td>
                                        </tr>
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
                                    <tbody>
                                        <tr>
                                            <td class="text-center px-2">25951</td>
                                            <td class="text-center px-2">20/04/2025</td>
                                            <td class="px-2">8:00</td>
                                            <td class="px-2">Hoy vence el plazo para rendición</td>
                                            <td class="px-2">
                                                <span class="badge bg-warning">No leído</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center px-2">25810</td>
                                            <td class="text-center px-2">15/04/2025</td>
                                            <td class="px-2">8:30</td>
                                            <td class="px-2">Recordatorio de plazo de vencimiento</td>
                                            <td class="px-2">
                                                <span class="badge bg-success">Leído</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center px-2">25750</td>
                                            <td class="text-center px-2">10/04/2025</td>
                                            <td class="px-2">9:15</td>
                                            <td class="px-2">Nueva rendición disponible</td>
                                            <td class="px-2">
                                                <span class="badge bg-success">Leído</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña 4 - Historial de estados -->
                    <div class="tab-pane fade" id="tab4-rendicion" role="tabpanel">
                        <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                            <div class="table-responsive">
                                <table id="table_historial_estados" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> #
                                            </th>
                                            <th class="text-center px-2">
                                                <i class="fas fa-sort me-1"></i> Fecha
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Estado anterior
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Estado nuevo
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Usuario
                                            </th>
                                            <th class="px-2">
                                                <i class="fas fa-sort me-1"></i> Observaciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center px-2">1</td>
                                            <td class="text-center px-2">29/05/2025</td>
                                            <td class="px-2">
                                                <span class="badge bg-warning">Pendiente</span>
                                            </td>
                                            <td class="px-2">
                                                <span class="badge bg-success">Rendida</span>
                                            </td>
                                            <td class="px-2">Carlos Mendoza</td>
                                            <td class="px-2">Aprobada sin observaciones</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center px-2">2</td>
                                            <td class="text-center px-2">28/05/2025</td>
                                            <td class="px-2">
                                                <span class="badge bg-secondary">Creada</span>
                                            </td>
                                            <td class="px-2">
                                                <span class="badge bg-warning">Pendiente</span>
                                            </td>
                                            <td class="px-2">María González</td>
                                            <td class="px-2">Enviada para revisión</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center px-2">3</td>
                                            <td class="text-center px-2">25/05/2025</td>
                                            <td class="px-2">—</td>
                                            <td class="px-2">
                                                <span class="badge bg-secondary">Creada</span>
                                            </td>
                                            <td class="px-2">Sistema</td>
                                            <td class="px-2">Rendición creada automáticamente</td>
                                        </tr>
                                    </tbody>
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
                </div>
            </div>
        </div>
    </div>
</div>
