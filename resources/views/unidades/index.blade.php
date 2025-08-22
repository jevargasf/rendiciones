<x-app title="Unidades">
    @vite(['resources/css/app.css', 'resources/js/unidades.js' ])

    <x-header />

    <div class="container justify-content-center py-3 mt-3">
        <div class="shadow-sm p-3 mb-5 bg-body rounded">

            <h5 class="mb-5">Unidades
                <a class="btn mb-1 font-weight-bold btn-app float-end" id="btnModal"><i class="fa-solid fa-plus"></i> Registrar Unidad</a>
            </h5>

            <div class="table-responsive">
                <table id="table_id" class="table table-striped mx-auto">
                    <thead>
                        <tr>
                            <th class="td-5 text-center">#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="td-5 text-center"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($unidades as $item)
                            <tr>
                                <td class="td-5"> {{ $item->id }} </td>
                                <td> {{ $item->nombre }} </td>
                                <td> {{ $item->descripcion }} </td>
                                <td class="td-5">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button class="btn-accion me-1">
                                            <i class="fas fa-pen-square" data-id="{{ $item->id }}"
                                                data-descripcion="{{ $item->descripcion }}"
                                                data-nombre="{{ $item->nombre }}">
                                            </i>
                                        </button>

                                        <form method="post" action="{{ route('unidades.eliminar', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-accion btn-link  align-baseline">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="modal-header modal-header-app">
                    <h5 class="modal-title fw-bold" id="modalFormTitulo">Crear unidad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="form">
                    @csrf
                    @method('POST')
                    <div class="modal-body p-4">
                        <div class="container">
                            <div class="p-4  rounded">
                                <input type="hidden" id="unidad_id">

                                <div class="mb-3">
                                    <label for="nombre" class="form-label required fw-bold">Nombre</label>
                                    <input type="text" class="form-control shadow-sm" id="nombre" name="nombre"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label required fw-bold">Descripción</label>
                                    <input type="text" class="form-control shadow-sm" id="descripcion"
                                        name="descripcion" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between p-3 border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill"
                            data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left me-2"></i>Cerrar</button>
                        <button type="submit" class="btn btn-app px-4 py-2 rounded-pill shadow-sm"
                            id="btnForm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

   
    </script>

    <x-footer />

</x-app>
