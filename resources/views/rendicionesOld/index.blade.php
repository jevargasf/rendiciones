<x-app title="Rendiciones">

    <x-header />

 

  <!-- Encabezado principal -->
  <div class="container justify-content-center py-3 mt-3">
    <div class="shadow-sm p-3 mb-5 bg-body rounded">
      <h5 class="mb-5">
        Rendiciones
        <a class="btn mb-1 font-weight-bold btn-app float-end" id="btnModal">
          <i class="fa-solid fa-plus"></i> Registrar Pilar
        </a>
      </h5>

      <!-- Tablas -->
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-rendidas-tab" data-bs-toggle="tab" data-bs-target="#nav-rendidas"
            type="button" role="tab" aria-controls="nav-rendidas" aria-selected="true">
            Rendidas
          </button>

          <button class="nav-link" id="nav-pendientes-tab" data-bs-toggle="tab" data-bs-target="#nav-pendientes"
            type="button" role="tab" aria-controls="nav-pendientes" aria-selected="false">
            Pendientes
          </button>

          <button class="nav-link" id="nav-observadas-tab" data-bs-toggle="tab" data-bs-target="#nav-observadas"
            type="button" role="tab" aria-controls="nav-observadas" aria-selected="false">
            Observadas
          </button>

          <button class="nav-link" id="nav-rechazadas-tab" data-bs-toggle="tab" data-bs-target="#nav-rechazadas"
            type="button" role="tab" aria-controls="nav-rechazadas" aria-selected="false">
            Rechazadas
          </button>
        </div>
      </nav>

      <!-- Tabla de contenidos -->
      <div class="tab-content" id="nav-tabContent">
        <!-- RENDIDAS -->
        <div class="tab-pane fade show active" id="nav-rendidas" role="tabpanel" aria-labelledby="nav-rendidas-tab"
          tabindex="0">
          <div class="table-responsive mt-3">
            <table id="table_id" class="table table-striped mx-auto">
              <thead>
                <tr>
                  <th class="text-center">
                    <i class="fas fa-sort me-1"></i> #
                  </th>
                  <th><i class="fas fa-sort me-1"></i> Fecha</th>
                  <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                  <th><i class="fas fa-sort me-1"></i> Organización</th>
                  <th><i class="fas fa-sort me-1"></i> Decreto</th>
                  <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                  <th><i class="fas fa-sort me-1"></i> Monto</th>
                  <th class="text-center">
                    <i class="fas fa-sort me-1"></i> Opciones
                  </th>
                </tr>
              </thead>
              <tbody>
                
                @foreach ($rendiciones as $item)
                <tr>
                  <td>{{$item->id}}</td>
                  <td>fecha</td>
                  <td>{{$item->rutOrganizacion}}</td>
                  <td>{{$item->nombreOrganizacion}}</td>
                  <td>{{$item->decreto}}</td>
                  <td>n° movimiento</td>
                  <td>{{$item->montoSubvencion}}</td>
                  <td class="td-5">
                    <div class="d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-accion btn-link align-baseline" data-bs-toggle="modal"
                        data-bs-target="#modalVer" title="Ver detalles" data-id="{{ $item->id }}">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>


        <!-- PESTAÑA PENDIENTES -->
        <div class="tab-pane fade" id="nav-pendientes" role="tabpanel" aria-labelledby="nav-pendientes-tab"
          tabindex="0">
          <div class="table-responsive mt-3">
            <table id="table_id" class="table table-striped mx-auto">
              <thead>
                <tr>
                  <th class="text-center">
                    <i class="fas fa-sort me-1"></i> #
                  </th>
                  <th><i class="fas fa-sort me-1"></i> Fecha</th>
                  <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                  <th><i class="fas fa-sort me-1"></i> Organización</th>
                  <th><i class="fas fa-sort me-1"></i> Decreto</th>
                  <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                  <th><i class="fas fa-sort me-1"></i> Monto</th>
                  <th class="text-center">
                    <i class="fas fa-sort me-1"></i> Opciones
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="td-5">4</td>
                  <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                  <td>66.666.666-6</td>
                  <td>JJVV Algarrobo 4</td>
                  <td>2025-458</td>
                  <td>346544</td>
                  <td class="monto" data-valor="80000">$80.000</td>
                  <td class="td-5">
                    <div class="d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-accion btn-link align-baseline" data-bs-toggle="modal"
                        data-bs-target="#modalVer" data-id="{{ $item->id }}">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="td-5">3</td>
                  <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                  <td>55.555.555-5</td>
                  <td>JJVV. Villa Quillayquen</td>
                  <td>2025-458</td>
                  <td>865501</td>
                  <td class="monto" data-valor="80000">$350.000</td>
                  <td class="td-5">
                    <div class="d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-accion btn-link align-baseline" data-bs-toggle="modal"
                        data-bs-target="#modalVer" data-id="{{ $item->id }}">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- OBSERVADAS -->
        <div class="tab-pane fade" id="nav-observadas" role="tabpanel" aria-labelledby="nav-observadas-tab"
          tabindex="0">
          <div class="table-responsive mt-3">
            <table id="table_id" class="table table-striped mx-auto">
              <thead>
                <tr>
                  <th class="text-center">
                    <i class="fas fa-sort me-1"></i>#
                  </th>
                  <th><i class="fas fa-sort me-1"></i> Fecha</th>
                  <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                  <th><i class="fas fa-sort me-1"></i> Organización</th>
                  <th><i class="fas fa-sort me-1"></i> Decreto</th>
                  <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                  <th><i class="fas fa-sort me-1"></i> Monto</th>
                  <th><i class="fas fa-sort me-1"></i> Opciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="td-5">4</td>
                  <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                  <td>66.666.666-6</td>
                  <td>JJVV Algarrobo 4</td>
                  <td>2025-458</td>
                  <td>346544</td>
                  <td class="monto" data-valor="80000">$80.000</td>
                  <td class="td-5">
                    <div class="d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-accion btn-link align-baseline" data-bs-toggle="modal"
                        data-bs-target="#modalVer" data-id="{{ $item->id }}">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td class="td-5">3</td>
                  <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                  <td>55.555.555-5</td>
                  <td>JJVV. Villa Quillayquen</td>
                  <td>2025-458</td>
                  <td>865501</td>
                  <td class="monto" data-valor="80000">$350.000</td>
                  <td class="td-5">
                    <div class="d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-accion btn-link align-baseline" data-bs-toggle="modal"
                        data-bs-target="#modalVer" data-id="{{ $item->id }}">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Encabezado principal -->

  <!-- Modal “Ver detalle” con dos pestañas internas -->
  <div class="modal fade" id="modalVer" tabindex="-1" aria-labelledby="modalVerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header modal-header-app">
          <h5 class="modal-title" id="modalVerLabel">Detalle de rendición</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <!-- Módulos de pestañas -->
        <div class="modal-body pb-0">
          <ul class="nav nav-tabs" id="innerTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active w-100" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                type="button" role="tab" aria-controls="tab1" aria-selected="true">
                Acciones
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link w-100" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
                role="tab" aria-controls="tab2" aria-selected="false">
                Notificaciones
              </button>
            </li>
          </ul>

          <!-- Contenido de tabs -->
          <div class="bg-white border rounded-4 p-3 shadow-sm" id="tabsBox">
            <div class="tab-content" id="innerTabsContent">
              <!-- Acciones -->
              <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                <div class="table-responsive mt-2">
                  <table class="table table-striped table-sm mb-0">
                    <colgroup>
                      <col style="width:8%" />
                      <col style="width:16%" />
                      <col style="width:12%" />
                      <col style="width:auto" />
                      <col style="width:18%" />
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><i class="fas fa-sort me-1"></i> #</th>
                        <th><i class="fas fa-sort me-1"></i> Fecha</th>
                        <th><i class="fas fa-sort me-1"></i> Hora</th>
                        <th><i class="fas fa-sort me-1"></i> Acción realizada</th>
                        <th><i class="fas fa-sort me-1"></i> Usuario</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center">91</td>
                        <td>20/04/2025</td>
                        <td>8:00</td>
                        <td>Rendición aprobada</td>
                        <td>Michelle Figueroa</td>
                      </tr>
                      <tr>
                        <td class="text-center">80</td>
                        <td>15/04/2025</td>
                        <td>8:30</td>
                        <td>Observada</td>
                        <td>Valentina Soto</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Notificaciones -->
              <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                <div class="table-responsive mt-2">
                  <table class="table table-striped table-sm mb-0">
                    <thead>
                      <tr>
                        <th><i class="fas fa-sort me-1"></i> #</th>
                        <th><i class="fas fa-sort me-1"></i> Fecha</th>
                        <th><i class="fas fa-sort me-1"></i> Hora</th>
                        <th><i class="fas fa-sort me-1"></i> Destino de recursos</th>
                        <th><i class="fas fa-sort me-1"></i> Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>25951</td>
                        <td>20/04/2025</td>
                        <td>8:00</td>
                        <td>Hoy vence el plazo para rendición</td>
                        <td>No leído</td>
                      </tr>
                      <tr>
                        <td>25810</td>
                        <td>15/04/2025</td>
                        <td>8:30</td>
                        <td>Recordatorio de plazo de vencimiento</td>
                        <td>Leído</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /modal-body -->

        <!-- Footer fuera del body, a todo el ancho -->
        <div class="modal-footer bg-light d-flex justify-content-end py-2 px-3">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1" data-bs-dismiss="modal">
            Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- /Modal Ver -->


  <!-- Modal Formulario -->
  <div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content shadow-lg rounded-4 overflow-hidden">
        <div class="modal-header modal-header-app">
          <h5 class="modal-title fw-bold" id="modalFormTitulo">Cargando...</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="form">
          <div class="modal-body p-4">
            <div class="container">
              <div class="p-4 rounded">
                <div class="mb-3">
                  <label for="titulo" class="form-label required fw-bold">Título</label>
                  <input type="text" class="form-control shadow-sm" id="titulo" name="titulo" required
                    placeholder="Ej: Educación Rancagua empoderado..." />
                </div>

                <div class="mb-3">
                  <label for="descripcion" class="form-label required fw-bold">Descripción</label>
                  <textarea class="form-control shadow-sm" id="descripcion" name="descripcion" rows="8" required
                    placeholder="Ej: Potenciar y fomentar la educación ambiental..."></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
            <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
              <i class="fa-solid fa-arrow-left me-2"></i>Cerrar
            </button>
            <button type="submit" class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnForm">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Modal Formulario -->

  <!-- Footer -->
  <div class="row fixed-bottom bg-light" style="border-top: 1px solid #eee">
    <div class="col-md-12">
      <footer class="footer" style="padding: 10px !important; margin: 0px !important; font-size: 14px">
        <p class="text-center" style="margin: 0px !important; font-size: 13px; color: #666">
          Departamento de Computación e Informática -
          <a style="color: #333" target="_blank" href="http://www.rancagua.cl">Ilustre Municipalidad de Rancagua</a>
        </p>
      </footer>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var modalElement = document.getElementById("modalForm");
    var modal = modalElement ? new bootstrap.Modal(modalElement) : null;

    document.querySelector("#btnModal")?.addEventListener("click", function () {
      modal && modal.show();
    });

    document.querySelector("#table_id")?.addEventListener("click", function (e) {
      if (e.target && e.target.matches("i.fa-pen-square")) {
        modal && modal.show();
      }
    });
  </script>


    
    <script src="detalle-rapido.js"></script>
    
    <script>
      var table;
      var modalElement = document.getElementById("modalForm");
      var modal = modalElement ? new bootstrap.Modal(modalElement) : null;

      document
        .querySelector("#btnModal")
        ?.addEventListener("click", function () {
          modal.show();
        });

      document
        .querySelector("#table_id")
        ?.addEventListener("click", function (e) {
          if (e.target && e.target.matches("i.fa-pen-square")) {
            modal.show();
          }
        });
    </script>
    <div class="row fixed-bottom bg-light" style="border-top: 1px solid #eee">
      <div class="col-md-12">
        
      </div>
    </div>
 


    <x-footer />


</x-app>
