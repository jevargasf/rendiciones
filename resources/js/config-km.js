let url_app = "http://localhost:3000/";
let url_api = "https://appl.rancagua.cl/municipalidad/api/";

// nombre de la cookie generada en el AuthController
let nombre_cookie = "Paccc_config-km";
let contenido_cookie;
let data = {};

function verificarArchivo(url) {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open("HEAD", url);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    resolve();
                } else {
                    reject(new Error("El archivo no se encontró"));
                }
            }
        };
        xhr.onerror = function () {
            reject(new Error("Error al verificar la existencia del archivo"));
        };
        xhr.send();
    });
}

// verificar si se carga correctamente el archivo json para la animacion de lottie
verificarArchivo(url_api + "animations/lotti.json")
    .then(() => {
        let animationContainer = document.getElementById("animationContainer");

        let animation = bodymovin.loadAnimation({
            container: animationContainer,
            renderer: "svg",
            loop: false,
            autoplay: true,
            path: url_api + "animations/lotti.json",
        });
        animation.addEventListener("complete", function () {
            let loadingContainer = document.getElementById("loadingContainer");
            loadingContainer.classList.add("fade-out");
        });
    })
    .catch((error) => {
        let loadingContainer = document.getElementById("loadingContainer");
        loadingContainer.classList.add("fade-out");
    });
////////////////////////////////////////////////////////////////////////////
//obtener informacion de la cookie
let nameEQ = nombre_cookie + "=";
let ca = document.cookie.split(";");
for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === " ") c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0)
        contenido_cookie = decodeURIComponent(
            c.substring(nameEQ.length, c.length)
        );
}

