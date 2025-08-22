<x-app title="Rendiciones">

    <x-header />


    <!-- Encabezado principal -->
    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="mb-5">
                Rendiciones
                <a class="btn mb-1 font-weight-bold btn-app float-end" id="btnModal">
                    <i class="fa-solid fa-plus"></i> Registrar Pilar
                </a>
            </h5>

            <!-- Tablas -->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-rendidas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-rendidas" type="button" role="tab" aria-controls="nav-rendidas"
                        aria-selected="true">
                        Rendidas
                    </button>

                    <button class="nav-link" id="nav-pendientes-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-pendientes" type="button" role="tab" aria-controls="nav-pendientes"
                        aria-selected="false">
                        Pendientes
                    </button>

                    <button class="nav-link" id="nav-observadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-observadas" type="button" role="tab" aria-controls="nav-observadas"
                        aria-selected="false">
                        Observadas
                    </button>

                    <button class="nav-link" id="nav-rechazadas-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-rechazadas" type="button" role="tab" aria-controls="nav-rechazadas"
                        aria-selected="false">
                        Rechazadas
                    </button>
                </div>
            </nav>

            <!-- Tabla de contenidos -->
            <div class="tab-content" id="nav-tabContent">
                <!-- RENDIDAS -->
                <div class="tab-pane fade show active" id="nav-rendidas" role="tabpanel"
                    aria-labelledby="nav-rendidas-tab" tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_id" class="table table-striped mx-auto">  <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_id")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i> #
                                    </th>
                                    <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th><i class="fas fa-sort me-1"></i> Monto</th>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i> Opciones
                                    </th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach ($rendiciones as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->rutOrganizaciones }}</td>
                                        <td>{{ $item->nombreOrganizaciones }}</td>
                                        <td>{{ $item->decretoSubvenciones }}</td>
                                        <td>865501</td>
                                        <td class="monto" data-valor="80000">{{ $item->montoSubvenciones }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        {{-- Guarda el ID del registro para usarlo en JavaScript --}}></i>

                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PESTAÑA PENDIENTES -->
                <div class="tab-pane fade" id="nav-pendientes" role="tabpanel" aria-labelledby="nav-pendientes-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_pendientes" class="table table-striped mx-auto">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i> #
                                    </th>
                                    <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th><i class="fas fa-sort me-1"></i> Monto</th>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i> Opciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendientes as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->rutOrganizaciones }}</td>
                                        <td>{{ $item->nombreOrganizaciones }}</td>
                                        <td>{{ $item->decretoSubvenciones }}</td>
                                        <td>346544</td>
                                        <td class="monto" data-valor="80000">{{ $item->montoSubvenciones }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        {{-- Guarda el ID del registro para usarlo en JavaScript --}}></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- OBSERVADAS -->
                <div class="tab-pane fade" id="nav-observadas" role="tabpanel" aria-labelledby="nav-observadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_observadas" class="table table-striped mx-auto"> <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_observadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i>#
                                    </th>
                                    <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th><i class="fas fa-sort me-1"></i> Monto</th>
                                    <th><i class="fas fa-sort me-1"></i> Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($observadas as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->rutOrganizaciones }}</td>
                                        <td>{{ $item->nombreOrganizaciones }}</td>
                                        <td>{{ $item->decretoSubvenciones }}</td>
                                        <td>346544</td>
                                        <td class="monto" data-valor="80000">{{ $item->montoSubvenciones }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"
                                                        {{-- Guarda el ID del registro para usarlo en JavaScript --}}></i>
                                                </button>
                                                <!--    <button type="button" class="btn btn-accion btn-link align-baseline"
                                                    data-bs-toggle="modal" data-bs-target="#modalVer">
                                                    <i class="bi bi-search"></i>
                                                </button> Antiguo boton  -->

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--Pestaña Tabla Rechazadas-->

                <div class="tab-pane fade" id="nav-rechazadas" role="tabpanel" aria-labelledby="nav-rechazadas-tab"
                    tabindex="0">
                    <div class="table-responsive mt-3">
                        <table id="table_rechazadas" class="table table-striped mx-auto"> <!-- nombre de tabla llamada en archivo JS document.querySelector("#table_rechazadas")?.addEventListener("click", async function (e)-->
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-sort me-1"></i>#
                                    </th>
                                    <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                    <th><i class="fas fa-sort me-1"></i> R.U.T</th>
                                    <th><i class="fas fa-sort me-1"></i> Organización</th>
                                    <th><i class="fas fa-sort me-1"></i> Decreto</th>
                                    <th><i class="fas fa-sort me-1"></i> Nro. Movimiento</th>
                                    <th><i class="fas fa-sort me-1"></i> Monto</th>
                                    <th><i class="fas fa-sort me-1"></i> Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rechazadas as $item)
                                    <tr>
                                        <td class="td-5">{{ $item->id }}</td>
                                        <td class="fecha" data-order="2025-05-29">29/05/2025</td>
                                        <td>{{ $item->rutOrganizaciones }}</td>
                                        <td>{{ $item->nombreOrganizaciones }}</td>
                                        <td>{{ $item->decretoSubvenciones }}</td>
                                        <td>346544</td>
                                        <td class="monto" data-valor="80000">{{ $item->montoSubvenciones }}</td>
                                        <td class="td-5">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-accion btn-link align-baseline">
                                                    <i class="fas fa-search" data-id="{{ $item->id }}"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /Encabezado principal -->

    <!-- Modal “Ver detalle” con dos pestañas internas -->
    <div class="modal fade" id="modalDetalleRendicion" tabindex="-1" aria-labelledby="modalDetalleRendicionLabel"
        aria-hidden="true">
        <!--se corrige el nombre del modal de acuerdo a JS para que funcione, antes tenia nombre "VER DETALLE"-->
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title" id="modalDetalleRendicionLabel">Detalle de rendición</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- Módulos de pestañas -->
                <div class="modal-body pb-0">
                    <ul class="nav nav-tabs" id="innerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100" id="tab1-tab" data-bs-toggle="tab"
                                data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                aria-selected="true">
                                Acciones
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="tab2-tab" data-bs-toggle="tab"
                                data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                aria-selected="false">
                                Notificaciones
                            </button>
                        </li>
                    </ul>

                    <!-- Contenido de tabs -->
                    <div class="bg-white border rounded-4 p-3 shadow-sm" id="tabsBox">
                        <div class="tab-content" id="innerTabsContent">
                            <!-- Acciones -->
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                aria-labelledby="tab1-tab">
                                <div class="table-responsive mt-2">
                                    <table class="table table-striped table-sm mb-0" id="tablaAcciones">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Acción realizada</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Notificaciones -->
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                <div class="table-responsive mt-2">
                                    <table class="table table-striped table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-sort me-1"></i> #</th>
                                                <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                                <th><i class="fas fa-sort me-1"></i> Hora</th>
                                                <th><i class="fas fa-sort me-1"></i> Destino de recursos</th>
                                                <th><i class="fas fa-sort me-1"></i> Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>25951</td>
                                                <td>20/04/2025</td>
                                                <td>8:00</td>
                                                <td>Hoy vence el plazo para rendición</td>
                                                <td>No leído</td>
                                            </tr>
                                            <tr>
                                                <td>25810</td>
                                                <td>15/04/2025</td>
                                                <td>8:30</td>
                                                <td>Recordatorio de plazo de vencimiento</td>
                                                <td>Leído</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Se crea modal para ver Detalles de Rendición en pestaña Pendientes -->

                <!-- Modal “Ver detalle” con dos pestañas internas -->
                <!--Importante: para verificar que tome esta tabla de detalle de rendiciones es necesario cambiar el id y en aria-labelledby debe ir lo mismo de id: modalDetallePendientes  -->
                <div class="modal fade" id="modalDetallePendientes" tabindex="-1"
                    aria-labelledby="modalDetallePendientesLabel" aria-hidden="true">
                    <!--se corrige el nombre del modal de acuerdo a JS para que funcione, antes tenia nombre "VER DETALLE"-->
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <div class="modal-header modal-header-app">
                                <h5 class="modal-title" id="modalDetalleRendicionLabel">Detalle de rendición</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>

                            <!-- Módulos de pestañas -->
                            <div class="modal-body pb-0">
                                <ul class="nav nav-tabs" id="innerTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active w-100" id="tab1-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab1" type="button" role="tab"
                                            aria-controls="tab1" aria-selected="true">
                                            Acciones
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link w-100" id="tab2-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab2" type="button" role="tab"
                                            aria-controls="tab2" aria-selected="false">
                                            Notificaciones
                                        </button>
                                    </li>
                                </ul>

                                <!-- Contenido de tabs -->
                                <div class="bg-white border rounded-4 p-3 shadow-sm" id="tabsBox">
                                    <div class="tab-content" id="innerTabsContent">
                                        <!-- Acciones -->
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                            aria-labelledby="tab1-tab">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-sm mb-0" id="tablaAcciones">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Acción realizada</th>
                                                            <th>Usuario</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Notificaciones -->
                                        <div class="tab-pane fade" id="tab2" role="tabpanel"
                                            aria-labelledby="tab2-tab">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-sort me-1"></i> #</th>
                                                            <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                                            <th><i class="fas fa-sort me-1"></i> Hora</th>
                                                            <th><i class="fas fa-sort me-1"></i> Destino de recursos
                                                            </th>
                                                            <th><i class="fas fa-sort me-1"></i> Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>25951</td>
                                                            <td>20/04/2025</td>
                                                            <td>8:00</td>
                                                            <td>Hoy vence el plazo para rendición</td>
                                                            <td>No leído</td>
                                                        </tr>
                                                        <tr>
                                                            <td>25810</td>
                                                            <td>15/04/2025</td>
                                                            <td>8:30</td>
                                                            <td>Recordatorio de plazo de vencimiento</td>
                                                            <td>Leído</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /modal-body -->



                <!-- Se crea modal para ver Detalles de Rendición en pestaña Observadas -->

                <!-- Modal “Ver detalle” con dos pestañas internas -->
                <!--Importante: para verificar que tome esta tabla de detalle de rendiciones es necesario cambiar el id y en aria-labelledby debe ir lo mismo de id: modalDetallePendientes  -->
                <div class="modal fade" id="modalDetalleObservadas" tabindex="-1"
                    aria-labelledby="modalDetalleObservadasLabel" aria-hidden="true">
                    <!--se corrige el nombre del modal de acuerdo a JS para que funcione, antes tenia nombre "VER DETALLE"-->
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <div class="modal-header modal-header-app">
                                <h5 class="modal-title" id="modalDetalleRendicionLabel">Detalle de rendición</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>

                            <!-- Módulos de pestañas -->
                            <div class="modal-body pb-0">
                                <ul class="nav nav-tabs" id="innerTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active w-100" id="tab1-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab1" type="button" role="tab"
                                            aria-controls="tab1" aria-selected="true">
                                            Acciones
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link w-100" id="tab2-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab2" type="button" role="tab"
                                            aria-controls="tab2" aria-selected="false">
                                            Notificaciones
                                        </button>
                                    </li>
                                </ul>

                                <!-- Contenido de tabs -->
                                <div class="bg-white border rounded-4 p-3 shadow-sm" id="tabsBox">
                                    <div class="tab-content" id="innerTabsContent">
                                        <!-- Acciones -->
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                            aria-labelledby="tab1-tab">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-sm mb-0" id="tablaAcciones">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Acción realizada</th>
                                                            <th>Usuario</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Notificaciones -->
                                        <div class="tab-pane fade" id="tab2" role="tabpanel"
                                            aria-labelledby="tab2-tab">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-sort me-1"></i> #</th>
                                                            <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                                            <th><i class="fas fa-sort me-1"></i> Hora</th>
                                                            <th><i class="fas fa-sort me-1"></i> Destino de recursos
                                                            </th>
                                                            <th><i class="fas fa-sort me-1"></i> Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>25951</td>
                                                            <td>20/04/2025</td>
                                                            <td>8:00</td>
                                                            <td>Hoy vence el plazo para rendición</td>
                                                            <td>No leído</td>
                                                        </tr>
                                                        <tr>
                                                            <td>25810</td>
                                                            <td>15/04/2025</td>
                                                            <td>8:30</td>
                                                            <td>Recordatorio de plazo de vencimiento</td>
                                                            <td>Leído</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /modal-body -->

                <!-- Se crea modal para ver Detalles de Rendición en pestaña Rechazadas -->

                <!-- Modal “Ver detalle” con dos pestañas internas -->
                <!--Importante: para verificar que tome esta tabla de detalle de rendiciones es necesario cambiar el id y en aria-labelledby debe ir lo mismo de id: modalDetallePendientes  -->
                <div class="modal fade" id="modalDetalleRechazadas" tabindex="-1"
                    aria-labelledby="modalDetalleRechazadasLabel" aria-hidden="true">
                    <!--se corrige el nombre del modal de acuerdo a JS para que funcione, antes tenia nombre "VER DETALLE"-->
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <div class="modal-header modal-header-app">
                                <h5 class="modal-title" id="modalDetalleRendicionLabel">Detalle de rendición</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>

                            <!-- Módulos de pestañas -->
                            <div class="modal-body pb-0">
                                <ul class="nav nav-tabs" id="innerTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active w-100" id="tab1-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab1" type="button" role="tab"
                                            aria-controls="tab1" aria-selected="true">
                                            Acciones
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link w-100" id="tab2-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab2" type="button" role="tab"
                                            aria-controls="tab2" aria-selected="false">
                                            Notificaciones
                                        </button>
                                    </li>
                                </ul>

                                <!-- Contenido de tabs -->
                                <div class="bg-white border rounded-4 p-3 shadow-sm" id="tabsBox">
                                    <div class="tab-content" id="innerTabsContent">
                                        <!-- Acciones -->
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                            aria-labelledby="tab1-tab">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-sm mb-0" id="tablaAcciones">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Acción realizada</th>
                                                            <th>Usuario</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Notificaciones -->
                                        <div class="tab-pane fade" id="tab2" role="tabpanel"
                                            aria-labelledby="tab2-tab">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-striped table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th><i class="fas fa-sort me-1"></i> #</th>
                                                            <th><i class="fas fa-sort me-1"></i> Fecha</th>
                                                            <th><i class="fas fa-sort me-1"></i> Hora</th>
                                                            <th><i class="fas fa-sort me-1"></i> Destino de recursos
                                                            </th>
                                                            <th><i class="fas fa-sort me-1"></i> Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>25951</td>
                                                            <td>20/04/2025</td>
                                                            <td>8:00</td>
                                                            <td>Hoy vence el plazo para rendición</td>
                                                            <td>No leído</td>
                                                        </tr>
                                                        <tr>
                                                            <td>25810</td>
                                                            <td>15/04/2025</td>
                                                            <td>8:30</td>
                                                            <td>Recordatorio de plazo de vencimiento</td>
                                                            <td>Leído</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /modal-body -->


                <!-- Footer fuera del body, a todo el ancho -->
                <div class="modal-footer bg-light d-flex justify-content-end py-2 px-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1"
                        data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal Ver -->


    <!-- Modal Formulario -->
    <div class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="modalFormTitulo">Cargando...</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="form">
                    <div class="modal-body p-4">
                        <div class="container">
                            <div class="p-4 rounded">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label required fw-bold">Título</label>
                                    <input type="text" class="form-control shadow-sm" id="titulo"
                                        name="titulo" required placeholder="Ej: Educación Rancagua empoderado..." />
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label required fw-bold">Descripción</label>
                                    <textarea class="form-control shadow-sm" id="descripcion" name="descripcion" rows="8" required
                                        placeholder="Ej: Potenciar y fomentar la educación ambiental..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill"
                            data-bs-dismiss="modal">
                            <i class="fa-solid fa-arrow-left me-2"></i>Cerrar
                        </button>
                        <button type="submit" class="btn btn-app px-4 py-2 rounded-pill shadow-sm"
                            id="btnForm">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal Formulario -->

    <!-- Footer -->
    <div class="row fixed-bottom bg-light" style="border-top: 1px solid #eee">
        <div class="col-md-12">
            <footer class="footer" style="padding: 10px !important; margin: 0px !important; font-size: 14px">
                <p class="text-center" style="margin: 0px !important; font-size: 13px; color: #666">
                    Departamento de Computación e Informática -
                    <a style="color: #333" target="_blank" href="http://www.rancagua.cl">Ilustre Municipalidad de
                        Rancagua</a>
                </p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/rendiciones.js') }}" defer></script> <!-- se llama el script relacionado con la página -->

    <!-- Aquí se eliminaron todos los scripts relacionados con funciones de JavaScript estáticas,(no había archivo antes de JS)
     ya que ahora se va a usar el archivo script src="asset('js/rendiciones.js'" defer></script. -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>

    <x-footer />
</x-app>
