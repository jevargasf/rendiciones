/* Busca en la página el elemento con id="modalDetalleRendicion" y lo guarda en la variable modalRendidas */
var modalRendidas = document.getElementById("modalDetalleRendicion");
var modalR = modalRendidas ? new bootstrap.Modal(modalRendidas) : null;

/* Por cada pestaña de Pendientes, Observadas, Rechazadas crear una variable */
var modalPendientes = document.getElementById("modalDetallePendientes");
var modalP = modalPendientes ? new bootstrap.Modal(modalPendientes) : null;
var modalObservadas = document.getElementById("modalDetalleObservadas");
var modalO = modalObservadas ? new bootstrap.Modal(modalObservadas) : null;
var modalRechazadas = document.getElementById("modalDetalleRechazadas");
var modalRe = modalRechazadas ? new bootstrap.Modal(modalRechazadas) : null;

/* Detalle de rendición - Modal Rendidas */
document.querySelector("#table_id")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        try {
            let response = await fetch('rendiciones/detalleRendicion/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Request-With': "XMLHttpRequest",
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                },
                body: {
                  'id': id
                }
            });
            let data = await response.json()
            var tablaAcciones = document.getElementById("tablaAcciones");
            const tbody = tablaAcciones.getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            acciones = data.acciones;
            acciones.forEach((item) => {
                const fila = document.createElement('tr');
                const celdaTd = document.createElement('td');
                celdaTd.textContent = item.id || 'S/D';
                fila.appendChild(celdaTd);
                const celdaTdFecha = document.createElement('td');
                celdaTdFecha.textContent = item.fecha || 'S/D';
                fila.appendChild(celdaTdFecha);
                const celdaTdHora = document.createElement('td');
                celdaTdHora.textContent = item.hora || 'S/D'; // Corregido: usa item.hora en lugar de item.fecha
                fila.appendChild(celdaTdHora);
                const celdaTdDescripcion = document.createElement('td');
                celdaTdDescripcion.textContent = item.descripcion || 'S/D';
                fila.appendChild(celdaTdDescripcion);
                const celdaTdUsuario = document.createElement('td');
                celdaTdUsuario.textContent = item.usuario || 'S/D';
                fila.appendChild(celdaTdUsuario);
                tablaAcciones.appendChild(fila);
            });
            modalR.show();
        } catch (error) {
            console.error('Error:', error);
        }
    }
});

/* Detalle de rendición - Modal Pendientes */
document.querySelector("#table_pendientes")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        try {
            let response = await fetch('rendiciones/detalleRendicion/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Request-With': "XMLHttpRequest",
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                }
            });
            let data = await response.json();
            var tablaAcciones = document.getElementById("tablaAcciones");
            const tbody = tablaAcciones.getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            acciones = data.acciones;
            acciones.forEach((item) => {
                const fila = document.createElement('tr');
                const celdaTd = document.createElement('td');
                celdaTd.textContent = item.id || 'S/D';
                fila.appendChild(celdaTd);
                const celdaTdFecha = document.createElement('td');
                celdaTdFecha.textContent = item.fecha || 'S/D';
                fila.appendChild(celdaTdFecha); // Corregido: appendChild
                const celdaTdHora = document.createElement('td');
                celdaTdHora.textContent = item.hora || 'S/D'; // Corregido: usa item.hora
                fila.appendChild(celdaTdHora); // Corregido: appendChild
                const celdaTdDescripcion = document.createElement('td');
                celdaTdDescripcion.textContent = item.descripcion || 'S/D';
                fila.appendChild(celdaTdDescripcion);
                const celdaTdUsuario = document.createElement('td');
                celdaTdUsuario.textContent = item.usuario || 'S/D';
                fila.appendChild(celdaTdUsuario);
                tablaAcciones.appendChild(fila);
            });
            modalP.show();
        } catch (error) {
            console.error('Error:', error);
        }
    }
});

/* Detalle de rendición - Modal Observadas */
document.querySelector("#table_observadas")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        try {
            let response = await fetch('rendiciones/detalleRendicion/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Request-With': "XMLHttpRequest",
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                }
            });
            let data = await response.json();
            var tablaAcciones = document.getElementById("tablaAcciones");
            const tbody = tablaAcciones.getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            acciones = data.acciones;
            acciones.forEach((item) => {
                const fila = document.createElement('tr');
                const celdaTd = document.createElement('td');
                celdaTd.textContent = item.id || 'S/D';
                fila.appendChild(celdaTd);
                const celdaTdFecha = document.createElement('td');
                celdaTdFecha.textContent = item.fecha || 'S/D';
                fila.appendChild(celdaTdFecha);
                const celdaTdHora = document.createElement('td');
                celdaTdHora.textContent = item.hora || 'S/D'; // Corregido: usa item.hora
                fila.appendChild(celdaTdHora);
                const celdaTdDescripcion = document.createElement('td');
                celdaTdDescripcion.textContent = item.descripcion || 'S/D';
                fila.appendChild(celdaTdDescripcion);
                const celdaTdUsuario = document.createElement('td');
                celdaTdUsuario.textContent = item.usuario || 'S/D';
                fila.appendChild(celdaTdUsuario);
                tablaAcciones.appendChild(fila);
            });
            console.log('hola');
            modalO.show();
        } catch (error) {
            console.error('Error:', error);
        }
    }
});

/* Detalle de rendición - Modal Rechazadas */
document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e) {
    if (e.target && e.target.matches("i.fa-search")) {
        let id = e.target.getAttribute("data-id");
        try {
            let response = await fetch('rendiciones/detalleRendicion/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Request-With': "XMLHttpRequest",
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
              
                  }
            });
            let data = await response.json();
            var tablaAcciones = document.getElementById("tablaAcciones");
            const tbody = tablaAcciones.getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            acciones = data.acciones;
            acciones.forEach((item) => {
                const fila = document.createElement('tr');
                const celdaTd = document.createElement('td');
                celdaTd.textContent = item.id || 'S/D';
                fila.appendChild(celdaTd);
                const celdaTdFecha = document.createElement('td');
                celdaTdFecha.textContent = item.fecha || 'S/D';
                fila.appendChild(celdaTdFecha);
                const celdaTdHora = document.createElement('td');
                celdaTdHora.textContent = item.hora || 'S/D'; 
                fila.appendChild(celdaTdHora);
                const celdaTdDescripcion = document.createElement('td');
                celdaTdDescripcion.textContent = item.descripcion || 'S/D';
                fila.appendChild(celdaTdDescripcion);
                const celdaTdUsuario = document.createElement('td');
                celdaTdUsuario.textContent = item.usuario || 'S/D';
                fila.appendChild(celdaTdUsuario);
                tablaAcciones.appendChild(fila);
            });
            modalRe.show();
        } catch (error) {
            console.error('Error:', error);
        }
    }
});