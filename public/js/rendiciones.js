function closeAllModalsExcept(excludedModal) {
    const openModals = document.querySelectorAll('.modal.show');

    openModals.forEach(modal => {
        if (modal !== excludedModal) {
            const instance = bootstrap.Modal.getInstance(modal);
            if (instance) {
                instance.hide();
            }
        }
    });
}

function formatLocalDateToInput(localDate) {
    const d = new Date(localDate);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    console.log(localDate)
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
}
function formatDateChile(fechaISO) {
  const [year, month, day] = fechaISO.split('-');
  return `${day}/${month}/${year}`;
}
// Función para normalizar RUT chileno
function normalizarRut(rut) {
    // Limpiar el RUT (quitar puntos, guiones y espacios)
    let rutLimpio = rut.replace(/[^0-9kK]/g, '');
    
    // Un RUT válido debe tener entre 7 y 9 caracteres
    if (rutLimpio.length < 7 || rutLimpio.length > 9) {
        return null;
    }
    
    // Separar número y dígito verificador
    let numero = rutLimpio.slice(0, -1);
    let dv = rutLimpio.slice(-1).toUpperCase();
    
    // Validar que el dígito verificador sea válido
    if (!validarDigitoVerificador(numero, dv)) {
        return null;
    }
    
    // Formatear con guión
    return numero + '-' + dv;
}

function badgeEstado(id_elemento){
    elemento = document.getElementById(id_elemento)
    const estadoTexto = elemento.textContent.trim(); 
    elemento.textContent = estadoTexto;

    let className = 'badge px-3 py-2 rounded-pill shadow-sm text-white ';

    switch (estadoTexto) {
        case 'recepcionada':
            className += 'bg-secondary';
            break;
        case 'en revisión':
            className += 'bg-primary';
            break;
        case 'observada':
            className += 'bg-warning text-dark'; // texto oscuro para fondo claro
            break;
        case 'rechazada':
            className += 'bg-danger';
            break;
        case 'aprobada':
            className += 'bg-success';
            break;
        default:
            className += 'bg-light text-dark'; // fallback neutral
            break;
    }
}

function formatearRut(rut){
    rut = rut.replace(/\./g, '').replace('-', '');
    cuerpo = rut.slice(0, -1)
    dv = rut.slice(-1)

    rutConPuntos = ''
    i = cuerpo.length
    while (i > 3){
        rutConPuntos = '.' + cuerpo.slice(i-3, i) + rutConPuntos
        i -= 3
    }
    rutConPuntos = cuerpo.slice(0, i) + rutConPuntos
    return `${rutConPuntos}-${dv}`
    }

