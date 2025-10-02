<!-- Modal: Eliminar Subvención -->
<div class="modal fade" id="modalEliminarSubvencion" tabindex="-1" aria-labelledby="eliminarLabel"   data-bs-backdrop="static">
  <div class="modal-dialog">
    <form class="modal-content needs-validation">

      <div class="modal-header bg-danger">
        <h5 id="modalEliminarSubvencionLabel" class="modal-title text-white">Eliminar Subvención</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body vstack gap-3">
        <div class="alert alert-warning mb-0" role="alert">
          <strong id="advertencia_eliminar">¡Advertencia!</strong> Esta acción no se puede deshacer.
        </div>

        <section aria-labelledby="resumenEliminarHeading">
          <h6 id="resumenEliminarHeading" class="fw-semibold mb-2">Información de la subvención a eliminar</h6>
          <dl class="row mb-0">
            <dt class="col-5 col-sm-4">ID:</dt>
            <dd class="col-7 col-sm-8" id="eliminarSubvencionId"></dd>

            <dt class="col-5 col-sm-4">RUT:</dt>
            <dd class="col-7 col-sm-8" id="eliminarSubvencionRut"></dd>

            <dt class="col-5 col-sm-4">Organización:</dt>
            <dd class="col-7 col-sm-8" id="eliminarSubvencionOrganizacion"></dd>

            <dt class="col-5 col-sm-4">Decreto:</dt>
            <dd class="col-7 col-sm-8" id="eliminarSubvencionDecreto"></dd>

            <dt class="col-5 col-sm-4">Monto:</dt>
            <dd class="col-7 col-sm-8" id="eliminarSubvencionMonto">
            </dd>

            <dt class="col-5 col-sm-4">Destino:</dt>
            <dd class="col-7 col-sm-8" id="eliminarSubvencionDestino"></dd>
          </dl>
        </section>

        <div>
          <label for="eliminar_motivo" class="form-label">Motivo de la eliminación <span class="text-danger">*</span></label>
          <textarea class="form-control"
                    id="motivoEliminacion" 
                    name="motivoEliminacion" 
                    rows="3"
                    required
                    maxlength="1000"
                    placeholder="Explica por qué se elimina esta subvención..."></textarea>
          <div class="form-text">Este motivo quedará registrado en el sistema.</div>
          <div class="invalid-feedback">Debes indicar un motivo.</div>
        </div>

        <div class="form-check">
          <input class="form-check-input"
                 type="checkbox"
                 value="1"
                 id="confirmarEliminacion" 
                 required>
          <label class="form-check-label" for="confirmarEliminacion">
            Confirmo que entiendo que se eliminarán <strong>TODAS</strong> las subvenciones con el decreto
            <strong id="confirmarDecreto"></strong> y que esta acción no se puede deshacer.
          </label>
          <div class="invalid-feedback">Debes confirmar antes de eliminar.</div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger" id="btnConfirmarEliminacion">Eliminar Subvención</button>
      </div>
    </form>
  </div>
</div>