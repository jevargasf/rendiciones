<!-- Botón para agregar subvenciones -->
<div aria-hidden="true" class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="--bs-modal-width:min(640px, 92vw)">
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
                    <div class="container-fluid">
                        <div class="p-4 rounded form-horizontal-fixed">
                             <!-- Fecha Decreto -->
                            <div class="row tight flex-nowrap align-items-center mb-3">
                                <label for="fecha_decreto" class="col-label fw-bold" >
                                    Fecha Decreto
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-field">
                                    <input class="form-control form-control-sm input-compact-220" id="fecha_decreto" name="fecha_decreto"
                                        placeholder="Ej: 29/05/2025" required="" type="date" />
                                </div>
                            </div>
                            <div class="row tight flex-nowrap align-items-center mb-3">
                                <label class="col-label fw-bold mb-0" for="numero_decreto">
                                    N.° Decreto
                                    <span class="text-danger"> * </span>
                                </label>
                                <div class="col-field">
                                    <input class="form-control form-control-sm input-compact-220" id="numero_decreto"
                                        name="numero_decreto" placeholder="Ej: 2025-458" required=""
                                        type="text" />
                                </div>
                            </div>

                            <!--Archivo-->

                            <div class="row tight flex-nowrap align-items-center mb-3 label-archivo-180 responsive-break">
                                <label class="col-label fw-bold" for="seleccionar_archivo">
                                    Seleccione archivo
                                    <span class="text-danger"> * </span>
                                </label>
                                <div class="col-field">
                                    <input class="form-control form-control-sm shadow-sm input-file-350" id="seleccionar_archivo"
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
