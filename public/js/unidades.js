var table;
var modal = new bootstrap.Modal(document.getElementById("modalForm"));

$(document).ready(function () {
    table = $("#table_id").DataTable({
        deferRender: true,
        language: idioma ?? {},
        responsive: true,
        order: [],
    });

});

/**Formulario*/
document.querySelector("#form").addEventListener("submit", async function (event) {
    event.preventDefault();

    let form = event.target;

    let formData = new FormData(form);

    try {
        let response = await fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json",
            },
        });

        let data = await response.json();

        if (!response.ok) {
            if (data.errors) {
                clearErrors();

                for (const field in data.errors) {
                    if (data.errors.hasOwnProperty(field)) {
                        showError(field, data.errors[field]);
                    }
                }
            } else {
                throw new Error(data.error || "Ocurrió un error al editar la unidad.");
            }
        } else {
            Swal.fire({
                title: "Éxito",
                text: data.message,
                icon: "success",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "swal-success"
                },
            }).then(() => {
                modal.hide();
                window.location.href = window.apiBaseUrl + "unidades";
            });
        }
    } catch (error) {
        Swal.fire({
            title: "Error",
            text: error.message,
            icon: "error",
            confirmButtonText: "Intentar de nuevo",
            confirmButtonColor: "#d33",
        });
    }
});

/**Modal**/

/**Crear */
document.querySelector("#btnModal").addEventListener("click", function () {

    let form = document.querySelector("#modalForm form");

    form.reset();

    document.getElementById("modalFormTitulo").innerHTML = '<i class="fa-solid fa-file-lines me-2"></i> Registrar nueva Unidad';

    document.getElementById("btnForm").innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i> Guardar Unidad';

    form.action = `${window.apiBaseUrl}unidades/crear`;

    form.querySelector('input[name="_method"]')?.setAttribute("value", "POST");

    modal.show();
});

/**modificar */
document.querySelector("#table_id").addEventListener("click", function (e) {
    if (e.target && e.target.matches("i.fa-pen-square")) {
        let id = e.target.getAttribute("data-id");
        let nombre = e.target.getAttribute("data-nombre");
        let descripcion = e.target.getAttribute("data-descripcion");
        let form = document.querySelector("#modalForm form");

        document.getElementById("modalFormTitulo").innerHTML = '<i class="fa-solid fa-file-lines me-2"></i> Editar Unidad ' + id;

        document.getElementById("btnForm").innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i> Editar Unidad';

        form.action = `${window.apiBaseUrl}unidades/editar/${id}`;

        document.getElementById("unidad_id").value = id;

        document.getElementById("nombre").value = nombre;
        document.getElementById("descripcion").value = descripcion;

        form.querySelector('input[name="_method"]')?.setAttribute("value", "PUT");

        modal.show();
    }
});
