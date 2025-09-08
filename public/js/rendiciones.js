/* Modal único para ver detalles de rendiciones */
var modalVerDetallesRendicion = document.getElementById("modalVerDetallesRendicion");
var modalRendicion = modalVerDetallesRendicion ? new bootstrap.Modal(modalVerDetallesRendicion) : null;

/* Función para mostrar detalles de rendición */
async function mostrarDetalleRendicion(id, subvencionId = null) {
    // Llenar información básica de la rendición
    document.getElementById('informacion_rendicion').innerHTML = 
        `<i class="bi bi-clipboard-check me-1"></i>Rendición #${id}`;
    
    // Limpiar tablas
    document.getElementById('tbody_acciones_rendicion').innerHTML = '';
    document.getElementById('tbody_notificaciones_rendicion').innerHTML = '';
    
    try {
        // Obtener datos de la rendición
        const response = await fetch(`/rendiciones/detalleRendicion?id=${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (!response.ok) {
            throw new Error('Error al obtener los detalles de la rendición');
        }
        
        const data = await response.json();
        
        // Llenar tabla de acciones
        llenarTablaAcciones(data.acciones);
        
        // Llenar tabla de notificaciones
        llenarTablaNotificaciones(data.notificaciones);
        
    } catch (error) {
        console.error('Error:', error);
        // Mostrar mensaje de error en las tablas
        document.getElementById('tbody_acciones_rendicion').innerHTML = 
            '<tr><td colspan="5" class="text-center text-muted">Error al cargar las acciones</td></tr>';
        document.getElementById('tbody_notificaciones_rendicion').innerHTML = 
            '<tr><td colspan="5" class="text-center text-muted">Error al cargar las notificaciones</td></tr>';
    }
    
    // Mostrar el modal
    if (modalRendicion) {
        modalRendicion.show();
    }
}

/* Función para llenar la tabla de acciones */
function llenarTablaAcciones(acciones) {
    const tbody = document.getElementById('tbody_acciones_rendicion');
    
    if (acciones.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay acciones registradas</td></tr>';
        return;
    }
    
    let html = '';
    acciones.forEach((accion, index) => {
        const fecha = new Date(accion.fecha);
        const fechaFormateada = fecha.toLocaleDateString('es-ES');
        const horaFormateada = fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        const nombreCompleto = accion.persona ? `${accion.persona.nombre} ${accion.persona.apellido}` : 'Sistema';
        
        html += `
            <tr>
                <td class="text-center px-2">${index + 1}</td>
                <td class="text-center px-2">${fechaFormateada}</td>
                <td class="px-2">${horaFormateada}</td>
                <td class="px-2">${accion.comentario || 'Sin comentario'}</td>
                <td class="px-2">${nombreCompleto}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

/* Función para llenar la tabla de notificaciones */
function llenarTablaNotificaciones(notificaciones) {
    const tbody = document.getElementById('tbody_notificaciones_rendicion');
    
    if (notificaciones.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay notificaciones registradas</td></tr>';
        return;
    }
    
    let html = '';
    notificaciones.forEach((notificacion, index) => {
        const fecha = new Date(notificacion.fecha_envio);
        const fechaFormateada = fecha.toLocaleDateString('es-ES');
        const horaFormateada = fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        const estadoBadge = notificacion.fecha_lectura ? 
            '<span class="badge bg-success">Leído</span>' : 
            '<span class="badge bg-warning">No leído</span>';
        
        html += `
            <tr>
                <td class="text-center px-2">${notificacion.id}</td>
                <td class="text-center px-2">${fechaFormateada}</td>
                <td class="px-2">${horaFormateada}</td>
                <td class="px-2">Notificación</td>
                <td class="px-2">${estadoBadge}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
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