<!-- Modal: Ver Detalles -->
<div class="modal fade" id="modalVerDetalles" tabindex="-1" aria-labelledby="modalVerDetallesLabel"  >
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">
        <h5 id="modalVerDetallesLabel" class="modal-title">Detalle de subvención</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body p-4 bg-light">
        <!-- Nav tabs -->
        <div class="border rounded-4 p-3 bg-white shadow-sm">
        
         <ul class="nav nav-tabs" id="detalleTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="detalle" aria-selected="true">
              Detalle de Subvención
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="acciones" aria-selected="false">
              Acciones realizadas
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="otras" aria-selected="false">
              Otras subvenciones
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab" aria-controls="organizacion" aria-selected="false">
              Datos de la organización
            </button>
          </li>
         </ul>

          <!-- Tab panes -->
          <div class="tab-content pt-3">
            <!-- Detalle -->
            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="detalle-tab">
              
            
              <div class="mb-3">
                <h6 class="fw-semibold">Datos de la subvención</h6>
                <div class="col">
                  <div class="row row-cols-1 row-cols-md-2 g-3">
                    <div class="col">
                      <dl class="row mb-0">
                        <dt class="col-sm-6 fw-bold small ">Fecha Decreto:</dt>
                        <dd class="col-sm-6" id="detalle_fecha_decreto">-</dd>
                        <dt class="col-sm-6 fw-bold small ">N° Decreto:</dt>
                        <dd class="col-sm-6" id="detalle_decreto">-</dd>
                        <dt class="col-sm-6 fw-bold small ">Monto:</dt>
                        <dd class="col-sm-6" id="detalle_monto">-</dd>
                      </dl>
                    </div>
                    <div class="col">
                      <dl class="row mb-0">
                        <dt class="col-sm-6 fw-bold small">Estado actual:</dt>
                        <dd class="col-sm-6">
                          <span id="detalle_estado" class="col-sm-12 badge bg-primary bg-opacity-75 text-white py-2 rounded-pill shadow-sm">
                          </span>
                        </dd>
                        <dt class="col-sm-6 fw-bold small ">Fecha asignación:</dt>
                        <dd class="col-sm-6" id="detalle_fecha_asignacion">-</dd>
                        <dt class="col-sm-6 fw-bold small">Destino:</dt>
                        <dd class="col-sm-6" id="detalle_destino">-</dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      
        
    

            <!-- Acciones -->
            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="acciones-tab">
              <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle" id="table_acciones_subvencion">
                  <thead class="table-light">
                    <tr>
                      <th>#</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Comentario</th><th>Usuario</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            <!-- Otras subvenciones -->
            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="otras-tab">
              <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle" id="table_subvenciones_anteriores">
                  <thead class="table-light">
                    <tr>
                      <th>#</th><th>Fecha</th><th>Decreto</th><th>Monto</th><th>Destino</th><th>Estado</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

          <!-- Datos organización -->
            <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="organizacion-tab">
              <p id="detalle_sin_datos" hidden></p>
              <div class="row" id="detalle_organizacion">
                <dl class="col-6 mb-0">
                  <dt class="col-sm-6 fw-bold small">PJ Registro Civil:</dt><dd class="col-sm-6" id="organizacion_pj_reg_civil">-</dd>
                  <dt class="col-sm-6 fw-bold small">PJ Municipal:</dt><dd class="col-sm-6" id="organizacion_pj_municipal">-</dd>
                  <dt class="col-sm-6 fw-bold small">Nombre:</dt><dd class="col-sm-6" id="organizacion_nombre">-</dd>
                  <dt class="col-sm-6 fw-bold small">Dirección:</dt><dd class="col-sm-6" id="organizacion_direccion">-</dd>
                  <dt class="col-sm-6 fw-bold small">RUT:</dt><dd class="col-sm-6" id="organizacion_rut">-</dd>
                  <dt class="col-sm-6 fw-bold small">Tipo:</dt><dd class="col-sm-6" id="organizacion_tipo">-</dd>
                  <dt class="col-sm-6 fw-bold small">Teléfono:</dt><dd class="col-sm-6" id="organizacion_telefono">-</dd>
                  <dt class="col-sm-6 fw-bold small">Correo electrónico:</dt><dd class="col-sm-6" id="organizacion_correo">-</dd>
                </dl>
              <!-- Directiva -->
                  <dl class="col-6 mb-0">
                  <dt class="col-sm-6 fw-bold small">Presidente:</dt><dd class="col-sm-6" id="organizacion_presidente">-</dd>
                  <dt class="col-sm-6 fw-bold small">Tesorero:</dt><dd class="col-sm-6" id="organizacion_tesorero">-</dd>
                  <dt class="col-sm-6 fw-bold small">Secretario:</dt><dd class="col-sm-6" id="organizacion_secretario">-</dd>
                  </dl>
              </div>
            </div>

  
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- <button class="btn text-white shadow-sm" style="background: linear-gradient(135deg, var(--app-color), var(--app-color));" id="btnNavegacionCambiarEstado" data-bs-target="#modalRendirsubvencion" data-bs-toggle="modal" data-bs-dismiss="modal">
            <i class="bi bi-arrow-right-circle"></i>Ir a cambiar estado
        </button> -->
      </div>
    </div>
  </div>
</div>
