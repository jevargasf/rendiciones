var modal = new bootstrap.Modal(document.getElementById("modalForm"));


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

function badgeEstado(id_elemento){
    elemento = document.getElementById(id_elemento)
    const estadoTexto = elemento.textContent.trim(); 
    elemento.textContent = estadoTexto;

    let className = 'badge px-3 py-2 rounded-pill shadow-sm text-white ';

    switch (estadoTexto) {
        case 'Recepcionada':
            className += 'bg-secondary';
            break;
        case 'En revisión':
            className += 'bg-primary';
            break;
        case 'Observada':
            className += 'bg-warning text-dark'; // texto oscuro para fondo claro
            break;
        case 'Rechazada':
            className += 'bg-danger';
            break;
        case 'Aprobada':
            className += 'bg-success';
            break;
        default:
            className += 'bg-light text-dark'; // fallback neutral
            break;
    }
}

//Helpers del formato detalle de subvención, parte del rut y nombre de la organización
function sentenceCase(s = '') {
    if (!s) return '';
    s = String(s).toLowerCase();
    const i= s.search(0, i) + s[i].toUpperCase() + s.slice(i + 1);
    return s.replace(/([.!?]\s+)([a-záéíóúñü])/gi, (_, p1, p2) => p1 + p2.toUpperCase());
}

/*Formulario*/

document.querySelector("#form").addEventListener("submit", async function(event){

    event.preventDefault();

    let form=event.target;

    let formData=new FormData(form);

    try{

        let response =await fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept" : "application/json",
            },
            
        });

        let data=await response.json();


        if (!response.ok || !data.success){
            Swal.fire({
                title: "Error",
                text: data.message || "Ocurrió un error al procesar el archivo",
                icon: "error",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "swal-error"
                },                
            });
        }
        else{
            // Mostrar mensaje de éxito con detalles
            let mensaje = data.message;
            if (data.subvenciones_creadas > 0) {
                mensaje += `\n\nSubvenciones creadas: ${data.subvenciones_creadas}`;
            }
            
            Swal.fire({
                title: "Éxito",
                text: mensaje,
                icon: "success",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "swal-success"
                },                
            }).then(()=> {
                modal.hide();
                window.location.reload(); // Recargar la página para mostrar las nuevas subvenciones
            });    
        }
   

    } catch(error){
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Ocurrió un error inesperado al procesar el archivo",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    }

}); 

/**MODAL */

/*Crear*/
document.querySelector("#btnModal").addEventListener ("click", function (){

    let form = document.querySelector("#modalForm form");

    form.reset();

    form.action = `${window.apiBaseUrl}subvenciones/crear`;

    form.querySelector('input[name="_method"]')?.setAttribute("value", "POST");

    modal.show();

});

/* Ver detalles*/

