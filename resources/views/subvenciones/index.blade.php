<x-app title="Subvenciones">

    <x-header />
    <!-- Primer encabezado -->
    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">
                Subvenciones
                <a class="btn mb-1 font-weight-bold btn-app float-end" id="btnModal">
                    <i class="fa-solid fa-plus"></i> Agregar subvención
                </a>
            </h5>

            <!-- Buscador -->
                    <div class="col-md-12 w-100 mt-4" id="contenedor_busqueda">
                    </div>


            <!--Tabla Datos Subvenciones con data table -->

            <div class="table-responsive">
                <table id="table_subvenciones" class="table table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>RUT</th>
                            <th>Organización</th>
                            <th>Decreto</th>
                            <th>Monto</th>
                            <th>Destino</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <!-- Modal Ver Detalles -->
            <x-subvenciones.modal-ver-detalles />
        </div>

        <!-- Modal Editar -->
        <x-subvenciones.modal-editar />
        <!-- Modal Rendir Subvención -->
        <x-subvenciones.modal-rendir />
        <!-- Modal Eliminar Subvención -->
        <x-subvenciones.modal-eliminar />
    </div>
    <!-- Modal Agregar Subvención -->
    <x-subvenciones.modal-agregar />
    <script>
        document.addEventListener('show.bs.modal', function(e) {

            const idsQueMuevo = ['modalRendirsubvencion'];

            if (idsQueMuevo.includes(e.target.id)) {

                if (e.target.parentElement !== document.body) {
                    document.body.appendChild(e.target);
                }
            }
        });
                // Data tables

    $(document).ready(function(){
        subvenciones = @json($subvenciones);
        $('#table_subvenciones').DataTable({
        data: subvenciones,
        info: false,
        lengthChange: false,
        order: [ 0, 'desc' ],
        language: idioma,
        deferRender: true,
        responsive: true,
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
                data: 'rut',
                render: // Formatear RUT
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
            },
            { 
                data: 'data_organizacion.nombre_organizacion',
                defaultContent: 'S/D'
            },
            { data: 'decreto' },
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
            { data: 'destino' },
            {
                data: null,
                ordeable: false,
                searchable: false,
                render: function(data, type, row){
                    id = row.id
                    return `
                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                            <!-- Ver detalles -->
                            <button class="btn btn-accion" data-bs-target="#modalVerDetalles"
                                onclick="verDetalleSubvencion(${id})"
                                data-bs-toggle="modal" title="Ver detalles" type="button">
                                <i class="fas fa-search"> </i>
                            </button>
                            <!-- Editar -->
                            <button class="btn btn-success btn-accion" 
                                title="Editar" type="button" 
                                onclick="abrirModalEditar(${id})">
                                <i class="fas fa-file-signature"> </i>
                            </button>
                            <!-- Rendir subvención -->
                            <button class="btn btn-success btn-accion"
                                onclick="abrirModalRendir(${id})"
                                title="Rendir subvención" type="button">
                                <i class="fas fa-clipboard-check icon-static-blue"></i>
                            </button>
                            <!-- Eliminar -->
                            <button class="btn btn-success btn-accion btn-eliminar-subvencion" 
                                title="Eliminar" type="button" data-subvencion-id="${id}">
                                <i class="fas fa-times-circle"> </i>
                            </button>
                        </div>

                    `
                }
            }
        ]
    });
    $('#contenedor_busqueda').append($('.dataTables_filter'));
    $('.dataTables_filter').addClass('d-flex mb-0');
    $('.dataTables_filter input')
        .addClass('form-control w-100 shadow-sm')
        .css({
            'padding': '0.375rem 0.75rem',
            'font-size': '0.875rem'
        }).attr('placeholder', 'Buscar...');
    $('.dataTables_filter label').addClass('w-100').css('margin-bottom', '0');
})                
    </script>

    <script src="{{ asset('js/subvenciones.js') }}" defer></script>

    <script>
        // Funcionalidad para eliminar subvenciones
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-eliminar-subvencion')) {
                const button = e.target.closest('.btn-eliminar-subvencion');
                const subvencionId = button.getAttribute('data-subvencion-id');
                
                // Obtener datos de la subvención desde la fila
                const fila = button.closest('tr');
                const celdas = fila.querySelectorAll('td');
                
                // Llenar el modal con los datos de la subvención
                document.getElementById('modalEliminarSubvencionLabel').textContent = `Eliminar subvenciones decreto N° ${celdas[4].textContent}`
                document.getElementById('advertencia_eliminar').innerHTML = `Al eliminar esta subvención, se eliminarán <strong>TODAS las subvenciones</strong> asociadas al decreto <strong>${celdas[4].textContent}</strong>. Esta acción no se puede deshacer.`
                document.getElementById('eliminarSubvencionId').textContent = celdas[0].textContent;
                document.getElementById('eliminarSubvencionRut').textContent = celdas[2].textContent;
                document.getElementById('eliminarSubvencionOrganizacion').textContent = celdas[3].textContent;
                document.getElementById('eliminarSubvencionDecreto').textContent = celdas[4].textContent;
                document.getElementById('eliminarSubvencionMonto').textContent = celdas[5].textContent;
                document.getElementById('eliminarSubvencionDestino').textContent = celdas[6].textContent;
                document.getElementById('confirmarDecreto').textContent = celdas[4].textContent;
                
                // Limpiar campos del modal
                document.getElementById('motivoEliminacion').value = '';
                document.getElementById('confirmarEliminacion').checked = false;
                document.getElementById('btnConfirmarEliminacion').disabled = true;
                
                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalEliminarSubvencion'));
                modal.show();
                
                // Guardar el ID para usar después
                document.getElementById('btnConfirmarEliminacion').setAttribute('data-subvencion-id', subvencionId);
            }
        });

        // Funcionalidad para habilitar/deshabilitar botón de confirmación
        document.addEventListener('input', function(e) {
            if (e.target.id === 'motivoEliminacion' || e.target.id === 'confirmarEliminacion') {
                const motivo = document.getElementById('motivoEliminacion').value.trim();
                const confirmado = document.getElementById('confirmarEliminacion').checked;
                const btnConfirmar = document.getElementById('btnConfirmarEliminacion');
                
                btnConfirmar.disabled = !(motivo.length > 0 && confirmado);
            }
        });

        // Funcionalidad para el botón de confirmación de eliminación
        document.addEventListener('click', function(e) {
            if (e.target.id === 'btnConfirmarEliminacion') {
                const subvencionId = e.target.getAttribute('data-subvencion-id');
                const motivo = document.getElementById('motivoEliminacion').value.trim();
                
                if (subvencionId && motivo) {
                    eliminarSubvencion(subvencionId, motivo);
                }
            }
        });

        // Función para eliminar subvención
        function eliminarSubvencion(id, motivo) {
            // Cerrar el modal primero
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarSubvencion'));
            modal.hide();
            
            // Mostrar SweetAlert de carga
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espere',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar petición AJAX
            fetch('{{ route("subvenciones.eliminar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                   document.querySelector('input[name="_token"]')?.value
                },
                body: JSON.stringify({
                    id: id,
                    motivo: motivo
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Recargar la página para actualizar la tabla
                        window.location.reload();
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar la subvención',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }

    </script>
    <x-footer />


</x-app>