// si viene contenido en la cookie se deja en data y sigue el proceso del config-km
// en caso de que no se encuentre la cookie se eliminara la sessionStorage para cuando
// exista una cookie pase por el endpont obtener-modulo
if (contenido_cookie != null) {
    data = JSON.parse(contenido_cookie);
} else {
    if (sessionStorage.getItem(nombre_cookie))
        sessionStorage.removeItem(nombre_cookie);
}
///////////////////////////////////////////////////////////////////////////////
document.addEventListener("DOMContentLoaded", function () {
    // validar si existe credencial_token en data
    if (data.hasOwnProperty("credencial_token")) {
        // validar si existe la sessionSotorage del modulo que tiene como nombre el de la cookie generada
        if (sessionStorage.getItem(nombre_cookie) == null) {
            const myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            const requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: contenido_cookie,
                redirect: "follow",
            };

            fetch(url_api + "api/obtener-modulo", requestOptions)
                .then((response) => response.json())
                .then((result) => {
                    sessionStorage.setItem(
                        nombre_cookie,
                        JSON.stringify(result.modules)
                    );
                    iniciar(result.modules);
                })
                .catch((error) => console.error(error));
        } else {
            // validar si se genero sessionStorage pero con undefined
            if (sessionStorage.getItem(nombre_cookie) != "undefined") {
                let modules = JSON.parse(sessionStorage.getItem(nombre_cookie));
                iniciar(modules);
            }
        }

        //////////////////////////////////////////
        ///////// CONFIG KM /////////////////////
        /////////////////////////////////////////

        function iniciar(modules) {
            let pathActual = window.location.pathname.substring(1);
            // esta funcion busca el path en el modulo, si existe entrega los permissions
            function findPath(path) {
                let resources = modules.resources;
                let resultado = resources.find((item) =>
                    compararRutas(item.path, path)
                );

                if (!resultado) return false;
                return resultado;
            }

            // esta funcion sirve para limpar las {} de los path en laravel y lo pasa como int, dado que
            // siempre cuando hay {} en laravel normalmente son id de los modelos, despues
            // compara si las dos rutas son iguales independiente si lleva {}
            // ejemplo:
            // const ruta1 = "usuarios/{usuario}";
            // const ruta2 = "usuarios/1";
            //console.log("resultado: " + compararRutas(ruta1, ruta2));
            // resultado: true
            function compararRutas(ruta1, ruta2) {
                const partesRuta1 = ruta1.split("/");
                const partesRuta2 = ruta2.split("/");

                // Verificar si el número de segmentos es el mismo
                if (partesRuta1.length !== partesRuta2.length) {
                    return false;
                }

                // Comparar cada segmento de las rutas
                for (let i = 0; i < partesRuta1.length; i++) {
                    const segmento1 = partesRuta1[i];
                    const segmento2 = partesRuta2[i];

                    // Si el segmento actual no está entre {}, verificar si es igual
                    if (
                        !/{([^}]+)}/.test(segmento1) &&
                        segmento1 !== segmento2
                    ) {
                        return false;
                    }

                    // Si el segmento actual está entre {} y no es un número, retornar falso
                    if (
                        /{([^}]+)}/.test(segmento1) &&
                        !/^\d+$/.test(segmento2)
                    ) {
                        return false;
                    }
                }

                // Si todas las comparaciones pasaron, las rutas son iguales
                return true;
            }

            // esta funcion sirve para limpar las {} de los path en laravel ej: usuarios/{usuario}/crear
            function limpiarPath(path) {
                const regex = /{[^}]+}/g;
                path = path.replace(regex, "");
                return path;
            }

            function obtenerPathDom(url) {
                //path = limpiarPath(path);

                url = new URL(url, window.location.origin);
                let pathUrlApp = new URL(url_app).pathname;
                let path = "";
                if (pathUrlApp.endsWith("/"))
                    path = url.pathname.substring(pathUrlApp.length - 1);
                else path = "/" + url.pathname.substring(pathUrlApp.length);

                return path;
            }

            function disabledForm(formulario, method) {
                if (method === "DELETE") {
                    formulario.style.display = "none";
                } else {
                    let elementos = formulario.elements;
                    for (let i = 0; i < elementos.length; i++) {
                        elementos[i].disabled = true;
                    }
                    let chosenElements = $(formulario).find(".chosen-select");
                    chosenElements
                        .prop("disabled", true)
                        .trigger("chosen:updated");
                }
            }

            function validarForm(formulario, method, resource) {
                if (formulario && method && resource) {
                    if (
                        resource.permissions.create.can == false &&
                        method == "POST"
                    ) {
                        disabledForm(formulario, method);
                    }
                    if (
                        resource.permissions.update.can == false &&
                        method == "PUT"
                    ) {
                        disabledForm(formulario, method);
                    }
                    if (
                        resource.permissions.delete.can == false &&
                        method == "DELETE"
                    ) {
                        disabledForm(formulario, method);
                    }
                    if (
                        resource.permissions.read.can == false &&
                        method == "GET"
                    ) {
                        disabledForm(formulario, method);
                    }
                    if (
                        resource.permissions.read.can == false &&
                        method == "PATCH"
                    ) {
                        disabledForm(formulario, method);
                    }
                }
            }

            ///////////////////////////////////////////////////////////////
            // foreach DOM (Enlaces y formularios)
            //////////////////////////////////////////////////////////////

            let enlaces = document.querySelectorAll("a");
            enlaces.forEach((enlace) => {
                let href = enlace.getAttribute("href");

                if (href) {
                    let path = obtenerPathDom(href);
                    let resource = findPath(path);
                    if (resource.path == path) {
                        if (resource.permissions.read.can == false) {
                            enlace.style.display = "none";
                        }
                    }
                }
            });

            // Obtener todos los formularios en la página
            let formularios = document.querySelectorAll("form");
            let countFormularios = formularios.length;
            let pass = true;

            formularios.forEach(function (formulario) {
                let metodoFormulario = formulario.method.toUpperCase();
                let valorCampoMethod = "";

                // Verificar si el formulario tiene un campo "_method"
                let tieneCampoMethod =
                    formulario.querySelector('input[name="_method"]') !== null;
                if (formulario.querySelector('input[name="_method"]')) {
                    valorCampoMethod = formulario
                        .querySelector('input[name="_method"]')
                        .value.toUpperCase();
                }
                let method = tieneCampoMethod
                    ? valorCampoMethod
                    : metodoFormulario;

                let path = obtenerPathDom(formulario.action);
                //obtener resource de acuerdo al path del action del formulario

                let resource = findPath(path);
                validarForm(formulario, method, resource);
                if (pass) {
                    // obtener resource de acuerdo al path actual
                    resource = findPath(pathActual);
                    validarForm(formulario, method, resource);
                    pass = false;
                }
            });
        }
    }
});
