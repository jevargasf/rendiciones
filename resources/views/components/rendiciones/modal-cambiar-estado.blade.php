<!-- Módulo para "Rendir Subvención" con pestañas -->
<div aria-hidden="true" class="modal fade" id="modalCambiarEstado" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
        <div class="modal-content shadow-md rounded-4 overflow-hidden">
            <div class="modal-header modal-header-app">
                <h6 class="modal-title fw-bold" id="modalCambiarEstadoLabel">Cambiar Estado Rendición</h6>
                <button aria-label="Cerrar" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    type="button"></button>
            </div>

            <div class="border rounded m-3 p-3 bg-light flex-grow-1">
                <!-- Campo oculto para ID de rendición -->
                <input type="hidden" id="rendicion_id" />
                <!-- Información de la subvención (no editable) -->
                <div class="row mt-2 mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-building me-2 text-primary"></i>
                            <span class="fw-bold small">RUT Organización:</span>
                        </div>
                        <p class="ms-4 mb-0" id="rut_organizacion_rendir">-</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-people-fill me-2 text-primary"></i>
                            <span class="fw-bold small">Nombre Organización:</span>
                        </div>
                        <p class="ms-4 mb-0" id="nombre_organizacion_rendir">-</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-file-text me-2 text-primary"></i>
                            <span class="fw-bold small">N° Decreto:</span>
                        </div>
                        <p class="ms-4 mb-0" id="decreto_rendir">-</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-currency-dollar me-2 text-primary"></i>
                            <span class="fw-bold small">Monto:</span>
                        </div>
                        <p class="ms-4 mb-0" id="monto_rendir">-</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-bullseye me-2 text-primary"></i>
                            <span class="fw-bold small">Destino de la Subvención:</span>
                        </div>
                        <p class="ms-4 mb-0" id="destino_subvencion_rendir">-</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-currency-dollar me-2 text-primary"></i>
                            <span class="fw-bold small">Estado actual:</span>
                        </div>
                        <p class="ms-4 mb-0" id="estado_actual_rendir">-</p>
                    </div>
                </div>

                <p class="fw-bold medium">Datos de persona que rinde</p>
                <div class="ps-3 ps-sm-4">
                    <div class="row gy-2 gx-2 mt-3">
                        <div class="col-md-3">
                            <label class="fw-bold small mb-1" for="persona_rut">RUT</label>
                            <input class="form-control form-control-sm shadow-sm" id="persona_rut"
                                placeholder="Ingrese RUT..." style="min-width: 160px" />
                            <div id="sugerencias_rut" class="list-group position-absolute" style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto; width: 100%; border: 1px solid #dee2e6; border-radius: 0.375rem; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);">
                                <!-- Las sugerencias se cargarán aquí -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="fw-bold small mb-1" for="persona_nombre">Nombre</label>
                            <input class="form-control form-control-sm shadow-sm" id="persona_nombre" 
                                placeholder="Ingrese nombre..." style="min-width: 160px" required />
                        </div>
                        <div class="col-md-3">
                            <label class="fw-bold small mb-1" for="persona_apellido">Apellido</label>
                            <input class="form-control form-control-sm shadow-sm" id="persona_apellido" 
                                placeholder="Ingrese apellido..." style="min-width: 160px" required />
                        </div>
                        <div class="col-md-3">
                            <label class="fw-bold small mb-1" for="cargo">Cargo</label>
                            <select class="form-select form-select-sm shadow-sm" id="persona_cargo"
                                style="min-width: 160px" required>
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                    </div>

                    <div class="row gy-2 gx-2 mt-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1" for="persona_email">E-mail</label>
                            <input class="form-control form-control-sm shadow-sm" id="persona_email"
                                type="email" placeholder="Ingrese email..." style="min-width: 250px" required />
                        </div>
                    </div>
                </div>

                <p class="fw-bold medium mt-3">Datos de rendición</p>
                <div class="ps-3 ps-sm-4">
                    <div class="row align-items-start mt-2">
                        <div class="col-sm-9">
                            
                                <label for="comentario_cambiar_estado"
                                    class="col-2 col-sm-2 fw-bold small pb-1">
                                    Comentario</label>
                                <div class="ps-0">
                                    <textarea class="form-control form-control-sm shadow-sm" id="comentario_cambiar_estado" rows="3" 
                                        placeholder="Descripción que se desee comentar o detalle de documentos adjuntos que serán validados" required></textarea>
                                </div>
                            

                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <label class="fw-bold small pb-1" for="select_estados">Cambiar estado</label>
                                <select class="form-select form-select-sm shadow-sm" id="select_estados"
                                    style="min-width: 160px" required>
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button data-bs-dismiss="modal" style="background: none; border: none; padding: 10px"
                        type="button">
                        Cancelar
                    </button>
                    <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnCambiarEstado"
                        type="submit">
                        Cambiar estado de rendición
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
