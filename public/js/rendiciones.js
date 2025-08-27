
/*Busca en la página el elemento con id="modalDetalleRendicion" y lo guarda en la variable modalRendidas
*/

const { default: laravel } = require("laravel-vite-plugin");


var modalRendidas = document.getElementById("modalDetalleRendicion"); 
var modalR = modalRendidas ? new bootstrap.Modal(modalRendidas) : null;

/* Por cada pestaña de Pendientes, Observadas, Rendidas crear una variable */

var modalPendientes = document.getElementById("modalDetallePendientes"); 
var modalP = modalPendientes ? new bootstrap.Modal(modalPendientes) : null;

var modalObservadas = document.getElementById("modalDetalleObservadas");
var modalO = modalObservadas ? new bootstrap.Modal(modalObservadas) : null;

var modalRechazadas = document.getElementById("modalDetalleRechazadas");
var modalRe = modalRechazadas ? new bootstrap.Modal(modalRechazadas) : null;


/**Copiar desde aca para realizar la misma accion de la lupa para ver Detalle de Rendición -> Acciones pero en las pestañas pendientes - observadas - rechazadas */
document.querySelector("#table_id")?.addEventListener("click", async function (e){ /**boton*/ /**ignifica que tu función trabaja con operaciones asíncronas (que no son instantáneas) y te permite usar la palabra await para esperar la respuesta antes de seguir. */

    if (e.target && e.target.matches("i.fa-search")) {
        console.log("funciona perfecto");


/*Para que botón (la lupa) pueda tomar el valor, es decir cuando se presione para ver el detalle de la rendición se muestre la información relacionada a ese Id*/
/*  Obtiene el valor del atributo data-id del elemento en el que se hizo clic y lo guarda en la variable id*/

        let id = e.target.getAttribute("data-id");

        try {
          let response = await fetch(`rendicionesDos/detalleRendicion/${id}`,{
            method:'POST', 

            headers: {
                'Content-Type': 'application/json',  /**El contenido enviado esta en formato JSON*/
                'X-Request-With':"XMLHttpRequest",  /**Que la información viene de JS */
                'X-CSRF-TOKEN': window.Laravel.csrfToken, /**Token de seguridad */

            }
          });  
          
          let data = await response.json(); /**Convierte la respuesta del servidor en un objeto JSON que JS pueda usar */
          
          var tablaAcciones = document.getElementById("tablaAcciones"); 
          const tbody = tablaAcciones.getElementsByTagName ('tbody')[0];

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
            celdaTdHora.textContent = item.fecha || 'S/D';
            fila.appendChild(celdaTdHora);                          

            const celdaTdDescripcion = document.createElement('td');
            celdaTdDescripcion.textContent = item.descripcion || 'S/D';
            fila.appendChild(celdaTdDescripcion);

            const celdaTdUsuario = document.createElement('td');
            celdaTdUsuario.textContent = item.usuario || 'S/D';
            fila.appendChild(celdaTdUsuario);

            tablaAcciones.appendChild(fila);




          });

          console.log('hola')
          modalR.show();

/**Si ocurre algún error en el fetch o al convertir la respuesta,
// se captura aquí dentro del bloque catch */


        } catch (error) {
            
        }





    }
});    


 //**Detalle de rendición - Modal Pendientes */
