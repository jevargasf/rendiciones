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
        const nombreCompleto = accion.km_nombre || 'Sistema';
        
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

/* Event listener para botón eliminar rendición temporalmente */
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-eliminar-rendicion')) {
        const button = e.target.closest('.btn-eliminar-rendicion');
        const rendicionId = button.getAttribute('data-rendicion-id');
        
        // Obtener datos de la rendición desde la fila
        const fila = button.closest('tr');
        const celdas = fila.querySelectorAll('td');
        
        // Llenar el modal con los datos de la rendición
        document.getElementById('eliminarRendicionNumero').textContent = celdas[0].textContent;
        document.getElementById('eliminarRendicionRut').textContent = celdas[2].textContent;
        document.getElementById('eliminarRendicionOrganizacion').textContent = celdas[3].textContent;
        document.getElementById('eliminarRendicionDecreto').textContent = celdas[4].textContent;
        document.getElementById('eliminarRendicionMonto').textContent = celdas[6].textContent;
        
        // Limpiar checkbox del modal
        document.getElementById('confirmarEliminacionRendicion').checked = false;
        document.getElementById('btnConfirmarEliminacionRendicion').disabled = true;
        
        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('modalEliminarRendicion'));
        modal.show();
        
        // Guardar el ID para usar después
        document.getElementById('btnConfirmarEliminacionRendicion').setAttribute('data-rendicion-id', rendicionId);
    }
});

/* Funcionalidad para habilitar/deshabilitar botón de confirmación */
document.addEventListener('change', function(e) {
    if (e.target.id === 'confirmarEliminacionRendicion') {
        const confirmado = e.target.checked;
        const btnConfirmar = document.getElementById('btnConfirmarEliminacionRendicion');
        
        btnConfirmar.disabled = !confirmado;
    }
});

/* Funcionalidad para el botón de confirmación de eliminación */
document.addEventListener('click', function(e) {
    if (e.target.id === 'btnConfirmarEliminacionRendicion') {
        const rendicionId = e.target.getAttribute('data-rendicion-id');
        
        if (rendicionId) {
            eliminarRendicionTemporalmente(rendicionId);
        }
    }
});

/* Función para eliminar rendición temporalmente */
function eliminarRendicionTemporalmente(id) {
    // Cerrar el modal primero
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarRendicion'));
    modal.hide();
    
    // Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Eliminando temporalmente...',
        text: 'Por favor espere',
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Realizar petición AJAX
    fetch('/rendiciones/eliminar-temporalmente', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value
        },
        body: JSON.stringify({
            id: id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            Swal.fire({
                title: '¡Eliminada correctamente!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(() => {
                // Recargar la página para actualizar la tabla
                window.location.reload();
            });
        } else {
            // Mostrar mensaje de error
            Swal.fire({
                title: 'Error',
                text: data.message || 'Error al eliminar temporalmente la rendición',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                allowOutsideClick: true,
                allowEscapeKey: true
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error de conexión. Por favor, intente nuevamente.',
            icon: 'error',
            confirmButtonText: 'Aceptar',
            allowOutsideClick: true,
            allowEscapeKey: true
        });
    });
}