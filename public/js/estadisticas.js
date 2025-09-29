let grafico;
const ctx = document.getElementById('grafico').getContext('2d');


function renderizarData(datos) {
    const anio = document.getElementById('filtroAnio').value;
    //const categoria = document.getElementById('filtroCategoria').value;
    //const dataFiltrada = datos[anio] || [];

    const rendiciones_no_iniciadas = datos['rendiciones_no_iniciadas']
    const rendiciones_revision = datos['rendiciones_revision']
    const rendiciones_objetadas = datos['rendiciones_objetadas']
    const rendiciones_aceptadas = datos['rendiciones_aceptadas']
    const rendiciones_rechazadas = datos['rendiciones_rechazadas']

    if(grafico) grafico.destroy();
    grafico = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [
            {
                label: `# de subvenciones por rendir`,
                data: rendiciones_no_iniciadas,
                backgroundColor: 'rgba(221, 226, 218, 0.63)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: `# de rendiciones en revisión`,
                data: rendiciones_revision,
                backgroundColor: 'rgba(62, 156, 219, 0.98)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: `# de rendiciones objetadas`,
                data: rendiciones_objetadas,
                backgroundColor: 'rgba(248, 252, 27, 0.97)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: `# de rendiciones aceptadas`,
                data: rendiciones_aceptadas,
                backgroundColor: 'rgba(69, 235, 54, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: `# de rendiciones rechazadas`,
                data: rendiciones_rechazadas,
                backgroundColor: 'rgba(235, 54, 54, 0.9)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }
        ]
        },
        options: {
            plugins: {
                legend: {
                    position: 'top',
                }},
        responsive: true,
        scales: {
            y: {
            beginAtZero: true,
            ticks: {
                stepSize: 5
            }
            }
        }
        }
    });
}

function actualizarAnio(e) {
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
    
    anio = document.getElementById('filtroAnio').value
    fetch(`${window.apiBaseUrl}estadisticas/cambiar-anio`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ anio: anio })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderizarData(data.grafico)
        } else {
            Swal.fire({
                title: "Error",
                text: data.message || "Error al cargar los datos de estadísticas",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: "Error al cargar los datos de estadísticas",
            icon: "error",
            confirmButtonText: "Aceptar"
        });
    });
}