// Función para validar dígito verificador
function validarDigitoVerificador(numero, dv) {
    let suma = 0;
    let multiplicador = 2;
    
    // Calcular desde el final hacia el principio
    for (let i = numero.length - 1; i >= 0; i--) {
        suma += parseInt(numero[i]) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
    
    let resto = suma % 11;
    let dvCalculado = 11 - resto;
    
    if (dvCalculado === 11) {
        dvCalculado = '0';
    } else if (dvCalculado === 10) {
        dvCalculado = 'K';
    } else {
        dvCalculado = dvCalculado.toString();
    }
    
    return dv === dvCalculado;
}


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
            // if(data.rendicion.subvencion.data_organizacion.error){
            //     document.getElementById('informacion_organizacion').innerText = `(${data.renducion.subvencion.rut})`;
            // }else{
            //     rutFormateado = formatearRut(data.rendicion.subvencion.rut)
            //     document.getElementById('informacion_organizacion').innerText = `(${rutFormateado}) ${data.rendicion.subvencion.data_organizacion.nombre_organizacion}`;
            // }
            // rendición con data subvención y organización
            document.getElementById('modalVerDetallesRendicionLabel').innerText = `Detalle de Rendición #${data.rendicion.id}`;
            document.getElementById('rendicion_id').value = data.rendicion.id;
            document.getElementById('detalle_fecha_decreto').innerText = formatDateChile(formatLocalDateToInput(data.rendicion.subvencion.fecha_decreto))

            document.getElementById('detalle_decreto').textContent = data.rendicion.subvencion.decreto;
            document.getElementById('detalle_monto').textContent = `$${data.rendicion.subvencion.monto.toLocaleString('es-CL')}`;  

            document.getElementById('detalle_fecha_asignacion').innerText = formatDateChile(formatLocalDateToInput(data.rendicion.subvencion.fecha_asignacion)) //Corrección fecha decreto para que aparezca sólo día, mes y año

            document.getElementById('detalle_destino').textContent = data.rendicion.subvencion.destino;
            document.getElementById('detalle_estado_actual').textContent = data.rendicion.estado_rendicion.nombre;
            badgeEstado('detalle_estado_actual')

            // const btnCambiarEstado = document.getElementById('btnNavegacionCambiarEstado')

            // // si la tabla es en revisión u observadas, renderizar select de cambio de estado
            // if(button.dataset.btnEstado == 'revision' || button.dataset.btnEstado == 'observadas'){
            //     // select de estados rendición
            //     btnCambiarEstado.hidden = false
            // }else{
            //     btnCambiarEstado.hidden = true
            // }

            document.addEventListener('shown.bs.tab', (e)=>{
                if (e.target.id === 'tab2-rendicion-tab'){
                    if ($.fn.DataTable.isDataTable('#table_acciones_rendicion')) {
                        $('#table_acciones_rendicion').DataTable().destroy();
                    }
                    // tabla acciones rendición
                    new DataTable('#table_acciones_rendicion', {
                        data: data.rendicion.acciones,
                        info: false,
                        searching: false,
                        lengthChange: false,
                        order: [],
                        language: idioma ?? {},
                        deferRender: true,
                        autoWidth: false,
                        responsive: true,
                        paging: false,
                        order: [[ 1, 'asc' ], [ 2, 'desc' ]],
                        columns: [
                            { data: 'id' },
                            { 
                                data: 'fecha',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString() // ver si se puede modificar por hora
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
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex, rowData, counter) {
                        // Accede directamente al objeto de datos completo (si está disponible)
                        const notificacion_row = rowData?.notificaciones;
                        
                        // Solo mostrar si nombre no es nulo, undefined ni cadena vacía
                        return !!notificacion_row;
                    });

                    // tabla acciones rendición
                    new DataTable('#table_notificaciones_rendicion', {
                        data: function () {
                                // Filtrar solo las acciones que tengan notificación
                                acciones_con_notificacion = data.rendicion.acciones.filter(fila => fila.notificaciones.length > 0);
                                notificaciones = []
                                acciones_con_notificacion.forEach(fila => 
                                    fila.notificaciones.forEach(notif => 
                                        {
                                            notif['estado_rendicion'] = fila.estado_rendicion
                                            notificaciones.push(notif)
                                        }
                                    ))
                                return notificaciones
                            }(),
                        searching: false,
                        info: false,
                        lengthChange: false,
                        language: idioma ?? {},
                        deferRender: true,
                        autoWidth: false,
                        responsive: true,
                        paging: false,
                        order: [[ 1, 'asc' ], [ 2, 'desc' ]],
                        columns: [
                            { data: 'id' },
                            { 
                                data: 'destinatario'
                            },
                            { 
                                data: 'fecha_envio',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString()
                                }
                            },
                            { 
                                data: 'fecha_envio',
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
                                data:'estado_rendicion'
                            },
                            { 
                                data: 'estado_notificacion',
                                render: function(d){
                                    if (d === 0) { return 'No leído' }
                                    else if (d === 1) { return 'Leído' }
                                    else { return 'S/D' }
                                }
                            },
                            { 
                                data: 'fecha_lectura',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString({
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                }
                            },
                            { 
                                data: 'fecha_lectura',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleTimeString()
                                }
                            },
                        ]
                    });


                } else if (e.target.id === 'tab4-rendicion-tab') {
                    if ($.fn.DataTable.isDataTable('#table_anteriores_rendicion')) {
                        $('#table_anteriores_rendicion').DataTable().destroy();
                    }

                    new DataTable('#table_anteriores_rendicion', {
                        data: data.historial,
                        info: false,
                        searching: false,
                        lengthChange: false,
                        language: idioma ?? {},
                        deferRender: true,
                        autoWidth: false,
                        responsive: true,
                        paging: false,
                        order: [[ 1, 'asc' ]],
                        columns: [
                            { data: 'id' },
                            { 
                                data: 'fecha_asignacion',
                                render: function(d){
                                    if (!d) return 'S/D';
                                    fecha = new Date(d)
                                    return fecha.toLocaleDateString()
                                }
                            },
                            { 
                                data: 'decreto'

                            },
                            { 
                                data: 'monto',
                                render: function(monto){
                                    monto = monto.toString()
                                    montoFormateado = ''
                                    i = monto.length
                                    while(i > 3){
                                        montoFormateado = '.' + monto.slice(i-3, i) + montoFormateado
                                        i -= 3
                                    }
                                    montoFormateado = monto.slice(0, i) + montoFormateado
                                    return `$${montoFormateado}`
                                }
                            },
                            { 
                                data: 'destino',
                            },
                            { 
                                data: 'rendiciones.estado_rendicion.nombre',
                                render: function(estado){
                                    if (estado == 'Recepcionada') {
                                        return 'No iniciada'
                                    } else {
                                        return estado
                                    }
                                }
                            },
                        ]
                    });
                }


            })



            const modalRendirEl = document.getElementById('modalVerDetallesRendicion');
            const modalRendir   = bootstrap.Modal.getOrCreateInstance(modalRendirEl);
                    console.log(modalRendir)
            modalRendir.show();
            console.log(modalRendir)
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
            nuevo_estado_id: document.getElementById('select_estados').value,
            comentario: document.getElementById('comentario_cambiar_estado').value,
            id: document.getElementById('rendicion_id').value,
            rut: document.getElementById('persona_rut').value,
            nombre: document.getElementById('persona_nombre').value,
            apellido: document.getElementById('persona_apellido').value,
            cargo: document.getElementById('persona_cargo').value,
            correo: document.getElementById('persona_email').value
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

async function comprobarPersona(rut){
    try{
        const res = await fetch('/personas/obtener', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                            document.querySelector('input[name="_token"]')?.value
            },
            body: JSON.stringify({
                rut: rut
            })
        })
        const data = await res.json()
        return data
    }catch (error){
        console.error('Error:', error);

    }
}

