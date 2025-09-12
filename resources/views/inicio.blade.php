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
                    <!--<div class="shadow-sm border rounded text-center mb-5">
                        <h5 class="highcharts-title fw-bold mb-2">Porcentaje de Cumplimiento por Pilar</h5>
                        <div id="pie-container" class="d-flex  justify-content-center mm-5"></div>
                    </div>-->
                @endif

                <!-- Menú tabs estadísticas -->
                <div class="mb-2">
                    <div class="row g-3 align-items-center" role="tablist">

                    <!--Recuadro Subvenciones-->
                        <div class="col-md-4" role="presentation">
                            <a href="#subvenciones" class="total-card-link nav-link active d-block w-100 h-100"
                                id="subvenciones-tab" data-bs-toggle="pill" role="tab" aria-controls="subvenciones"
                                aria-selected="true">
                                <div class="total-card" style="height:10rem">
                                    <div class="total-number">{{ $subvenciones }}</div>
                                    <div class="total-label">Subvenciones</div>
                                </div>
                            </a>
                        </div>

                    <!--Recuadro Rendiciones -->
                        <div class="col-md-4" role="presentation">
                            <a href="#rendiciones" class="total-card-link nav-link active d-block w-100 h-100"
                                id="rendiciones-tab" data-bs-toggle="pill" role="tab" aria-controls="rendiciones"
                                aria-selected="true">
                                <div class="total-card" style="height:10rem">
                                    <div class="total-number">{{$rendiciones}}</div>
                                    <div class="total-label">Rendiciones</div>
                                </div>
                            </a>                
                        </div>

                <!--Recuadro Personas -->
                        <div class="col-md-4" role="presentation">
                            <a href="#personas" class="total-card-link nav-link active d-block w-100 h-100"
                                id="personas-tab" data-bs-toggle="pill" role="tab" aria-controls="personas"
                                aria-selected="true">
                                <div class="total-card" style="height:10rem">
                                    <div class="total-number">{{$personas}}</div>
                                    <div class="total-label">Personas</div>
                                </div>
                            </a>
                        </div>



                <!-- Container estadísticas -->
                <div class="tab-content mb-5" id="tabContent">
                    <div class="shadow-sm border rounded mm-5 tab-pane show active" id="subvenciones"
                        style="height: 450px" role="tabpanel" aria-labelledby="pills-subvenciones-tab" tabindex="0">
                        Subvenciones</div>
                    <div class="shadow-sm border rounded mm-5 tab-pane" id="rendiciones" style="height: 450px"
                        role="tabpanel" aria-labelledby="pills-rendiciones-tab" tabindex="0">Rendiciones</div>
                    <div class="shadow-sm border rounded mm-5 tab-pane" id="personas" style="height: 450px"
                        role="tabpanel" aria-labelledby="pills-personas-tab" tabindex="0">Personas</div>
                </div>


            </div>

            <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="contact-tab">
                @if (in_array(Session::get('perfil.perfil_id_km'), [1, 2]))
                    <div class="alert alert-info text-center">
                        <h5>Historial de Acciones</h5>
                        <p class="mb-0">Esta funcionalidad estará disponible próximamente.</p>
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