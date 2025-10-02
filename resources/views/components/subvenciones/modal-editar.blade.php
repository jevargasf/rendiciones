<!-- Modal: Editar subvención -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="editarLabel"   data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <form class="modal-content needs-validation" method="POST" id="formEditarSubvencion" novalidate>
      @csrf

      <div class="modal-header" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">
        <h5 id="modalEditarSubvencionLabel" class="modal-title">Editar subvención</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body p-4 bg-light">
        <div class="border rounded-4 p-3 bg-white shadow-sm">
          <input type="hidden" id="subvencion_id" name="id">
          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="rut_editar" class="form-label fw-bold small mb-1">
              <i class="fa-solid fa-building me-1 text-primary"></i>  
                RUT Organización</label>
              <input type="text"
                    class="form-control shadow-sm"
                    id="rut_editar"
                    name="rut"
                    placeholder="12.345.678-9"
                    inputmode="text"
                    autocomplete="off"
                    maxlength="12" required>
              <div class="form-text">Formato RUT (ej: 12.345.678-9).</div>
            </div>

            <div class="col-sm-6">
              <label for="organizacion_editar" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-users me-1 text-primary"></i>
                Organización</label>
              <input type="text"
                    class="form-control shadow-sm bg-light"
                    id="organizacion_editar"
                    name="nombre_organizacion"
                    placeholder="Nombre de la organización" 
                    readonly>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="decreto_editar" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-file-lines me-1 text-primary"></i>  
                Nro decreto</label>
              <input type="text"
                    class="form-control shadow-sm"
                    id="decreto_editar"
                    name="decreto">
            </div>

            <div class="col-sm-6">
              <label for="monto_editar" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-dollar-sign me-1 text-primary"></i>
                Monto</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number"
                      class="form-control shadow-sm"
                      id="monto_editar"
                      name="monto"
                      min="1"
                      step="1">
              </div>
              <div class="form-text">Usa coma o punto según configuración regional del navegador.</div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-6">
              <label for="fecha_decreto_editar" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-calendar-days me-1 text-primary"></i>
                Fecha decreto</label>
              <input type="date"
                    class="form-control shadow-sm"
                    id="fecha_decreto_editar"
                    name="fecha_decreto">
            </div>

            <div class="col-sm-6">
              <label for="fecha_asignacion_editar" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-bullseye me-1 text-primary"></i>
                Fecha asignación</label>
              <input type="date"
                    class="form-control shadow-sm"
                    id="fecha_asignacion_editar"
                    name="fecha_asignacion">
            </div>
          </div>

          <div class="row mb-3"></div>
          <div class="col-12">
            <label for="destino_editar" class="form-label fw-bold small mb-1">
              <i class="fa-solid fa-bullseye me-1 text-primary"></i>
              Destino</label>
            <textarea class="form-control shadow-sm"
                      id="destino_editar"
                      name="destino"
                      rows="3"
                      maxlength="1000"
                      placeholder="Describe el destino de la subvención..."></textarea>
          </div>

        </div>
      </div>

      <div class="modal-footer bg-light px-4 pb-4 border-top-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="btnFormEditar" style="background: linear-gradient(135deg, var(--app-color), var(--app-color));">Editar datos de subvención</button>
      </div>
    </form>
  </div>
</div>