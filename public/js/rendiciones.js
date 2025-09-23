var modalRendicion = new bootstrap.Modal(document.getElementById("modalVerDetallesRendicion"));

/* Función para mostrar detalles de rendición */
function verDetalleRendicion(id, button) {
        // Obtener token CSRF
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Si no se encuentra en meta, buscar en inputs
        if (!csrfToken) {
            csrfToken = document.querySelector('input[name="_token"]')?.value;
        }
        
        // Si aún no se encuentra, usar jQuery si está disponible
        if (!csrfToken && typeof $ !== 'undefined') {
            csrfToken = $('meta[name="csrf-token"]').attr('content');
        }
        
        if (!csrfToken) {
            console.error('No se pudo obtener el token CSRF');
            Swal.fire({
                title: "Error",
                text: "Error de configuración: No se pudo obtener el token de seguridad",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
            return;
        } 
    // Obtener datos de la subvención
    fetch(`${window.apiBaseUrl}rendiciones/obtener`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if(data.rendicion.subvencion.data_organizacion.error){
                document.getElementById('informacion_organizacion').innerText = `(${data.renducion.subvencion.rut})`;
            }else{
                document.getElementById('informacion_organizacion').innerText = `(${data.rendicion.subvencion.rut}) ${data.rendicion.subvencion.data_organizacion.nombre_organizacion}`;
            }
            // rendición con data subvención y organización
            document.getElementById('rendicion_id').value = data.rendicion.id;
            document.getElementById('detalle_fecha_decreto').textContent = data.rendicion.subvencion.fecha_decreto;
            document.getElementById('detalle_decreto').textContent = data.rendicion.subvencion.decreto;
            document.getElementById('detalle_monto').textContent = data.rendicion.subvencion.monto;

            document.getElementById('detalle_fecha_asignacion').textContent = data.rendicion.subvencion.fecha_asignacion;
            document.getElementById('detalle_destino').textContent = data.rendicion.subvencion.destino;
            document.getElementById('detalle_estado_actual').textContent = data.rendicion.estado_rendicion.nombre;

            const estadosSelect = document.getElementById('estados_rendicion');
            const comentario = document.getElementById('comentario_detalle')
            const btnCambiarEstado = document.getElementById('btnCambiarEstado')

            // si la tabla es en revisión u objetadas, renderizar select de cambio de estado
            if(button.dataset.btnEstado == 'revision' || button.dataset.btnEstado == 'objetadas'){
                // select de estados rendición
                btnCambiarEstado.hidden = false
                estadosSelect.disabled = false
                comentario.disabled = false
                estadosSelect.innerHTML = '<option value="">Seleccione...</option>';
                data.estados_rendicion.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.id;
                    option.textContent = estado.nombre;
                    estadosSelect.appendChild(option);
                });
            }else{
                btnCambiarEstado.hidden = true
                estadosSelect.disabled = true
                comentario.disabled = true
            }

            document.addEventListener('shown.bs.tab', (e)=>{
                if (e.target.id === 'tab2-rendicion-tab'){
                    console.log($.fn.dataTable.ext)
                    if ($.fn.DataTable.isDataTable('#table_acciones_rendicion')) {
                        $('#table_acciones_rendicion').DataTable().destroy();
                    }
                    // tabla acciones rendición
                    new DataTable('#table_acciones_rendicion', {
                        data: data.rendicion.acciones,
                        searching: false,
                        lengthChange: false,
                        order: [],
                        language: idioma ?? {},
                        deferRender: true,
                        autoWidth: false,
                        responsive: true,
                        paging: false,
                        order: [[ 1, 'desc' ], [ 2, 'desc' ]],
                        columns: [
                            { data: 'id' },
                            { 
                                data: 'fecha',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString()
                                }
                            },
                            { 
                                data: 'fecha',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleTimeString('es-CL', {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: false
                                    })
                                }
                            },
                            { data: 'estado_rendicion' },
                            { data: 'comentario' },
                            { data: 'km_nombre' }
                        ]
                    });
                } else if (e.target.id === 'tab3-rendicion-tab') {
                    if ($.fn.DataTable.isDataTable('#table_notificaciones_rendicion')) {
                        $('#table_notificaciones_rendicion').DataTable().destroy();
                    }
                    console.log($.fn.dataTable.ext.search)
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex, rowData, counter) {
                        // Accede directamente al objeto de datos completo (si está disponible)
                        const notificacion_row = rowData?.notificacion;
                        
                        // Solo mostrar si nombre no es nulo, undefined ni cadena vacía
                        return !!notificacion_row;
                    });

                    // tabla acciones rendición
                    new DataTable('#table_notificaciones_rendicion', {
                        data: function () {
                                // Filtrar solo las acciones que tengan notificación
                                return data.rendicion.acciones.filter(fila => fila.notificacion);
                            }(),
                        searching: false,
                        lengthChange: false,
                        language: idioma ?? {},
                        deferRender: true,
                        autoWidth: false,
                        responsive: true,
                        paging: false,
                        order: [[ 0, 'desc' ], [ 1, 'desc' ]],
                        columns: [
                            { data: 'notificacion.id' },
                            { 
                                data: 'notificacion.fecha_envio',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString()
                                }
                            },
                            { 
                                data: 'notificacion.fecha_envio',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleTimeString('es-CL', {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: false
                                    })
                                }
                            },
                            { 
                                data: 'notificacion.estado_notificacion',
                                render: function(d){
                                    if (!d) return 'No leído';
                                }
                            },
                            { 
                                data: 'notificacion.fecha_lectura',
                                render: function(d){
                                    if (!d) return 'N/A';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString({
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                }
                            },
                            { 
                                data: 'notificacion.fecha_lectura',
                                render: function(d){
                                    if (!d) return 'N/A';
                                    fecha = new Date(d)
                                    return fecha.toLocaleTimeString()
                                }
                            },
                        ]
                    });


                }


            })






        } else {
            Swal.fire({
                title: "Error",
                text: data.message || "Error al cargar los datos de la rendición",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        }
    })
    .catch (error =>
        {console.error('Error:', error);
        // Mostrar mensaje de error en las tablas
        document.getElementById('tbody_acciones_rendicion').innerHTML = 
            '<tr><td colspan="5" class="text-center text-muted">Error al cargar las acciones</td></tr>';
        document.getElementById('tbody_notificaciones_rendicion').innerHTML = 
            '<tr><td colspan="5" class="text-center text-muted">Error al cargar las notificaciones</td></tr>';
    })
    
    // Mostrar el modal
    if (modalRendicion) {
        modalRendicion.show();
    }
}

