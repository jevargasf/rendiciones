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











