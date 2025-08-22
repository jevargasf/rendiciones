<x-app title="Estadísticas">
    @vite(['resources/js/inicio.js'])
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

                <div class="mb-2">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="pilar" class="form-label fw-bold">Pilar</label>
                            <select name="pilar" id="pilar" class="chosen-select form-select shadow-sm">
                                <option value="" selected disabled>Seleccione...</option>
                                @foreach ($pilares as $item)
                                    <option value="{{ $item->id }}">{{ $item->titulo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label for="medida" class="form-label fw-bold">Medida</label>
                            <select name="medida" id="medida" class="chosen-select form-select shadow-sm ">
                                <option value="" selected disabled>Seleccione...</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="periodo" class="form-label fw-bold">Periodo</label>
                            <select name="periodo" id="periodo" class="chosen-select form-select shadow-sm ">
                                <option selected value="all">Todos</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="mb-5">
                    <div id="container" class="shadow-sm border rounded mm-5" style="height: 450px"></div>
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