document.getElementById('btnCambiarEstado').addEventListener('click', async function(event) {
    event.preventDefault();

    // Obtener token CSRF
    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        csrfToken = document.querySelector('input[name="_token"]')?.value;
    }
    
    if (!csrfToken && typeof $ !== 'undefined') {
        csrfToken = $('meta[name="csrf-token"]').attr('content');
    }
    
    if (!csrfToken) {
        console.error('No se pudo obtener el token CSRF');
        Swal.fire({
            title: "Error",
            text: "Error de configuración: No se pudo obtener el token de seguridad",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
        return;
    }

    try{
        data_estado = {
            nuevo_estado_id: document.getElementById('estados_rendicion').value,
            comentario: document.getElementById('comentario_detalle').value,
            id: document.getElementById('rendicion_id').value
        }

        const response = await fetch(`${window.apiBaseUrl}rendiciones/cambiar-estado`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data_estado)
            });

        const resultCambioEstado = await response.json();
        
        if (!response.ok || !resultCambioEstado.success) {
            Swal.fire({
                title: "Error",
                text: resultCambioEstado.message || "Error al cambiar el estado de la rendición",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        } else {
            Swal.fire({
                title: "Éxito",
                text: resultCambioEstado.message,
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                // Cerrar modal y recargar página
                //const modalRendir = bootstrap.Modal.getInstance(document.getElementById('modalRendirsubvencion'));
                //modalRendir.hide();
                window.location.reload();
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error inesperado al enviar los datos",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    }
})
/* Función para llenar la tabla de acciones */
// function llenarTablaAcciones(acciones) {
//     const tbody = document.getElementById('tbody_acciones_rendicion');
    
//     if (acciones.length === 0) {
//         tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay acciones registradas</td></tr>';
//         return;
//     }
    
//     let html = '';
//     acciones.forEach((accion, index) => {
//         const fecha = new Date(accion.fecha);
//         const fechaFormateada = fecha.toLocaleDateString('es-ES');
//         const horaFormateada = fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
//         const nombreCompleto = accion.km_nombre || 'Sistema';
        
//         html += `
//             <tr>
//                 <td class="text-center px-2">${index + 1}</td>
//                 <td class="text-center px-2">${fechaFormateada}</td>
//                 <td class="px-2">${horaFormateada}</td>
//                 <td class="px-2">${accion.estado_rendicion}</td>
//                 <td class="px-2">${accion.comentario || 'Sin comentario'}</td>
//                 <td class="px-2">${nombreCompleto}</td>
//             </tr>
//         `;
//     });
    
//     tbody.innerHTML = html;
// }

/* Función para llenar la tabla de notificaciones */
// function llenarTablaNotificaciones(notificaciones) {
//     const tbody = document.getElementById('tbody_notificaciones_rendicion');
    
//     if (notificaciones.length === 0) {
//         tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay notificaciones registradas</td></tr>';
//         return;
//     }
    
//     let html = '';
//     notificaciones.forEach((notificacion, index) => {
//         const fecha = new Date(notificacion.fecha_envio);
//         const fechaFormateada = fecha.toLocaleDateString('es-ES');
//         const horaFormateada = fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
//         const estadoBadge = notificacion.fecha_lectura ? 
//             '<span class="badge bg-success">Leído</span>' : 
//             '<span class="badge bg-warning">No leído</span>';
        
//         html += `
//             <tr>
//                 <td class="text-center px-2">${notificacion.id}</td>
//                 <td class="text-center px-2">${fechaFormateada}</td>
//                 <td class="px-2">${horaFormateada}</td>
//                 <td class="px-2">Notificación</td>
//                 <td class="px-2">${estadoBadge}</td>
//             </tr>
//         `;
//     });
    
//     tbody.innerHTML = html;
// }

// /* Detalle de rendición - Tabla Rendidas */
// document.querySelector("#table_id")?.addEventListener("click", async function (e) {
//     if (e.target && e.target.matches("i.fa-search")) {
//         let id = e.target.getAttribute("data-id");
//         let subvencionId = e.target.getAttribute("data-subvencion");
//         mostrarDetalleRendicion(id, subvencionId);
//     }
// });

// /* Detalle de rendición - Tabla Pendientes */
// document.querySelector("#table_pendientes")?.addEventListener("click", async function (e) {
//     if (e.target && e.target.matches("i.fa-search")) {
//         let id = e.target.getAttribute("data-id");
//         mostrarDetalleRendicion(id);
//     }
// });

// /* Detalle de rendición - Tabla Observadas */
// document.querySelector("#table_observadas")?.addEventListener("click", async function (e) {
//     if (e.target && e.target.matches("i.fa-search")) {
//         let id = e.target.getAttribute("data-id");
//         mostrarDetalleRendicion(id);
//     }
// });

// /* Detalle de rendición - Tabla Rechazadas */
// document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e) {
//     if (e.target && e.target.matches("i.fa-search")) {
//         let id = e.target.getAttribute("data-id");
//         mostrarDetalleRendicion(id);
//     }
// });

/* Event listener para botón eliminar rendición */
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-eliminar-rendicion')) {
        const button = e.target.closest('.btn-eliminar-rendicion');
        const rendicionId = button.getAttribute('data-rendicion-id');
        
        // Obtener datos de la rendición desde la fila
        const fila = button.closest('tr');
        const celdas = fila.querySelectorAll('td');
        
        // // Llenar el modal con los datos de la rendición
        document.getElementById('eliminarRendicionNumero').textContent = celdas[0].textContent;
        document.getElementById('eliminarRendicionRut').textContent = celdas[2].textContent;
        document.getElementById('eliminarRendicionOrganizacion').textContent = celdas[3].textContent;
        document.getElementById('eliminarRendicionDecreto').textContent = celdas[4].textContent;
        document.getElementById('eliminarRendicionMonto').textContent = celdas[6].textContent;
        
        // // Limpiar checkbox del modal
        document.getElementById('confirmarEliminacionRendicion').checked = false;
        document.getElementById('btnConfirmarEliminacionRendicion').disabled = true;
        
        // // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('modalEliminarRendicion'));
        modal.show();
        
        // // Guardar el ID para usar después
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

/* Función para eliminar rendición */
function eliminarRendicionTemporalmente(id) {
    // Cerrar el modal primero
    console.log("llegó acá")
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarRendicion'));
    modal.hide();
    
    // Mostrar SweetAlert de carga
    Swal.fire({
        title: 'Eliminando...',
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
    fetch('/rendiciones/eliminar', {
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
                text: data.message || 'Error al eliminar la rendición',
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

