<!-- Módulo para "Editar" con pestañas -->
<div aria-hidden="true" class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
        <div class="modal-content shadow-md rounded-4 overflow-hidden">
            <div class="modal-header modal-header-app">
                <h6 class="modal-title fw-bold">Editar subvención</h6>
                <button aria-label="Cerrar" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    type="button"></button>
            </div>
            <!-- cuerpo con layout consistente -->
            <div class="modal-body p-1 d-flex flex-column">
                <form id="formEditarSubvencion">
                    <input type="hidden" id="subvencion_id" name="id">
                    <div class="detalle-container visual border rounded m-1 p-1 bg-light flex-grow-1">
                        <!-- RUT y Organización separados -->
                        <div class="row mb-1 align-items-end">
                            <div class="col-sm-6">
                                <label class="col-sm-4 col-form-label fw-bold small" for="rut_editar">
                                    RUT Organización
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm shadow-sm" id="rut_editar" name="rut"
                                        type="text" placeholder="12.345.678-9" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-4 col-form-label fw-bold small" for="organizacion_editar">
                                    Organización
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm shadow-sm" id="organizacion_editar" name="nombre_organizacion"
                                        type="text" placeholder="Nombre de la organización" readonly disabled />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-1 align-items-end">
                            <div class="col-sm-6">
                                <label class="col-sm-4 col-form-label fw-bold small" for="decreto_editar">
                                    Nro decreto
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm shadow-sm" id="decreto_editar" name="numero_decreto"
                                        type="text" placeholder="324-2500"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-4 col-form-label fw-bold small" for="monto_editar">
                                    Monto
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input class="form-control form-control-sm shadow-sm" id="monto_editar" name="monto"
                                            type="number" placeholder="100000" min="1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1 align-items-end">
                            <div class="col-sm-6">
                                <label class="col-sm-4 col-form-label fw-bold small" for="fecha_decreto_editar">
                                    Fecha decreto
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm shadow-sm" id="fecha_decreto_editar" name="fecha_decreto"
                                        type="text" placeholder="dd/mm/AAAA">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-4 col-form-label fw-bold small" for="fecha_asignacion_editar">
                                    Fecha asignación
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm shadow-sm" id="fecha_asignacion_editar" name="fecha_asignacion"
                                        type="text" placeholder="dd/mm/AAAA"/>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-12">
                                <label class="col-sm-2 col-form-label fw-bold small" for="destino_editar">
                                    Destino
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm shadow-sm" id="destino_editar" name="destino" 
                                        rows="2" placeholder="Descripción del destino de la subvención" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- footer -->
            <div class="modal-footer border-top-0">
                <button data-bs-dismiss="modal" style="background: none; border: none; padding: 10px"
                    type="button">
                    Cancelar
                </button>
                <button class="btn btn-app px-4 py-2 rounded-pill shadow-sm" id="btnFormEditar"
                    type="button">
                    Editar datos de subvención
                </button>
            </div>
        </div>
    </div>
</div>
