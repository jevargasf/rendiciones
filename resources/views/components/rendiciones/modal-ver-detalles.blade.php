<!-- Modal: Ver Detalles -->
<div class="modal fade" id="modalVerDetallesRendicion" tabindex="-1" aria-labelledby="modalVerDetallesRendicionLabel"  >
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">
        <h5 id="modalVerDetallesRendicionLabel" class="modal-title">Detalle de subvención</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
        <input type="hidden" name="id" id="rendicion_id">

      <div class="modal-body p-4 bg-light">
        <!-- Nav tabs -->
        <div class="border rounded-4 p-3 bg-white shadow-sm">
        
         <ul class="nav nav-tabs" id="detalleTabsRendicion" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab1-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab1-rendicion" type="button" role="tab" aria-controls="detalle" aria-selected="true">
              Detalle de Subvención
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab2-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab2-rendicion" type="button" role="tab" aria-controls="acciones" aria-selected="false">
              Acciones realizadas
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab3-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab3-rendicion" type="button" role="tab" aria-controls="otras" aria-selected="false">
              Notificaciones
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab4-rendicion-tab" data-bs-toggle="tab" data-bs-target="#tab4-rendicion" type="button" role="tab" aria-controls="organizacion" aria-selected="false">
              Otras subvenciones
            </button>
          </li>
         </ul>

          <!-- Tab panes -->
          <div class="tab-content pt-3">
            <!-- Detalle -->
            <div class="tab-pane fade show active" id="tab1-rendicion" role="tabpanel" aria-labelledby="detalle-tab">
              
            
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
                          <span id="detalle_estado_actual" class="col-sm-12 badge bg-primary bg-opacity-75 text-white py-2 rounded-pill shadow-sm">
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
            <div class="tab-pane fade" id="tab2-rendicion" role="tabpanel" aria-labelledby="acciones-tab">
              <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle" id="table_acciones_rendicion">
                  <thead class="table-light">
                    <tr>
                      <th>#</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Comentario</th><th>Usuario</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            <!-- Otras subvenciones -->
            <div class="tab-pane fade" id="tab3-rendicion" role="tabpanel" aria-labelledby="otras-tab">
              <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle" id="table_notificaciones_rendicion">
                  <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Destinatario</th>
                        <th>Fecha envío</th>
                        <th>Hora envío</th>
                        <th>Estado rendición</th>
                        <th>Leído</th>
                        <th>Fecha lectura</th>
                        <th>Hora lectura</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            <!-- Otras subvenciones -->
            <div class="tab-pane fade" id="tab4-rendicion" role="tabpanel" aria-labelledby="otras-tab">
              <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle" id="table_anteriores_rendicion">
                  <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Decreto</th>
                        <th>Monto</th>
                        <th>Destino</th>
                        <th>Estado</th> 
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

  
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>
