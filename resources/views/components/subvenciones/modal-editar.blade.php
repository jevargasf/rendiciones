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
