var modal = new bootstrap.Modal(document.getElementById("modalForm"));




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
            // qué pasa si el historial de "otras" llega vacío
            // iterar con los nuevos nombres y estructura del arreglo data
            fecha_decreto = new Date(data.subvencion.fecha_decreto).toLocaleDateString()
            fecha_asignacion = new Date(data.subvencion.fecha_asignacion).toLocaleDateString()
            if(data.subvencion.data_organizacion.error){
                document.getElementById('informacion_organizacion').innerText = `(${data.subvencion.rut})`;

            }else{
                document.getElementById('informacion_organizacion').innerText = `(${data.subvencion.rut}) ${data.subvencion.data_organizacion.nombre_organizacion}`;
            }
            document.getElementById('detalle_fecha_decreto').innerText = fecha_decreto;
            document.getElementById('detalle_decreto').innerText = data.subvencion.decreto;
            document.getElementById('detalle_monto').innerText = data.subvencion.monto;

            document.getElementById('detalle_fecha_asignacion').innerText = fecha_asignacion;
            document.getElementById('detalle_destino').innerText = data.subvencion.destino;

            tabla_detalle = document.getElementById('detalle_acciones')
            filas_acciones = ''
            console.log(data.subvencion.rendiciones)
            data.subvencion.rendiciones.acciones.forEach((accion) =>{
                fecha_accion = new Date(accion.fecha).toLocaleDateString()
                filas_acciones += `
                                                        <tr>
                                                <td class="text-center px-2">${fecha_accion}</td>
                                                <td class="px-2">${accion.comentario}</td>
                                                <td class="px-2">${accion.km_nombre}</td>
                                                <td>    
                                            </tr>
                `
            })
            tabla_detalle.innerHTML = filas_acciones

            // historial
            detalle_anteriores = document.getElementById('detalle_anteriores')
            filas_anteriores = ''
            if(data.historial.length == 0){
                filas_anteriores = `<p>No hay otras subvenciones asociadas a esta organización.</p>`
            } else {
                console.log(data.historial)
                data.historial.forEach((anterior)=>{
                    filas_anteriores +=
                        `
                            <tr>
                                <td class="text-center px-2">${anterior.id}</td>
                                <td>29/05/2025</td>
                                <td class="px-2">${anterior.decreto}</td>
                                <td class="px-2">${anterior.monto}</td>
                                <td class="px-2">${anterior.destino}</td>
                            </tr>
                        `
                })
            }

            detalle_anteriores.innerHTML = filas_anteriores
            // ficha detalles organización
            if(Object.keys(data.subvencion.data_organizacion).length > 1){
                // declarar variables
                nombre_presidente = data.subvencion.data_organizacion.directivas[0].nombre_persona[0].toUpperCase() + data.subvencion.data_organizacion.directivas[0].nombre_persona.substring(1).toLowerCase()


                // inyectar datos al elemento correspondiente en el DOM
                document.getElementById('detalle_organizacion').hidden = false
                document.getElementById('detalle_sin_datos').hidden = true
                
                document.getElementById('organizacion_pj_municipal').textContent = data.subvencion.data_organizacion.pj_municipal
                document.getElementById('organizacion_pj_reg_civil').textContent = data.subvencion.data_organizacion.pj_registro_civil
                document.getElementById('organizacion_nombre').textContent = data.subvencion.data_organizacion.nombre_organizacion
                document.getElementById('organizacion_direccion').textContent = data.subvencion.data_organizacion.direccion
                document.getElementById('organizacion_rut').textContent = data.subvencion.data_organizacion.rut
                document.getElementById('organizacion_tipo').textContent = data.subvencion.data_organizacion.tipo_organizacion
                document.getElementById('organizacion_telefono').textContent = data.subvencion.data_organizacion.telefono
                document.getElementById('organizacion_correo').textContent = data.subvencion.data_organizacion.correo
                document.getElementById('organizacion_presidente').textContent = nombre_presidente + ' ' + data.subvencion.data_organizacion.directivas[0].apellido_persona
                document.getElementById('organizacion_tesorero').textContent = data.subvencion.data_organizacion.directivas[2].nombre_persona + ' ' + data.subvencion.data_organizacion.directivas[2].apellido_persona
                document.getElementById('organizacion_secretario').textContent = data.subvencion.data_organizacion.directivas[1].nombre_persona + ' ' + data.subvencion.data_organizacion.directivas[1].apellido_persona

            }else{
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


/*Editar*/
// Función para abrir modal de edición con datos de la subvención
function abrirModalEditar(subvencionId) {
    console.log(subvencionId)
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
            fecha_decreto = new Date(data.subvencion.fecha_decreto).toLocaleDateString()
            fecha_asignacion = new Date(data.subvencion.fecha_asignacion).toLocaleDateString()
            // Llenar el formulario con los datos
            document.getElementById('subvencion_id').value = data.subvencion.id;
            document.getElementById('rut_editar').value = data.subvencion.rut;
            document.getElementById('organizacion_editar').value = data.subvencion.organizacion;
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
    fechaDecretoSeparada = data['fecha_decreto'].split('/')
    fechaAsignacionSeparada = data['fecha_asignacion'].split('/')
    data['fecha_decreto'] = new Date(fechaDecretoSeparada[0], fechaDecretoSeparada[1], fechaDecretoSeparada[2])
    data['fecha_asignacion'] = new Date(fechaAsignacionSeparada[0], fechaAsignacionSeparada[1], fechaAsignacionSeparada[2])
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
            console.log(data.subvencion.rendiciones)
            // Llenar ID de subvención
            document.getElementById('rendicion_id').value = data.subvencion.rendiciones.id;
            // Llenar datos de la subvención
            document.getElementById('rut_organizacion_rendir').textContent = data.subvencion.rut;
            document.getElementById('nombre_organizacion_rendir').textContent = data.subvencion.data_organizacion.nombre_organizacion;
            document.getElementById('decreto_rendir').textContent = data.subvencion.decreto;
            document.getElementById('monto_rendir').textContent = '$' + data.subvencion.monto.toLocaleString('es-CL');
            document.getElementById('destino_subvencion_rendir').textContent = data.subvencion.destino;
            
            // Llenar opciones de cargos
            const cargoSelect = document.getElementById('persona_cargo');
            cargoSelect.innerHTML = '<option value="">Seleccione...</option>';
            console.log(data)
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

// Función para buscar personas por RUT
// function buscarPersonas(query) {
//     if (query.length < 2) {
//         ocultarSugerencias();
//         return;
//     }
    
//     // Solo normalizar si el RUT tiene al menos 7 caracteres
//     if (query.length >= 7) {
//         const rutNormalizado = normalizarRut(query);
//         if (rutNormalizado) {
//             // Si el RUT es válido, actualizar el campo con el formato correcto
//             document.getElementById('persona_rut').value = rutNormalizado;
//         }
//     }

//     // Obtener token CSRF
//     let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
//     if (!csrfToken) {
//         csrfToken = document.querySelector('input[name="_token"]')?.value;
//     }
    
//     if (!csrfToken && typeof $ !== 'undefined') {
//         csrfToken = $('meta[name="csrf-token"]').attr('content');
//     }
    
//     if (!csrfToken) {
//         console.error('No se pudo obtener el token CSRF');
//         return;
//     }
    
//     // Buscar personas
//     // fetch(`${window.apiBaseUrl}personas/buscar`, {
//     //     method: 'POST',
//     //     headers: {
//     //         'Content-Type': 'application/json',
//     //         'X-Requested-With': 'XMLHttpRequest',
//     //         'Accept': 'application/json',
//     //         'X-CSRF-TOKEN': csrfToken
//     //     },
//     //     body: JSON.stringify({ q: query })
//     // })
//     // .then(response => response.json())
//     // .then(data => {
//     //     if (data.success) {
//     //         mostrarSugerencias(data.data);
//     //     }
//     // })
//     // .catch(error => {
//     //     console.error('Error al buscar personas:', error);
//     // });
// }

// Función para mostrar sugerencias
// function mostrarSugerencias(personas) {
//     const contenedor = document.getElementById('sugerencias_rut');
//     contenedor.innerHTML = '';
    
//     if (personas.length === 0) {
//         contenedor.style.display = 'none';
//         return;
//     }
    
//     personas.forEach(persona => {
//         const item = document.createElement('div');
//         item.className = 'list-group-item list-group-item-action';
//         item.style.cursor = 'pointer';
//         item.innerHTML = `
//             <div class="d-flex w-100 justify-content-between">
//                 <h6 class="mb-1">${persona.rut}</h6>
//             </div>
//             <p class="mb-1">${persona.nombre} ${persona.apellido}</p>
//         `;
        
//         item.addEventListener('click', () => {
//             seleccionarPersona(persona);
//         });
        
//         contenedor.appendChild(item);
//     });
    
//     contenedor.style.display = 'block';
// }

// Función para ocultar sugerencias
// function ocultarSugerencias() {
//     const contenedor = document.getElementById('sugerencias_rut');
//     contenedor.style.display = 'none';
// }

// Función para seleccionar una persona
// function seleccionarPersona(persona) {
//     // Llenar campos de persona
//     document.getElementById('persona_rut').value = persona.rut;
//     document.getElementById('persona_nombre').value = persona.nombre;
//     document.getElementById('persona_apellido').value = persona.apellido;
//     document.getElementById('persona_email').value = persona.correo || '';
    
//     // Ocultar sugerencias
//     ocultarSugerencias();
    
//     // Marcar que el RUT ya está validado para evitar validación en blur
//     document.getElementById('persona_rut').setAttribute('data-validated', 'true');
// }

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
                window.location.reload();
                console.log("llegó acá")
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