function verDetalleSubvencion(subvencionId){
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
    fetch(`${window.apiBaseUrl}subvenciones/obtener`, {
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
            console.log(data)
            fecha_decreto = formatLocalDateToInput(data.subvencion.fecha_decreto)
            fecha_asignacion = formatLocalDateToInput(data.subvencion.fecha_asignacion)
            document.getElementById('modalVerDetallesLabel').innerText = `Detalle de subvención #${data.subvencion.id}`


            rutFormateado = formatearRut(data.subvencion.rut)

            // if (data.subvencion.data_organizacion.error) {
            // // document.getElementById('informacion_organizacion').textContent = `(${rutFormateado})`;
            // } else {
            // const raw = (data.subvencion.data_organizacion.nombre_organizacion || '').trim();
            
            // const normalizado = raw.replace(/\s+/g, '').toUpperCase().replace(/[.\-]/g, '/');

            // let nombreOracion;
            // if (normalizado === 'S/D') {
            //     // excepción: dejar S/D en mayúsculas
            //     nombreOracion = 'S/D';
            // } else {
            //     // primera letra mayúscula, resto minúsculas
            //     nombreOracion = raw ? raw.charAt(0).toUpperCase() + raw.slice(1).toLowerCase() : '';
            // }

            // const info = nombreOracion
            //     ? `(${rutFormateado}) ${nombreOracion}`
            //     : `(${rutFormateado})`;

            // document.getElementById('informacion_organizacion').textContent = info;
            // }

            document.getElementById('detalle_fecha_decreto').innerText = formatDateChile(fecha_decreto);
            document.getElementById('detalle_decreto').innerText = data.subvencion.decreto;
          //document.getElementById('detalle_monto').innerText = data.subvencion.monto; -> Reemplaza por código de abajo para agregar signo $ y punto en monto
            document.getElementById('detalle_monto').innerText = `$${data.subvencion.monto.toLocaleString('es-CL')}`;

            document.getElementById('detalle_fecha_asignacion').innerText =  formatDateChile(fecha_asignacion);
            document.getElementById('detalle_destino').innerText = data.subvencion.destino;
            document.getElementById('detalle_estado').textContent = data.subvencion.rendiciones.estado_rendicion.nombre;

            document.addEventListener('shown.bs.tab', (e)=>{
                if (e.target.id === 'tab2-tab'){
                    if ($.fn.DataTable.isDataTable('#table_acciones_subvencion')) {
                        $('#table_acciones_subvencion').DataTable().destroy();
                    }
                    // tabla acciones rendición
                    new DataTable('#table_acciones_subvencion', {
                        data: data.subvencion.rendiciones.acciones,
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
                } else if (e.target.id === 'tab3-tab') {
                    if ($.fn.DataTable.isDataTable('#table_subvenciones_anteriores')) {
                        $('#table_subvenciones_anteriores').DataTable().destroy();
                        
                    }
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex, rowData, counter) {
                        // Accede directamente al objeto de datos completo (si está disponible)
                        const notificacion_row = rowData?.notificaciones;
                        
                        // Solo mostrar si nombre no es nulo, undefined ni cadena vacía
                        return !!notificacion_row;
                    });
                    // tabla acciones rendición
                    new DataTable('#table_subvenciones_anteriores', {
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
            console.log(Object.keys(data.subvencion.data_organizacion).length > 1)
            // ficha detalles organización
            if(Object.keys(data.subvencion.data_organizacion).length > 1) {
                const org = data.subvencion.data_organizacion;
                console.log("llegó aquí 2")

                const cap = s => s ? s.charAt(0).toUpperCase() + s.slice(1).toLowerCase() : '';
                

                //Buscar el cargo y armar un nombre completo
                const dir = Array.isArray(org.directivas) ? org.directivas: [];
                const byCargo = c => dir.find(d => (d.cargo || '').toLowerCase() === c); 
                const full = p => p ? `${cap(p.nombre_persona)} ${cap(p.apellido_persona)}` : '-';

                //Mostrando los bloques con datos

                document.getElementById('detalle_organizacion').hidden = false;
                document.getElementById('detalle_sin_datos').hidden = true;
                                    
                // inyectar datos al elemento correspondiente en el DOM
                
                document.getElementById('organizacion_pj_municipal').textContent = org.pj_municipal || '';
                document.getElementById('organizacion_pj_reg_civil').textContent = org.pj_registro_civil || '';
                document.getElementById('organizacion_nombre').textContent = cap(org.nombre_organizacion || '');
                document.getElementById('organizacion_direccion').textContent = cap(org.direccion || '');
                document.getElementById('organizacion_rut').textContent = org.rut || '';
                document.getElementById('organizacion_tipo').textContent =cap(org.tipo_organizacion || '');
                document.getElementById('organizacion_telefono').textContent = org.telefono || '';
                document.getElementById('organizacion_correo').textContent = org.correo || '';

                // Cargos de la directiva con mayuscula al inicio de nombre y apellido
                document.getElementById('organizacion_presidente').textContent = full(byCargo('presidente'));
                document.getElementById('organizacion_tesorero').textContent = full(byCargo('tesorero'));
                document.getElementById('organizacion_secretario').textContent = full(byCargo('secretario'));

            } else {
                // AQUÍ PASA QUE SI CLICKEO UNA ORGANIZACIÓN SIN DATOS, BORRO TODOS LOS ELEMENTOS DEL DOM
                // escribir un mensaje de que no se pudo recuperar la data de la organización 
                document.getElementById('detalle_organizacion').hidden = true
                document.getElementById('detalle_sin_datos').hidden = false
                document.getElementById('detalle_sin_datos').textContent = `
                    No se pudo recuperar los datos de la organización.
                `


            }

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
// Función para abrir modal de edición con datos de la subvención
function abrirModalEditar(subvencionId) {
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
    fetch(`${window.apiBaseUrl}subvenciones/obtener`, {
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
            fecha_decreto = formatLocalDateToInput(data.subvencion.fecha_decreto)
            fecha_asignacion = formatLocalDateToInput(data.subvencion.fecha_asignacion)
            // Llenar el formulario con los datos
            rutFormateado = formatearRut(data.subvencion.rut)
            document.getElementById('modalEditarSubvencionLabel').innerText = `Editar subvencion #${data.subvencion.id}`
            document.getElementById('subvencion_id').value = data.subvencion.id;
            document.getElementById('rut_editar').value = rutFormateado;
            document.getElementById('organizacion_editar').value = data.subvencion.data_organizacion.nombre_organizacion;
            document.getElementById('decreto_editar').value = data.subvencion.decreto;
            document.getElementById('fecha_decreto_editar').value = fecha_decreto;
            document.getElementById('fecha_asignacion_editar').value = fecha_asignacion;
            document.getElementById('destino_editar').value = data.subvencion.destino;
            document.getElementById('monto_editar').value = data.subvencion.monto;
            
            // Mostrar el modal
            const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
            modalEditar.show();
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
    
    const form = document.getElementById('formEditarSubvencion');
    const formData = new FormData(form);
    
    // Convertir FormData a JSON
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    // Formatear fechas
    data['rut'] = normalizarRut(data['rut'])
    try {
        const response = await fetch(`${window.apiBaseUrl}subvenciones/actualizar`, {
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
                text: result.message || "Error al actualizar la subvención",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        } else {
            Swal.fire({
                title: "Éxito",
                text: result.message || "Subvención actualizada correctamente",
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
            text: "Error inesperado al actualizar la subvención",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    }
});

// Función para abrir modal de rendir subvención con datos reales
function abrirModalRendir(subvencionId) {
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
    fetch(`${window.apiBaseUrl}subvenciones/obtener-datos-rendir`, {
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
            document.getElementById('modalRendirSubvencionLabel').innerText = `Rendir subvención #${data.subvencion.id}`
            document.getElementById('rendicion_id').value = data.subvencion.rendiciones.id;
            // Llenar datos de la subvención
            document.getElementById('rut_organizacion_rendir').textContent = data.subvencion.rut;
            document.getElementById('nombre_organizacion_rendir').textContent = data.subvencion.data_organizacion.nombre_organizacion;
            document.getElementById('decreto_rendir').textContent = data.subvencion.decreto;
            document.getElementById('monto_rendir').textContent = '$' + data.subvencion.monto.toLocaleString('es-CL');
            document.getElementById('destino_subvencion_rendir').textContent = data.subvencion.destino;
            document.getElementById('estado_actual_rendir').textContent = data.subvencion.rendiciones.estado_rendicion.nombre;
            badgeEstado('estado_actual_rendir')
            // Llenar opciones de cargos
            const cargoSelect = document.getElementById('persona_cargo');
            cargoSelect.innerHTML = '<option value="">Seleccione...</option>';
            data.cargos.forEach(cargo => {
                const option = document.createElement('option');
                option.value = cargo.id;
                option.textContent = cargo.nombre;
                cargoSelect.appendChild(option);
            });
            
            
            // Limpiar campos de persona
            document.getElementById('persona_rut').value = '';
            document.getElementById('persona_nombre').value = '';
            document.getElementById('persona_apellido').value = '';
            document.getElementById('persona_email').value = '';
            
            // Mostrar el modal
            const modalRendir = new bootstrap.Modal(document.getElementById('modalRendirsubvencion'));
            modalRendir.show();
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

// Event listener para el botón de guardar rendición
document.getElementById('btnFormRendir').addEventListener('click', async function(event) {
    event.preventDefault();
    
    // Validar que todos los campos estén llenos
    const camposRequeridos = [
        'persona_rut',
        'persona_nombre', 
        'persona_apellido',
        'persona_email',
        'persona_cargo',
        'comentario_detalle'
    ];
    
    let camposVacios = [];
    camposRequeridos.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (!elemento.value.trim()) {
            camposVacios.push(campo);
        }
    });
    
    if (camposVacios.length > 0) {
        Swal.fire({
            title: "Campos requeridos",
            text: "Por favor complete todos los campos obligatorios",
            icon: "warning",
            confirmButtonText: "Aceptar"
        });
        return;
    }
    
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
    
    try {
        // Primero guardar/actualizar la persona
        const datosRendicion = {
            rut: document.getElementById('persona_rut').value,
            nombre: document.getElementById('persona_nombre').value,
            apellido: document.getElementById('persona_apellido').value,
            correo: document.getElementById('persona_email').value,
            cargo: document.getElementById('persona_cargo').value,
            comentario: document.getElementById('comentario_detalle').value,
            id: document.getElementById('rendicion_id').value
        };
        
        const responseRendicion = await fetch(`${window.apiBaseUrl}rendiciones/crear`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(datosRendicion)
        });
        
        // const resultPersona = await responsePersona.json();
        
        // if (!responsePersona.ok || !resultPersona.success) {
        //     Swal.fire({
        //         title: "Error",
        //         text: resultPersona.message || "Error al guardar los datos de la persona",
        //         icon: "error",
        //         confirmButtonText: "Aceptar"
        //     });
        //     return;
        // }
        
        // Si la persona se guardó correctamente, proceder con la rendición
        // const datosRendicion = {
        //     subvencion_id: document.getElementById('subvencion_id').value,
        //     persona_id: resultPersona.data.id,
        //     persona_cargo_id: document.getElementById('persona_cargo').value,
        //     comentario: document.getElementById('comentario_detalle').value
        // };
        
        // const responseRendicion = await fetch(`${window.apiBaseUrl}subvenciones/guardar-rendicion`, {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-Requested-With': 'XMLHttpRequest',
        //         'Accept': 'application/json',
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     body: JSON.stringify(datosRendicion)
        // });
        
        const resultRendicion = await responseRendicion.json();
        
        if (!responseRendicion.ok || !resultRendicion.success) {
            Swal.fire({
                title: "Error",
                text: resultRendicion.message || "Error al guardar la rendición",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        } else {
            Swal.fire({
                title: "Éxito",
                text: "Rendición iniciada exitosamente",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                // Cerrar modal y recargar página
                const modalRendir = bootstrap.Modal.getInstance(document.getElementById('modalRendirsubvencion'));
                modalRendir.hide();
                window.location.href = '/rendiciones';
                localStorage.setItem('abrir_modal_detalles', true);
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error inesperado al guardar los datos",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    }
});

// Event listener para normalizar RUT cuando el usuario termine de escribir
// document.getElementById('persona_rut').addEventListener('blur', function(event) {
//     const rut = event.target.value.trim();
    
//     // No validar si el RUT ya fue seleccionado de las sugerencias
//     if (event.target.getAttribute('data-validated') === 'true') {
//         event.target.removeAttribute('data-validated');
//         return;
//     }
    
//     // Solo validar si el RUT tiene al menos 7 caracteres (mínimo para un RUT válido)
//     if (rut && rut.length >= 7) {
//         const rutNormalizado = normalizarRut(rut);
//         if (rutNormalizado) {
//             event.target.value = rutNormalizado;
//         } else {
//             // Mostrar error si el RUT no es válido
//             Swal.fire({
//                 title: "RUT inválido",
//                 text: "El RUT ingresado no es válido. Por favor, verifique el número y dígito verificador.",
//                 icon: "warning",
//                 confirmButtonText: "Aceptar",
//                 allowOutsideClick: true,
//                 allowEscapeKey: true
//             }).then((result) => {
//                 if (result.isConfirmed || result.isDismissed) {
//                     event.target.focus();
//                 }
//             });
//         }
//     }
// });

// Event listener para ocultar sugerencias al hacer clic fuera
// document.addEventListener('click', function(event) {
//     const campoRut = document.getElementById('persona_rut');
//     const sugerencias = document.getElementById('sugerencias_rut');
    
//     if (campoRut && sugerencias && !campoRut.contains(event.target) && !sugerencias.contains(event.target)) {
//         ocultarSugerencias();
//     }
// });


document.getElementById('modalVerDetalles').addEventListener('hidden.bs.modal', function (e) {
// Tabs nav
  const tabs = document.querySelectorAll('#modalVerDetalles button.nav-link');
  // Tab panes
  const panes = document.querySelectorAll('.tab-content .tab-pane');

  // Quitar active y show de todas
  tabs.forEach(tab => tab.classList.remove('active'));
  panes.forEach(pane => {
    pane.classList.remove('active');
    pane.classList.remove('show');
  });

  // Poner active y show en el primero
  if(tabs.length > 0)
  {
    tabs[0].classList.add('active');
    tabs[0].classList.add('show');
  }
  if(panes.length > 0) {
    panes[0].classList.add('active');
    panes[0].classList.add('show');
  }
});



