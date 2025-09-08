<!-- Modal Eliminar Subvención -->
<div aria-hidden="true" class="modal fade" id="modalEliminarSubvencion" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-md rounded-4 overflow-hidden">
            <div class="modal-header modal-header-app bg-danger">
                <h5 class="modal-title fw-bold text-white" id="modalEliminarTitulo">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Eliminar Subvención
                </h5>
                <button aria-label="Close" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    type="button"></button>
            </div>
            <div class="modal-body p-4">
                <div class="container">
                    <div class="p-4 rounded">
                        <!-- Advertencia -->
                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-1">¡Advertencia Importante!</h6>
                                <p class="mb-0">Al eliminar esta subvención, se eliminarán <strong>TODAS las subvenciones</strong> que tengan el mismo decreto. Esta acción no se puede deshacer.</p>
                            </div>
                        </div>

                        <!-- Información de la subvención a eliminar -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">Información de la subvención a eliminar:</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>ID:</strong> <span id="eliminarSubvencionId">-</span></p>
                                        <p class="mb-2"><strong>RUT:</strong> <span id="eliminarSubvencionRut">-</span></p>
                                        <p class="mb-2"><strong>Organización:</strong> <span id="eliminarSubvencionOrganizacion">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Decreto:</strong> <span id="eliminarSubvencionDecreto">-</span></p>
                                        <p class="mb-2"><strong>Monto:</strong> <span id="eliminarSubvencionMonto">-</span></p>
                                        <p class="mb-2"><strong>Destino:</strong> <span id="eliminarSubvencionDestino">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campo para motivo de eliminación -->
                        <div class="mb-4">
                            <label class="form-label fw-bold" for="motivoEliminacion">
                                Motivo de la eliminación
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="motivoEliminacion" name="motivoEliminacion" 
                                rows="4" placeholder="Describa el motivo por el cual se elimina esta subvención..." 
                                required></textarea>
                            <div class="form-text">Este motivo quedará registrado en el sistema.</div>
                        </div>

                        <!-- Confirmación adicional -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmarEliminacion" required>
                            <label class="form-check-label fw-bold text-danger" for="confirmarEliminacion">
                                Confirmo que entiendo que se eliminarán TODAS las subvenciones con el decreto <span id="confirmarDecreto">-</span> y que esta acción no se puede deshacer.
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                <button class="btn btn-outline-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal"
                    type="button">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Cancelar
                </button>
                <button class="btn btn-danger px-4 py-2 rounded-pill shadow-sm" id="btnConfirmarEliminacion"
                    type="button" disabled>
                    <i class="fas fa-trash-alt me-2"></i>
                    Eliminar Subvención
                </button>
            </div>
        </div>
    </div>
</div>