document.querySelector("#table_pendientes")?.addEventListener("click", async function (e){ 

    if (e.target && e.target.matches("i.fa-search")) {
        console.log("funciona");

        let id = e.target.getAttribute("data-id");

        try {
          let response = await fetch(`rendicionesDos/detalleRendicion/${id}`,{  //*No cambiar*/
            method:'POST', 

            headers: {
                'Content-Type': 'application/json',  /**El contenido enviado esta en formato JSON*/
                'X-Request-With':"XMLHttpRequest",  /**Que la información viene de JS */
                'X-CSRF-TOKEN': window.Laravel.csrfToken, /**Token de seguridad */

            }
          });
          
          let data = await response.json(); 
          
          var tablaAcciones = document.getElementById("tablaAcciones"); 
          const tbody = tablaAcciones.getElementsByTagName ('tbody')[0];

          tbody.innerHTML = '';


          acciones = data.acciones;

          acciones.forEach((item) => {


            const fila = document.createElement('tr');

            const celdaTd = document.createElement('td');
            celdaTd.textContent = item.id || 'S/D';
            fila.appendChild(celdaTd);

            const celdaTdFecha = document.createElement('td');
            celdaTdFecha.textContent = item.fecha || 'S/D';
            fila.appeldChild(celdaTdFecha);

            const celdaTdHora = document.createElement('td');
            celdaTdHora.textContent = item.hora || 'S/D';
            fila.appeldChild(celdaTdHora);
            
            const celdaTdDescripcion = document.createElement ('td');
            celdaTdDescripcion.textContent = item.descripcion || 'S/D';
            fila.appendChild(celdaTdDescripcion);

            const celdaTdUsuario = document.createElement('td');
            celdaTdUsuario.textContent = item.usuario || 'S/D';
            fila.appendChild(celdaTdUsuario);    




          });

          console.log('hola')
          modalP.show();

/**Si ocurre algún error en el fetch o al convertir la respuesta,
// se captura aquí dentro del bloque catch */


        } catch (error) {
            
        }





    }
});  


 //**Detalle de rendición - Modal Observadas */
document.querySelector("#table_observadas")?.addEventListener("click", async function (e){ 

    if (e.target && e.target.matches("i.fa-search")) {
        console.log("funciona perfecto");

        let id = e.target.getAttribute("data-id");

        try {
          let response = await fetch(`rendicionesDos/detalleRendicion/${id}`,{  //*No cambiar*/
            method:'POST', 

            headers: {
                'Content-Type': 'application/json',  /**El contenido enviado esta en formato JSON*/
                'X-Request-With':"XMLHttpRequest",  /**Que la información viene de JS */
                'X-CSRF-TOKEN': window.Laravel.csrfToken, /**Token de seguridad */

            }
          });
          
          let data = await response.json(); 
          
          var tablaAcciones = document.getElementById("tablaAcciones"); 
          const tbody = tablaAcciones.getElementsByTagName ('tbody')[0];

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
            celdaTdHora.textContent = item.fecha || 'S/D';
            fila.appendChild(celdaTdHora);                          

            const celdaTdDescripcion = document.createElement('td');
            celdaTdDescripcion.textContent = item.descripcion || 'S/D';
            fila.appendChild(celdaTdDescripcion);

            const celdaTdUsuario = document.createElement('td');
            celdaTdUsuario.textContent = item.usuario || 'S/D';
            fila.appendChild(celdaTdUsuario);

            tablaAcciones.appendChild(fila);




          });

          console.log('hola')
          modalO.show();

/**Si ocurre algún error en el fetch o al convertir la respuesta,
// se captura aquí dentro del bloque catch */


        } catch (error) {
            
        }





    }
});  

 //**Detalle de rendición - Modal Rechazadas */
document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e){ 

    if (e.target && e.target.matches("i.fa-search")) {
        console.log("funciona perfecto");

        let id = e.target.getAttribute("data-id");

        try {
          let response = await fetch(`rendicionesDos/detalleRendicion/${id}`,{  //*No cambiar*/
            method:'POST', 

            headers: {
                'Content-Type': 'application/json',  /**El contenido enviado esta en formato JSON*/
                'X-Request-With':"XMLHttpRequest",  /**Que la información viene de JS */
                'X-CSRF-TOKEN': window.Laravel.csrfToken, /**Token de seguridad */

            }
          });
          
          let data = await response.json(); 
          
          var tablaAcciones = document.getElementById("tablaAcciones"); 
          const tbody = tablaAcciones.getElementsByTagName ('tbody')[0];

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
            celdaTdHora.textContent = item.fecha || 'S/D';
            fila.appendChild(celdaTdHora);                          

            const celdaTdDescripcion = document.createElement('td');
            celdaTdDescripcion.textContent = item.descripcion || 'S/D';
            fila.appendChild(celdaTdDescripcion);

            const celdaTdUsuario = document.createElement('td');
            celdaTdUsuario.textContent = item.usuario || 'S/D';
            fila.appendChild(celdaTdUsuario);

            tablaAcciones.appendChild(fila);




          });

          console.log('hola')
          modalRe.show();

/**Si ocurre algún error en el fetch o al convertir la respuesta,
// se captura aquí dentro del bloque catch */


        } catch (error) {
            
        }





    }
});  



