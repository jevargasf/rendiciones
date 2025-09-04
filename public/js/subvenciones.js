var modal = new bootstrap.Modal(document.getElementById("modalForm"));


console.log('Funcionó');


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
            // Llenar el formulario con los datos
            document.getElementById('subvencion_id').value = data.data.id;
            document.getElementById('rut_editar').value = data.data.rut;
            document.getElementById('organizacion_editar').value = data.data.organizacion;
            document.getElementById('decreto_editar').value = data.data.decreto;
            document.getElementById('destino_editar').value = data.data.destino;
            document.getElementById('monto_editar').value = data.data.monto;
            
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
            document.getElementById('subvencion_id').value = data.data.subvencion.id;
            
            // Llenar datos de la subvención
            document.getElementById('rut_organizacion_rendir').textContent = data.data.subvencion.rut;
            document.getElementById('nombre_organizacion_rendir').textContent = data.data.subvencion.organizacion;
            document.getElementById('decreto_rendir').textContent = data.data.subvencion.decreto;
            document.getElementById('monto_rendir').textContent = '$' + data.data.subvencion.monto.toLocaleString('es-CL');
            document.getElementById('destino_subvencion_rendir').textContent = data.data.subvencion.destino;
            
            // Llenar opciones de cargos
            const cargoSelect = document.getElementById('persona_cargo');
            cargoSelect.innerHTML = '<option value="">Seleccione...</option>';
            data.data.cargos.forEach(cargo => {
                const option = document.createElement('option');
                option.value = cargo.id;
                option.textContent = cargo.nombre;
                cargoSelect.appendChild(option);
            });
            
            // Llenar opciones de estados de rendición
            const estadoSelect = document.getElementById('Estado');
            estadoSelect.innerHTML = '<option value="">Seleccione...</option>';
            data.data.estados_rendicion.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.id;
                option.textContent = estado.nombre;
                estadoSelect.appendChild(option);
            });
            
            // Limpiar campos de persona
            document.getElementById('persona_rut').value = '';
            document.getElementById('persona_nombre').value = '';
            document.getElementById('persona_apellido').value = '';
            document.getElementById('persona_email').value = '';
            document.getElementById('persona_telefono').value = '';
            
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
function buscarPersonas(query) {
    if (query.length < 2) {
        ocultarSugerencias();
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
        return;
    }
    
    // Buscar personas
    fetch(`${window.apiBaseUrl}personas/buscar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ q: query })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarSugerencias(data.data);
        }
    })
    .catch(error => {
        console.error('Error al buscar personas:', error);
    });
}

// Función para mostrar sugerencias
function mostrarSugerencias(personas) {
    const contenedor = document.getElementById('sugerencias_rut');
    contenedor.innerHTML = '';
    
    if (personas.length === 0) {
        contenedor.style.display = 'none';
        return;
    }
    
    personas.forEach(persona => {
        const item = document.createElement('div');
        item.className = 'list-group-item list-group-item-action';
        item.style.cursor = 'pointer';
        item.innerHTML = `
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">${persona.rut}</h6>
            </div>
            <p class="mb-1">${persona.nombre} ${persona.apellido}</p>
        `;
        
        item.addEventListener('click', () => {
            seleccionarPersona(persona);
        });
        
        contenedor.appendChild(item);
    });
    
    contenedor.style.display = 'block';
}

// Función para ocultar sugerencias
function ocultarSugerencias() {
    const contenedor = document.getElementById('sugerencias_rut');
    contenedor.style.display = 'none';
}

// Función para seleccionar una persona
function seleccionarPersona(persona) {
    // Llenar campos de persona
    document.getElementById('persona_rut').value = persona.rut;
    document.getElementById('persona_nombre').value = persona.nombre;
    document.getElementById('persona_apellido').value = persona.apellido;
    document.getElementById('persona_email').value = persona.correo || '';
    document.getElementById('persona_telefono').value = persona.telefono || '';
    
    // Ocultar sugerencias
    ocultarSugerencias();
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
        'persona_telefono',
        'persona_cargo',
        'Estado',
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
    
    // Preparar datos para enviar
    const datos = {
        subvencion_id: document.getElementById('subvencion_id').value,
        persona_rut: document.getElementById('persona_rut').value,
        persona_nombre: document.getElementById('persona_nombre').value,
        persona_apellido: document.getElementById('persona_apellido').value,
        persona_email: document.getElementById('persona_email').value,
        persona_telefono: document.getElementById('persona_telefono').value,
        persona_cargo_id: document.getElementById('persona_cargo').value,
        estado_rendicion_id: document.getElementById('Estado').value,
        comentario: document.getElementById('comentario_detalle').value
    };
    
    try {
        const response = await fetch(`${window.apiBaseUrl}subvenciones/guardar-rendicion`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(datos)
        });
        
        const result = await response.json();
        
        if (!response.ok || !result.success) {
            Swal.fire({
                title: "Error",
                text: result.message || "Error al guardar la rendición",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        } else {
            Swal.fire({
                title: "Éxito",
                text: result.message || "Rendición guardada correctamente",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                // Cerrar modal y recargar página
                const modalRendir = bootstrap.Modal.getInstance(document.getElementById('modalRendirsubvencion'));
                modalRendir.hide();
                window.location.reload();
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error inesperado al guardar la rendición",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    }
});

// Event listener para ocultar sugerencias al hacer clic fuera
document.addEventListener('click', function(event) {
    const campoRut = document.getElementById('persona_rut');
    const sugerencias = document.getElementById('sugerencias_rut');
    
    if (campoRut && sugerencias && !campoRut.contains(event.target) && !sugerencias.contains(event.target)) {
        ocultarSugerencias();
    }
});