document.getElementById('persona_rut').addEventListener('input', async function(){
    this.value = this.value.trim().replace(/[^0-9kK.-]/g, '') 
    if (this.value.length >= 9 && this.value.length <= 12){
        rutConsulta = normalizarRut(this.value)
        if (rutConsulta != null){
            data = await comprobarPersona(rutConsulta)
            if(data.success){
                document.getElementById('persona_rut').value = `${data.persona.rut.substr(-11,2)}.${data.persona.rut.substr(-8,3)}.${data.persona.rut.substr(-5)}`
                document.getElementById('persona_nombre').value = data.persona.nombre
                document.getElementById('persona_apellido').value = data.persona.apellido
                document.getElementById('persona_email').value = data.persona.correo
            }else{
                this.value = formatearRut(this.value)
                document.getElementById('persona_nombre').value = ''
                document.getElementById('persona_apellido').value = ''
                document.getElementById('persona_email').value = ''
            }
        }

    }
})
/*Editar*/
// Función para abrir modal de edición con datos de la rendición
function abrirModalEditar(rendicionId) {
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
        body: JSON.stringify({ id: rendicionId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            
            fecha_decreto = formatLocalDateToInput(data.rendicion.subvencion.fecha_decreto)
            fecha_asignacion = formatLocalDateToInput(data.rendicion.subvencion.fecha_asignacion)
            // Llenar el formulario con los datos
            rutFormateado = formatearRut(data.rendicion.subvencion.rut)
            document.getElementById('modalEditarRendicionLabel').textContent = `Editar rendición #${data.rendicion.id}`
            document.getElementById('subvencion_id').value = data.rendicion.subvencion.id;
            document.getElementById('rut_editar').value = rutFormateado;
            document.getElementById('organizacion_editar').value = data.rendicion.subvencion.data_organizacion.nombre_organizacion;
            document.getElementById('decreto_editar').value = data.rendicion.subvencion.decreto;
            document.getElementById('fecha_decreto_editar').value = fecha_decreto;
            document.getElementById('fecha_asignacion_editar').value = fecha_asignacion;
            document.getElementById('destino_editar').value = data.rendicion.subvencion.destino;
            document.getElementById('monto_editar').value = data.rendicion.subvencion.monto;

            const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
            modalEditar.show();
        } else {
            Swal.fire({
                title: "Error",
                text: data.message || "Error al cargar los datos de la rendición",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error al cargar los datos de la rendición",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    });
}

document.getElementById('rut_editar').addEventListener('input', function(){
    this.value = this.value.trim().replace(/[^0-9kK.-]/g, '')
    if (this.value.length >= 9 && this.value.length <= 12){
        rutFormateado = formatearRut(this.value)
        if(rutFormateado != null){
            this.value = rutFormateado
        }
    }
});

// Event listener para el botón de editar
document.querySelector("#btnFormEditar").addEventListener("click", async function(event) {
    event.preventDefault();
    
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
    
    const form = document.getElementById('formEditarRendicion');
    const formData = new FormData(form);
    
    // Convertir FormData a JSON
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    // Formatear fechas

    data['rut'] = normalizarRut(data['rut'])
    try {
        const response = await fetch(`${window.apiBaseUrl}rendiciones/actualizar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok || !result.success) {
            Swal.fire({
                title: "Error",
                text: result.message || "Error al actualizar la rendición",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        } else {
            Swal.fire({
                title: "Éxito",
                text: result.message || "Rendición actualizada correctamente",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                // Cerrar modal y recargar página
                const modalEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
                modalEditar.hide();
                window.location.reload();
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error inesperado al actualizar la rendición",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    }
});


/* Cambiar estado */
// Función para abrir modal de rendir subvención con datos reales
function abrirModalCambiarEstado(subvencionId) {
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
    
    // Obtener datos de la subvención y opciones
    fetch(`${window.apiBaseUrl}rendiciones/obtener-datos-cambiar-estado`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ id: subvencionId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Llenar ID de subvención
            document.getElementById('rendicion_id').value = data.subvencion.rendiciones.id;
            document.getElementById('modalCambiarEstadoLabel').textContent = `Cambiar estado rendición #${data.subvencion.rendiciones.id}`
            // Llenar datos de la subvención
            rutOrganizacionFormateado = formatearRut(data.subvencion.rut)
            document.getElementById('rut_organizacion_rendir').textContent = rutOrganizacionFormateado;
            document.getElementById('nombre_organizacion_rendir').textContent = data.subvencion.data_organizacion.nombre_organizacion;
            document.getElementById('decreto_rendir').textContent = data.subvencion.decreto;
            document.getElementById('monto_rendir').textContent = '$' + data.subvencion.monto.toLocaleString('es-CL');
            document.getElementById('destino_subvencion_rendir').textContent = data.subvencion.destino;
            document.getElementById('estado_actual_rendir').textContent = data.subvencion.rendiciones.estado_rendicion.nombre;
            badgeEstado('estado_actual_rendir')
            // Llenar opciones de cargos
            const cargoSelect = document.getElementById('persona_cargo');
            const estadosSelect = document.getElementById('select_estados');
            cargoSelect.innerHTML = '<option value="">Seleccione...</option>';
            estadosSelect.innerHTML = '<option value="">Seleccione...</option>';
            data.cargos.forEach(cargo => {
                const option = document.createElement('option');
                option.value = cargo.id;
                option.textContent = cargo.nombre;
                cargoSelect.appendChild(option);
            });
            data.estados.forEach(estado => {
                const optionEstados = document.createElement('option');
                optionEstados.value = estado.id;
                optionEstados.textContent = estado.nombre;
                estadosSelect.appendChild(optionEstados);
            })
            
            // Limpiar campos de persona
            rutPersonaFormateado = formatearRut(data.persona.rut)
            document.getElementById('persona_rut').value = rutPersonaFormateado
            document.getElementById('persona_nombre').value = data.persona.nombre;
            document.getElementById('persona_apellido').value = data.persona.apellido;
            document.getElementById('persona_email').value = data.persona.correo;
            
            // Mostrar el modal
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCambiarEstado')).show();
            

        } else {
            Swal.fire({
                title: "Error",
                text: data.message || "Error al cargar los datos de la subvención",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error al cargar los datos de la subvención",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    });
}


/* Event listener para botón eliminar rendición */
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-eliminar-rendicion')) {
        const button = e.target.closest('.btn-eliminar-rendicion');
        const rendicionId = button.getAttribute('data-rendicion-id');
        
        // Obtener datos de la rendición desde la fila
        const fila = button.closest('tr');
        const celdas = fila.querySelectorAll('td');
        
        // // Llenar el modal con los datos de la rendición
        document.getElementById('modalEliminarRendicionLabel').textContent = `Eliminar rendición #${celdas[0].textContent}`
        document.getElementById('eliminarRendicionNumero').textContent = celdas[0].textContent;
        document.getElementById('eliminarRendicionRut').textContent = celdas[2].textContent;
        document.getElementById('eliminarRendicionOrganizacion').textContent = celdas[3].textContent;
        document.getElementById('eliminarRendicionDecreto').textContent = celdas[4].textContent;
        document.getElementById('eliminarRendicionMonto').textContent = celdas[6].textContent;
        
        // // Limpiar checkbox del modal
        document.getElementById('confirmarEliminacionRendicion').checked = false;
        document.getElementById('btnConfirmarEliminacionRendicion').disabled = true;
        
        // // Mostrar el modal

        const modalEliminarEl = document.getElementById('modalEliminarRendicion');
        const modalEliminar   = bootstrap.Modal.getOrCreateInstance(modalEliminarEl);
        console.log(modalEliminar)
        modalEliminar.show()

        
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
            eliminarRendicion(rendicionId);
        }
    }
});

/* Función para eliminar rendición */
function eliminarRendicion(id) {
    // Cerrar el modal primero
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

// Reiniciar pestañas modal ver detalles
elementoModalDetalle = document.getElementById('modalVerDetallesRendicion')
elementoModalEditar = document.getElementById('modalEditar')
elementoModalCambiarEstado = document.getElementById('modalCambiarEstado')
console.log(elementoModalCambiarEstado, elementoModalDetalle, elementoModalEditar)
// elementoModalDetalle.addEventListener('hidden.bs.modal', function (e) {
//     // closeAllModalsExcept(this);
//     // Tabs nav
//   const tabs = document.querySelectorAll('#modalVerDetallesRendicion button.nav-link');
//   // Tab panes
//   const panes = document.querySelectorAll('#modalVerDetallesRendicion .tab-content .tab-pane');

//   // Quitar active y show de todas
//   tabs.forEach(tab => tab.classList.remove('active'));
//   panes.forEach(pane => {
//     pane.classList.remove('active');
//     pane.classList.remove('show');
//   });

//   // Poner active y show en el primero
//   if(tabs.length > 0)
//   {
//     tabs[0].classList.add('active');
//     tabs[0].classList.add('show');
//   }
//   if(panes.length > 0) {
//     panes[0].classList.add('active');
//     panes[0].classList.add('show');
//   }
  
// });

document.addEventListener('shown.bs.modal', function (e) {
    console.log(document.getElementsByClassName('modal show'))
    // Tabs nav

  
});


// elementoModalCambiarEstado.addEventListener('hidden.bs.modal', function (e) {
//     closeAllModalsExcept(this);

  
// });
// // Rellenar datos modal cambiar estado al cerrar modal ver detalles
// // document.getElementById('btnNavegacionCambiarEstado').addEventListener('click', ()=>{
// //     rendicion_id = document.getElementById('rendicion_id')
// //     abrirModalCambiarEstado(rendicion_id.value)
    
// // })

// document.addEventListener