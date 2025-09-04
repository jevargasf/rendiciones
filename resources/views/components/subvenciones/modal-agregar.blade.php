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
