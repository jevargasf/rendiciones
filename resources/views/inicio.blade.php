<x-app title="Estadísticas">

    <x-header />

    <div class="container justify-content-center py-3 mt-5">

        <h5 class="mb-4">Estadísticas</h5>
        @if (in_array(Session::get('perfil.perfil_id_km'), [1, 2]))
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="graficos-tab" data-bs-toggle="tab" data-bs-target="#graficos"
                        type="button" role="tab" aria-controls="graficos" aria-selected="true">Graficos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial"
                        type="button" role="tab" aria-controls="historial" aria-selected="false">Historial</button>
                </li>
            </ul>
        @endif

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">

                @if (in_array(Session::get('perfil.perfil_id_km'), [1, 2, 5]))
                    <div class="shadow-sm border rounded text-center mb-5">
                        <h5 class="highcharts-title fw-bold mb-2">Porcentaje de Cumplimiento por Pilar</h5>
                        <div id="pie-container" class="d-flex  justify-content-center mm-5"></div>
                    </div>
                @endif

                <!-- Menú tabs estadísticas -->
                <div class="mb-2">
                    <div class="row g-3 align-items-center" role="tablist">
                        <div class="col-md-4" style="height: 10rem;" role="presentation">
                                <button type="button" class="btn btn-light w-100 h-100 active" data-bs-toggle="pill" data-bs-target="#subvenciones" role="tab" aria-pressed="true" aria-controls="subvenciones" id="subvenciones-tab">
                                    Subvenciones<span class="badge text-bg-secondary">{{ $subvenciones }}</span>
                                </button>
                        </div>
                        <div class="col-md-4" style="height: 10rem;">
                                <button type="button" class="btn btn-light w-100 h-100" data-bs-toggle="pill" data-bs-target="#rendiciones" role="tab"  aria-pressed="false" aria-controls="rendiciones" id="rendiciones-tab">
                                    Rendiciones <span class="badge text-bg-secondary">{{ $rendiciones }}</span>
                                </button>
                        </div>
                        <div class="col-md-4" style="height: 10rem;">
                                <button type="button" class="btn btn-light w-100 h-100" data-bs-toggle="pill" data-bs-target="#usuarios" role="tab"  aria-pressed="false" aria-controls="usuarios" id="usuarios-tab">
                                    Usuarios <span class="badge text-bg-secondary">{{ $usuarios }}</span>
                                </button>
                        </div>
                    </div>
                </div>
                <!-- Container estadísticas -->
                <div class="tab-content mb-5" id="tabContent">
                    <div class="shadow-sm border rounded mm-5 tab-pane show active" id="subvenciones" style="height: 450px" role="tabpanel" aria-labelledby="pills-subvenciones-tab" tabindex="0">Subvenciones</div>
                    <div class="shadow-sm border rounded mm-5 tab-pane" id="rendiciones" style="height: 450px" role="tabpanel" aria-labelledby="pills-rendiciones-tab" tabindex="0">Rendiciones</div>
                    <div class="shadow-sm border rounded mm-5 tab-pane" id="usuarios" style="height: 450px" role="tabpanel" aria-labelledby="pills-usuarios-tab" tabindex="0">Usuarios</div>
                </div>


            </div>

            <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="contact-tab">
                @if (in_array(Session::get('perfil.perfil_id_km'), [1, 2]))
                    <div class="table-responsive mb-5">
                        <table id="table_id" class="table table-striped mx-auto">
                            <thead>
                                <tr>
                                    <th class="td-5 text-center">#</th>
                                    <th class="w-25">Accion</th>
                                    <th class="w-50">Descripción</th>
                                    <th class="w-25">Usuario</th>
                                    <th class="text-center">Fecha</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($log as $item)
                                    <tr>
                                        <td class="td-5"> {{ $item->id }} </td>
                                        <td> {{ $item->accion }} </td>
                                        <td> {{ $item->descripcion }} </td>
                                        <td> {{ $item->nombre_completo }} </td>
                                        <td class="td-10 text-center"> {{ $item->created_at }} </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>

    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>

    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

    <x-footer />
</x-app>
