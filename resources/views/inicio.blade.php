<x-app title="Estadísticas">

    <x-header />

    <div class="container justify-content-center py-3 mt-5">

        <h5 class="mb-4">Estadísticas</h5>


        @if (in_array(Session::get('perfil.perfil_id_km'), [1, 2]))

        
        @endif

        <div id="myTabContent">
            <div class="tab-pane fade show active" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">


                <!-- Menú tabs estadísticas -->
                <div class="mb-2">
                    <div class="row g-3 align-items-center">

                    <!--Recuadro Subvenciones-->
                        <div class="col-md-4" role="presentation">
                            <a href="#subvenciones" class="total-card-link nav-link active d-block w-100 h-100"
                                id="subvenciones-tab" data-bs-toggle="pill" role="tab" aria-controls="subvenciones"
                                aria-selected="true">
                                <div class="total-card" style="height:10rem">
                                    <div class="total-number">{{ $data['conteos']['subvenciones'] ?? 0 }}</div>
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
                                    <div class="total-number">{{ $data['conteos']['rendiciones'] ?? 0 }}</div>
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
                                    <div class="total-number">{{ $data['conteos']['personas'] ?? 0 }}</div>
                                    <div class="total-label">Personas</div>
                                </div>
                            </a>
                        </div>



                <!-- Container estadísticas -->
                 @if ($data['select'])
                     

                <div class="mb-3 col-sm-3">
                    <label for="filtroAnio" class="form-label">Año</label>
                    <select id="filtroAnio" class="form-select">
                        @foreach ($data['select'] as $anio)
                            <option value="{{ $anio }}" @if($loop->first) selected @endif>{{ $anio }}</option>
                        @endforeach
                    </select>
                </div>
                 @endif

                @if ($data['grafico'])
                    <canvas id="grafico"></canvas>    
                @else
                    <div class="alert alert-secondary text-center fw-bold" role="alert">
                        No hay datos
                    </div>      
                @endif
                </div>


            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="{{ asset('js/estadisticas.js') }}"></script>
    <script>
        @if ($data['grafico'])
            window.data = @json($data['grafico'])           
        @endif

        // Inicializa
        document.addEventListener('DOMContentLoaded', () => {
            if (data){
                document.getElementById('filtroAnio').addEventListener('change', (e) => actualizarAnio(e));
                //document.getElementById('filtroCategoria').addEventListener('change', () => actualizarGrafico(data));
                renderizarData(data)
            }
        });

    </script>

    <x-footer />
</x-app>