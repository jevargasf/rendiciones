<!-- Modal: Rendir Subvención -->
<div class="modal fade" id="modalRendirsubvencion" tabindex="-1" aria-labelledby="rendirLabel"   data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <form class="modal-content needs-validation" method="POST" novalidate>
      <div class="modal-header" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">
        <h5 id="modalRendirSubvencionLabel" class="modal-title">Rendir Subvención</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body p-4 bg-light">
        <!-- Datos de la subvención -->
        <div class="border rounded-4 p-3 bg-white shadow-sm">
        <div class="mb-3">
          <h6 class="fw-semibold">Datos de la subvención</h6>
          <div class="col">
          <div class="row row-cols-1 row-cols-md-2 g-3">
            <div class="col">
              <dl class="row mb-0">
                <dt class="col-sm-6 fw-bold small ">RUT Organización:</dt>
                <dd class="col-sm-6" id="rut_organizacion_rendir">-</dd>
                <dt class="col-sm-6 fw-bold small ">Nombre Organización:</dt>
                <dd class="col-sm-6" id="nombre_organizacion_rendir">-</dd>
                <dt class="col-sm-6 fw-bold small ">Monto:</dt>
                <dd class="col-sm-6" id="monto_rendir">-</dd>
              </dl>
            </div>
            <div class="col">
              <dl class="row mb-0">
                <dt class="col-sm-6 fw-bold small">Estado actual:</dt>
                <dd class="col-sm-6">
                  <span id="estado_actual_rendir" class="col-sm-12 badge bg-primary bg-opacity-75 text-white py-2 rounded-pill shadow-sm">
                  </span>
                </dd>
                <dt class="col-sm-6 fw-bold small ">N° Decreto:</dt>
                <dd class="col-sm-6" id="decreto_rendir">-</dd>
                <dt class="col-sm-6 fw-bold small">Destino de la Subvención:</dt>
                <dd class="col-sm-6" id="destino_subvencion_rendir">-</dd>
              </dl>
            </div>
          </div>
          </div>
        </div>
        <input type="hidden" id="rendicion_id" />
        <!-- Datos de persona que rinde -->
        <div class="mb-3">
          <h6 class="fw-semibold">Datos de persona que rinde</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="persona_rut" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-id-card me-1 text-primary"></i>
                RUT</label>
              <input type="text" class="form-control" id="persona_rut" name="persona_rut" maxlength="12" required>
              <div class="invalid-feedback">Ingrese el RUT.</div>
            </div>
            <div class="col-md-6">
              <label for="persona_nombre" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-user me-1 text-primary"></i>
                Nombre</label>
              <input type="text" class="form-control" id="persona_nombre" name="persona_nombre" required>
              <div class="invalid-feedback">Ingrese el nombre.</div>
            </div>
            <div class="col-md-6">
              <label for="persona_apellido" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-user me-1 text-primary"></i>
                Apellido</label>
              <input type="text" class="form-control" id="persona_apellido" name="persona_apellido" required>
              <div class="invalid-feedback">Ingrese el apellido.</div>
            </div>
            <div class="col-md-6">
              <label for="persona_cargo" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-briefcase me-1 text-primary"></i>
                Cargo</label>
              <select class="form-select" id="persona_cargo" name="persona_cargo" required>
                <option value="">Seleccione...</option>
              </select>
              <div class="invalid-feedback">Seleccione un cargo.</div>
            </div>
            <div class="col-12">
              <label for="persona_email" class="form-label fw-bold small mb-1">
                <i class="fa-solid fa-envelope me-1 text-primary"></i>
                E-mail</label>
              <input type="email" class="form-control" id="persona_email" name="persona_email" required>
              <div class="invalid-feedback">Ingrese un correo válido.</div>
            </div>
          </div>
        </div>

        <!-- rendición -->
        <div>
          <h6 class="fw-semibold">Datos de rendición</h6>
          <label for="comentario_detalle" class="form-label fw-bold small mb-1">
            <i class="fa-solid fa-comment me-1  text-primary"></i>
            Comentario</label>
          <textarea class="form-control" id="comentario_detalle" name="comentario_detalle" rows="3" maxlength="1000"></textarea>
        </div>
      </div>
      </div>
      <div class="modal-footer bg-light px-4 pb-4 border-top-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="btnFormRendir" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">Iniciar rendición</button>
      </div>
    </form>
  </div>
</div>