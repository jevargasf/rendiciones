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
                            <input class="form-control form-control-sm shadow-sm" id="Rinde_nombre" readonly
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
</div>
