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


        if (!response.ok){
            if(data.errors){

            }
            else {
                throw new Error(data.eror || "Ocurrió un error al editar la unidad");
            }
        }
        
        else{
            
            Swal.fire({
                title:"Éxito",
                text: data.message,
                icon: "succes",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "swal-success"
                },                
            }).then(()=> {
                modal.hide();
                window.location.href=window.apiBaseUrl + "subvenciones";
            });    
        }
   

    } catch(error){

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











