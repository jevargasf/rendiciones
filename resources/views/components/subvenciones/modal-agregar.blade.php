<!-- Modal: Agregar subvenciones -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="agregarLabel"   data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable">
    <form class="modal-content needs-validation" id="form" method="POST" enctype="multipart/form-data" novalidate>
      @csrf
      @method('POST')


      <div class="modal-header" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">
        <h5 id="modalFormTitulo" class="modal-title">Agregar subvenciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body p-4 bg-light">
        <div class="border rounded-4 p-3 bg-white shadow-sm">
          <div class="row g-3">

            <div class="col-12 col-md-6">
              <label for="fecha_decreto" class="form-label fw-bold">Fecha Decreto <span class="text-danger">*</span></label>
              <input type="date"
                    class="form-control"
                    id="fecha_decreto"
                    name="fecha_decreto"
                    required>
              <div class="invalid-feedback">La fecha del decreto es obligatoria.</div>
            </div>

            <div class="col-12 col-md-6">
              <label for="decreto" class="form-label fw-bold">N.º Decreto <span class="text-danger">*</span></label>
              <input type="text"
                    class="form-control"
                    id="decreto"
                    name="decreto"
                    required>
              <div class="invalid-feedback">El número de decreto es obligatorio.</div>
            </div>

            <div class="col-12">
              <label for="seleccionar_archivo" class="form-label fw-bold">Seleccione archivo <span class="text-danger">*</span></label>
              <input type="file"
                    class="form-control"
                    id="seleccionar_archivo"
                    name="seleccionar_archivo"
                    accept=".xlsx,.xls"
                    required>
              <div class="form-text">Formatos permitidos: XLSX/XLS.</div>
              <div class="invalid-feedback">Debes seleccionar un archivo válido.</div>
            </div>

          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="btnFormCargar" style="background: linear-gradient(135deg, var(--app-color), var(--app-color)); color: white;">Cargar subvenciones</button>
      </div>
    </form>
  </div>
</div>