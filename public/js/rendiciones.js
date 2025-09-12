/* Modal único para ver detalles de rendiciones */
var modalVerDetallesRendicion = document.getElementById("modalVerDetallesRendicion");
var modalRendicion = modalVerDetallesRendicion ? new bootstrap.Modal(modalVerDetallesRendicion) : null;

/* Función para mostrar detalles de rendición */
function mostrarDetalleRendicion(id, subvencionId = null) {
    // Llenar información básica de la rendición
    document.getElementById('informacion_rendicion').innerHTML = 
        `<i class="bi bi-clipboard-check me-1"></i>Rendición #${id}`;
    
    // Mostrar el modal
    if (modalRendicion) {
        modalRendicion.show();
    }
}

/* Detalle de rendición - Tabla Rendidas */
document.querySelector("#table_id")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        let subvencionId = e.target.getAttribute("data-subvencion");
        mostrarDetalleRendicion(id, subvencionId);
    }
});

/* Detalle de rendición - Tabla Pendientes */
document.querySelector("#table_pendientes")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        mostrarDetalleRendicion(id);
    }
});

/* Detalle de rendición - Tabla Observadas */
document.querySelector("#table_observadas")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        mostrarDetalleRendicion(id);
    }
});

/* Detalle de rendición - Tabla Rechazadas */
document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        mostrarDetalleRendicion(id);
    }
});

// Prueba Data tables - Pestaña Rendiciones
new DataTable('#table_rendiciones', {
    order: [],
    language: idioma ?? {},
    deferRender: true,
    responsive: true,
});

// Prueba Data Tables - Pestaña Pendientes //
new DataTable('#table_pendientes', {
    order: [],
    language: idioma ?? {},
    deferRender: true,
    responsive: true,
});

new DataTable('#table_observadas', {
    order: [],
    language: idioma ?? {},
    deferRender: true,
    responsive: true,
});

new DataTable('#table_rechazadas', {
    order: [],
    language: idioma ?? {},
    deferRender: true,
    responsive: true,
});