<x-app title="Subvenciones">

    <x-header />
    <!-- Primer encabezado -->
    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">
                Subvenciones
                <a class="btn mb-1 font-weight-bold btn-app float-end" id="btnModal">
                    <i class="fa-solid fa-plus"></i> Agregar subvención
                </a>
            </h5>

            <!-- Tabla con datos -->
            <div class="table-responsive">
                <table class="table table-striped mx-auto" id="table_id">
                    <thead>
                        <tr>
                            <th class="text-center fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                #
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Fecha
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                R.U.T
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Organización
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Decreto
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Monto
                            </th>
                            <th class="fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Destino
                            </th>
                            <th class="text-center fw-normal">
                                <i class="fas fa-sort me-1"> </i>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subvenciones as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->fecha_asignacion ? \Carbon\Carbon::parse($item->fecha_asignacion)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->rut }}</td>
                                <td>{{ $item->organizacion }}</td>
                                <td>{{ $item->decreto }}</td>
                                <td>${{ number_format($item->monto, 0, ',', '.') }}</td>
                                <td>{{ $item->destino }}</td>
                                <td class="text-center" style="white-space: nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                        <!-- Ver detalles -->
                                        <button class="btn btn-accion" data-bs-target="#modalVerDetalles"
                                            data-bs-toggle="modal" title="Ver detalles" type="button">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                        <!-- Editar -->
                                        <button class="btn btn-succes btn-accion" data-bs-target="#modalEditar"
                                            data-bs-toggle="modal" title="Editar" type="button">
                                            <i class="fas fa-file-signature"> </i>
                                        </button>
                                        <!-- Rendir subvención -->
                                        <button class="btn btn-success btn-accion"
                                            data-bs-target="#modalRendirsubvencion" data-bs-toggle="modal"
                                            title="Rendir subvención" type="button">
                                            <i class="fas fa-clipboard-check icon-static-blue"></i>
                                        </button>
                                        <!-- Eliminar -->
                                        <button class="btn btn-success btn-accion" data-bs-target="#modalEliminar"
                                            data-bs-toggle="modal" title="Eliminar" type="button">
                                            <i class="fas fa-times-circle"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">No hay subvenciones</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            
            <!-- Módulo para "Ver Detalles" con pestañas -->
            <div class="modal fade" id="modalVerDetalles" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
                    <div class="modal-content shadow-md rounded-4 overflow-hidden">
                        <!-- Encabezado -->
                        <div class="modal-header modal-header-app">
                            <h6 class="modal-title fw-bold" id="modalVerDetallesLabel">
                                Detalle de subvención
                            </h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>

                        <!-- Información general -->
                        <div class="modal-body p-3 d-flex flex-column">
                            <label for="informacion_organizacion" class="form-label fw-bold"></label>
                            <p id="informacion_organizacion" class="form-control shadow-sm" readonly rows="4">
                                <i class="bi bi-people-fill me-1"></i>
                                (77.777.777-7) - JJVV. Diego Portales
                            </p>
                        </div>

                        <!-- Pestañas de detalles -->
                        <div class="modal-body p-0 detalle-container">
                            <!-- Navegación de pestañas -->
                            <ul class="nav nav-tabs bg-light px-3 pt-1" id="detalleTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab1" type="button" role="tab">
                                        Detalle de Subvención
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                        type="button" role="tab">
                                        Acciones realizadas
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                                        type="button" role="tab">
                                        Subvenciones anteriores
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab4-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab4" type="button" role="tab">
                                        Datos de la organización
                                    </button>
                                </li>
                            </ul>

                            <!-- Contenido de las pestañas -->
                            <div class="tab-content pt-4 px-4 pb-2">
                                <!-- Pestaña 1 -->
                                <div class="tab-pane fade active show" id="tab1" role="tabpanel">
                                    <div class="bg-white border rounded-4 p-3 mb-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-3">
                                                    <strong>Fecha Decreto:</strong>
                                                    <span class="dato-subrayado">29/05/2025</span>
                                                </p>
                                                <p class="mb-3">
                                                    <strong>N° Decreto:</strong>
                                                    <span class="dato-subrayado">2025-458</span>
                                                </p>
                                                <p class="mb-3">
                                                    <strong>Monto:</strong>
                                                    <span class="dato-subrayado">$80.000</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-3">
                                                    <strong>Fecha subida:</strong>
                                                    <span class="dato-subrayado">01/05/2025</span>
                                                </p>
                                                <p class="mb-3">
                                                    <strong>Usuario:</strong>
                                                    <span class="dato-subrayado">José Salgado</span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row mt-4 align-items-start">
                                            <label for="comentario_destino"
                                                class="col-sm-2 col-form-label fw-bold">Destino</label>
                                            <div class="col-sm-10">
                                                <textarea id="comentario_destino" class="form-control shadow-sm" rows="4" readonly>
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</textarea
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Pestaña 2 -->
                  <div class="tab-pane fade" id="tab2" role="tabpanel">
                    <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                      <div class="table-responsive">
                        <table
                          id="table_acciones_realizadas"
                          class="table table-striped"
                        >
                          <thead>
                            <tr>
                              <th class="text-center px-2">
                                <i class="fas fa-sort me-1"></i> Fecha
                              </th>
                              <th class="px-2">
                                <i class="fas fa-sort me-1"></i> Usuario
                              </th>
                              <th class="px-2">
                                <i class="fas fa-sort me-1"></i> Acción
                                realizada
                              </th>
                              <th class="px-2">
                                <i class="fas fa-sort me-1"></i> Detalle
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center px-2">25/05/2025</td>
                              <td class="px-2">Michelle Figueroa</td>
                              <td class="px-2">Recepcionada correctamente</td>
                              <td>
                                <button
                                  type="button"
                                  title="Ver detalles"
                                  class="btn btn-accion btn-ver-detalle-rapido d-flex justify-content-center align-items-center"
                                  style="
                                    width: 2.5rem;
                                    height: 2.5rem;
                                    padding: 0;
                                  "
                                >
                                  <i
                                    class="bi bi-search border-0 p-0 text-dark"
                                  ></i>
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-center px-2">20/04/2025</td>
                              <td class="px-2">Valentina Soto</td>
                              <td class="px-2">Objetada</td>
                              <td>
                                <button
                                  type="button"
                                  title="Ver detalles"
                                  class="btn btn-accion btn-ver-detalle-rapido d-flex justify-content-center align-items-center"
                                  style="
                                    width: 2.5rem;
                                    height: 2.5rem;
                                    padding: 0;
                                  "
                                >
                                  <i
                                    class="bi bi-search border-0 p-0 text-dark"
                                  ></i>
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <!-- Overlay detalle acción -->
                  <div id="ver-detalle" class="overlay-detalle d-none">
                    <div
                      class="detalle-box modal-content shadow-md rounded-4 overflow-hidden"
                    >
                      <div class="modal-header modal-header-app">
                        <h6 class="modal-title fw-bold">Detalle de acción</h6>
                        <button
                          type="button"
                          class="btn-close btn-close-white"
                          onclick="cerrarDetalle()"
                          aria-label="Cerrar"
                        ></button>
                      </div>
                      <div class="p-4">
                        <p>
                          <strong>Usuario:</strong>
                          <span id="detalle-usuario">—</span>
                        </p>
                        <div class="row mt-4 align-items-start">
                          <label
                            for="detalle-comentario"
                            class="col-sm-2 col-form-label fw-bold"
                            >Comentario</label
                          >
                          <div class="col-sm-10">
                            <textarea
                              id="detalle-comentario"
                              class="form-control"
                              rows="4"
                              readonly
                              placeholder="Lorem ipsum…"
                            ></textarea>
                                            </div>
                                        </div>
                                        <div class="text-muted small mt-4">
                                            <span id="detalle-fecha">Fecha: —</span>
                                            <span class="mx-2">|</span>
                                            <span id="detalle-hora">Hora: —</span>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="cerrarDetalle()">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña 3 -->
                            <div class="tab-pane fade" id="tab3" role="tabpanel">
                                <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                                    <div class="table-responsive">
                                        <table id="table_subvenciones_anteriores" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center px-2">
                                                        <i class="fas fa-sort me-1"></i>#
                                                    </th>
                                                    <th class="text-center px-2">
                                                        <i class="fas fa-sort me-1"></i>Fecha
                                                    </th>
                                                    <th class="px-2">
                                                        <i class="fas fa-sort me-1"></i>Decreto
                                                    </th>
                                                    <th class="px-2">
                                                        <i class="fas fa-sort me-1"></i>Nro. Movimiento
                                                    </th>
                                                    <th class="px-2">
                                                        <i class="fas fa-sort me-1"></i>Monto
                                                    </th>
                                                    <th class="px-2">
                                                        <i class="fas fa-sort me-1"></i>Destino
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center px-2">4</td>
                                                    <td>29/05/2025</td>
                                                    <td class="px-2">2025-458</td>
                                                    <td class="px-2">12346</td>
                                                    <td class="px-2">$80.000</td>
                                                    <td class="px-2">Elementos para sede</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center px-2">3</td>
                                                    <td>29/05/2025</td>
                                                    <td class="text px-2">2025-458</td>
                                                    <td class="text px-2">45678</td>
                                                    <td class="text px-2">$35.000</td>
                                                    <td class="text px-2">Compra de elementos x</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center px-2">2</td>
                                                    <td>25/04/2025</td>
                                                    <td class="text px-2">2024-15</td>
                                                    <td class="text px-2">90123</td>
                                                    <td class="text px-2">$300.000</td>
                                                    <td class="text px-2">
                                                        Subvención relacionada a motivo x
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center px-2">1</td>
                                                    <td>20/04/2025</td>
                                                    <td class="text px-2">2025-5</td>
                                                    <td class="text px-2">45678</td>
                                                    <td class="text px-2">$50.000</td>
                                                    <td class="text px-2">
                                                        Subvención relacionada a motivo y
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Pestaña 4 -->
                            <div class="tab-pane fade" id="tab4" role="tabpanel">
                                <div class="bg-white border rounded-4 p-3 mb-0 min-vh-50">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Datos de la organización</strong></p>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>PJ Municipal</td>
                                                        <td>350-2025</td>
                                                    </tr>
                                                    <tr>
                                                        <td>PJ Registro Civil</td>
                                                        <td>283465</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nombre</td>
                                                        <td>Junta de Vecinos Población X</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dirección</td>
                                                        <td>República de Chile 2323</td>
                                                    </tr>
                                                    <tr>
                                                        <td>RUT</td>
                                                        <td>69.876.321-0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tipo</td>
                                                        <td>Territorial</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Teléfono</td>
                                                        <td>+5695556623</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E-mail</td>
                                                        <td>jjvv.poblacionx@gmail.com</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <p><strong>Directiva vigente</strong></p>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Presidente</td>
                                                        <td>5.210.559-0</td>
                                                        <td>María José Lucero</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tesorero</td>
                                                        <td>7.890.110-8</td>
                                                        <td>Pedro Pablo Robles</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Secretario</td>
                                                        <td>10.580.890-1</td>
                                                        <td>Miguel Arias</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br />
                                            <p><strong>Comisión Electoral</strong></p>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>5.210.559-0</td>
                                                        <td>María José Lucero</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7.890.110-8</td>
                                                        <td>Pedro Pablo Robles</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10.580.890-1</td>
                                                        <td>Miguel Arias</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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

        <!-- Módulo para "Editar" con pestañas -->
        <div aria-hidden="true" class="modal fade" id="modalEditar" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
                <div class="modal-content shadow-md rounded-4 overflow-hidden">
                    <div class="modal-header modal-header-app">
                        <h6 class="modal-title fw-bold">Editar subvención</h6>
                        <button aria-label="Cerrar" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            type="button"></button>
                    </div>
                    <!-- cuerpo con layout consistente -->
                    <div class="modal-body p-3 d-flex flex-column">
                        <div class="detalle-container visual border rounded m-3 p-3 bg-light flex-grow-1">
                            <div class="row mt-2 mb-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">
                                        <i class="bi bi-people-fill"> </i>
                                    </span>
                                    <input class="form-control form-control-sm" id="Nro_Decreto" readonly=""
                                        type="text" value="(77.777.777-7) - JJVV Diego Portales" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 col-form-label fw-bold small" for="Nro_Decreto_num">
                                    Nro decreto
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control form-control-sm shadow-sm" id="Nro_Decreto_num"
                                        readonly="" value="324-2500" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label class="col-sm-2 col-form-label fw-bold small" for="comentario_editar">
                                    Destino
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm shadow-sm" id="comentario_editar" readonly="" rows="3">
Lorem ipsum is simply dummy text of the typesetting industry.</textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 col-form-label fw-bold small" for="Monto">
                                    Monto
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control form-control-sm shadow-sm" id="Monto"
                                        readonly="" value="$100.000" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer -->
                    <div class="modal-footer border-top-0">
                        <button data-bs-dismiss="modal" style="background: none; border: none; padding: 10px"
                            type="button">
                            Cancelar
                        </button>
                        <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnFormEditar"
                            type="submit">
                            Editar datos de subvención
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Módulo para "Rendir Subvención" con pestañas -->
        <div aria-hidden="true" class="modal fade" id="modalRendirsubvencion" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
                <div class="modal-content shadow-md rounded-4 overflow-hidden">
                    <div class="modal-header modal-header-app">
                        <h6 class="modal-title fw-bold">Rendir Subvención</h6>
                        <button aria-label="Cerrar" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            type="button"></button>
                    </div>

                    <div class="border rounded m-3 p-3 bg-light flex-grow-1">
                        <div class="row mt-2 mb-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                                <input class="form-control form-control-sm" id="Nro_Decreto_rendir" readonly
                                    type="text" value="(77.777.777-7) - JJVV Diego Portales" />
                            </div>
                        </div>

                        <p class="fw-bold medium">Datos de persona que rinde</p>
                        <!-- INDENTACIÓN -->
                        <div class="ps-3 ps-sm-4 ps-md-5">
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <div class="d-flex align-items-center">
                                    <label class="fw-bold mb-0 me-2" for="Rinde_num">Rinde</label>
                                    <input class="form-control form-control-sm shadow-sm ind-rinde" id="Rinde_num"
                                        readonly style="min-width: 160px" value="16.492.655-7" />
                                </div>
                                <div class="d-flex align-items-center">
                                    <input class="form-control form-control-sm shadow-sm" id="Rinde_nombre" readonly4
                                        style="min-width: 200px" value="Adriana Castro" />
                                </div>
                                <div class="d-flex align-items-center">
                                    <select class="form-select form-select-sm shadow-sm" id="Cargo"
                                        style="min-width: 160px">
                                        <option value="">Seleccione...</option>
                                        <option value="admin">Presidente</option>
                                        <option value="editor">Tesorero/a</option>
                                        <option value="revisor">Secretario/a</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <div class="d-flex align-items-center">
                                    <label class="fw-bold mb-0 me-2 text-nowrap" for="email">E-mail</label>
                                    <input class="form-control form-control-sm shadow-sm shift-input" id="email"
                                        readonly style="min-width: 250px" value="adriana@example.com" />
                                </div>
                                <div class="d-flex align-items-center">
                                    <label class="fw-bold mb-0 me-2" for="telefono">Teléfono</label>
                                    <input class="form-control form-control-sm shadow-sm" id="telefono" readonly
                                        style="min-width: 160px" value="+569 33224455" />
                                </div>
                            </div>
                        </div>
                        <!-- /INDENTACIÓN -->

                        <p class="fw-bold medium mt-3">Datos de rendición</p>
                        <!-- INDENTACIÓN -->
                        <div class="ps-3 ps-sm-4 ps-md-5">
                            <div class="row gy-2 gx-0 align-items-start mt-2">
                                <div class="col-12 col-sm-2 col-form-label fw-bold small mb-0">
                                    <label for="comentario_rendicion"
                                        class="col-form-label fw-bold small mb-0">Destino</label>
                                </div>
                                <div class="col-12 col-sm-10 ps-0 pull-left-sm pull-left-md">
                                    <textarea id="comentario_rendicion" class="form-control form-control-sm shadow-sm" rows="3" readonly>Detalle en extenso del uso de los fondos</textarea>
                                </div>

                            </div>

                            <div class="row gy-2 gx-0 align-items-start mt-2">
                                <label for="comentario_detalle"
                                    class="col-12 col-sm-2 col-form-label fw-bold small mb-0">
                                    Detalle</label>
                                <div class="col-12 col-sm-10 ps-0 pull-left-sm pull-left-md">
                                    <textarea class="form-control form-control-sm shadow-sm" id="comentario_detalle" readonly rows="3">Descripción que se desee comentar o detalle de documentos adjuntos que serán validados</textarea>
                                </div>
                            </div>

                            <div class="row gy-2 gx-0 align-items-start mt-2">
                                <label for="Estado"
                                    class="col-12 col-sm-2 col-form-label fw-bold small mb-0">Estado</label>
                                <div class="col-12 col-sm-10 ps-0 pull-left-sm pull-left-md">
                                    <select id="Estado" class="form-select form-select-sm shadow-sm"
                                        style="max-width: 250px">
                                        <option value="">Seleccione...</option>
                                        <option value="recepcionada">Recepcionada</option>
                                        <option value="con_observacion">Con observación</option>
                                        <option value="objetada">Objetada</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /INDENTACIÓN -->
                        </div>

                        <div class="modal-footer border-0">
                            <button data-bs-dismiss="modal" style="background: none; border: none; padding: 10px"
                                type="button">
                                Cancelar
                            </button>
                            <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnFormRendir"
                                type="submit">
                                Guardar datos de rendición
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Módulo para "Eliminar" con pestañas -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 500px">
                    <div class="modal-content shadow-md rounded-4 overflow-hidden">
                        <div class="modal-header modal-header-app">
                            <h6 class="modal-title fw-bold" id="modalEliminarLabel">
                                Eliminar subvención
                            </h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="mb-0">¿Está seguro/a de eliminar esta subvención?</p>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" data-bs-dismiss="modal"
                                style="background: none; border: none; padding: 10px">
                                Cancelar
                            </button>

                            <button id="btnConfirmarEliminar"
                                class="btn btn-app btn-eliminar px-4 py-2 rounded-pill shadow-sm" type="button">
                                Sí, eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- FIN Opciones de cuadro subvenciones en tabla -->
        </div>
    </div>
    <!-- Botón para agregar subvenciones -->
    <div aria-hidden="true" class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-md rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="modalFormTitulo">
                        Agregar subvenciones
                    </h5>
                    <button aria-label="Close" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        type="button"></button>
                </div>
                <form id="form" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body p-4">
                        <div class="container">
                            <div class="p-4 rounded">
                                <div class="row mb-3 align-items-center">
                                    <label class="col-sm-3 col-form-label fw-bold" for="fecha_decreto">
                                        Fecha Decreto
                                        <span class="text-danger"> * </span>
                                    </label>
                                    <div class="col-sm-3">
                                        <input class="form-control shadow-sm" id="fecha_decreto" name="fecha_decreto"
                                            placeholder="Ej: 29/05/2025" required="" type="date" />
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label class="col-sm-3 col-form-label fw-bold" for="numero_decreto">
                                        N.° Decreto
                                        <span class="text-danger"> * </span>
                                    </label>
                                    <div class="col-sm-3">
                                        <input class="form-control shadow-sm" id="numero_decreto"
                                            name="numero_decreto" placeholder="Ej: 2025-458" required=""
                                            type="text" />
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label class="col-sm-3 col-form-label fw-bold" for="seleccionar_archivo">
                                        Seleccione archivo
                                        <span class="text-danger"> * </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input class="form-control shadow-sm custom-file" id="seleccionar_archivo"
                                            name="seleccionar_archivo" type="file" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                        <button class="btn btn-outline-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal"
                            type="button">
                            <i class="fa-solid fa-arrow-left me-2"> </i>
                            Cancelar
                        </button>
                        <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnFormCargar"
                            type="submit">
                            Cargar subvenciones
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('show.bs.modal', function(e) {

            const idsQueMuevo = ['modalEliminar', 'modalRendirsubvencion'];

            if (idsQueMuevo.includes(e.target.id)) {

                if (e.target.parentElement !== document.body) {
                    document.body.appendChild(e.target);
                }
            }
        });
    </script>

    <script src="{{ asset('js/subvenciones.js') }}" defer></script>


    <script>
        /*
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
                            });  */
    </script>
    <div class="row fixed-bottom bg-light" style="border-top: 1px solid #eee">
        <div class="col-md-12">

        </div>
    </div>






















    <x-footer />


</x-app>
