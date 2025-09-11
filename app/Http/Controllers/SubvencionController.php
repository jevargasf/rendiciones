<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subvencion;
use App\Models\Rendicion;
use App\Models\Notificacion;
use App\Models\Cargo;
use App\Models\Persona;
use App\Models\EstadoRendicion;
use App\Models\Accion;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Routing\Controller as BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File as FileReader;

class SubvencionController extends BaseController
{


    public function conseguirDetalleOrganizacion($data, $endpoint){
        foreach($data as $subvencion){
            $data_organizacion = FileReader::get(base_path($endpoint));
            $json_organizacion = json_decode($data_organizacion, associative: true);
            $rut_json = $json_organizacion[0]['rut'];
            $nombre_json = $json_organizacion[0]['nombre_organizacion'];
            if ($rut_json == $subvencion['rut']){
                $subvencion->nombre_organizacion = $nombre_json;
            } else {
                $subvencion->nombre_organizacion = 'S/D';
            }
        }
        return [$data, $data_organizacion];
    }

    public function index()
    {
        //dd(Session::all());
        $subvenciones = Subvencion::where('estado', 1) // Excluir subvenciones eliminadas (estado = 9)
            ->get();
        // nombre organización lo pedimos desde la API usando el rut para evitar errores (a medida que lo necesitemos)
        
        $subvenciones = $this->conseguirDetalleOrganizacion($subvenciones, '/resources/data/endpoint.json')[0];
        return view(
            'subvenciones.index',
            compact('subvenciones')

        );  
    }

    public function crear(Request $request)
    {
        try {
            // Validar formulario
            $request->validate([
                'fecha_decreto' => 'required|date',
                'numero_decreto' => 'required|string|max:255',
                'seleccionar_archivo' => 'required|file|mimes:xls,xlsx|max:10240' // 10MB máximo
            ]);

            // Validar que el archivo sea Excel
            $file = $request->file('seleccionar_archivo');
            $extension = $file->getClientOriginalExtension();
            
            // Alerta si la extensión del archivo no es válida
            if (!in_array($extension, ['xls', 'xlsx'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se permiten archivos Excel (.xls o .xlsx)'
                ]);
            }

            // Almacenar el archivo temporalmente
            $filePath = $file->getRealPath();
            
            // Crear el lector apropiado según la extensión
            if ($extension === 'xlsx') {
                $reader = new Xlsx();
            } else {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            }
            
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);

            // Obtener la hoja activa del excel
            $worksheet = $spreadsheet->getActiveSheet();
            // Obtener número de fila y columna que tienen realmente datos
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestDataColumn();

            // Validación: el archivo tiene solo 1 fila con datos
            if ($highestRow < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no contiene datos válidos'
                ]);
            }

            // Falta: validación de número de columnas esperado

            // Obtener encabezados para validar formato
            $headers = $worksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            //$headersCleaned = array_map('trim', $headers);
            $expectedHeaders = ['Rut Organización', 'Monto', 'Destino', 'Fecha'];
            
            // REVISAR: Validar que los encabezados sean correctos. Solo valida el número, no valida que tengan el mismo nombre
            $headerRow = array_values($headers[1]);
            if (count($headerRow) < 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no tiene el formato esperado. Las columnas deben ser: RUT Organización, Monto, Destino, Fecha'
                ]);
            }

            $subvencionesCreadas = 0;
            $errores = [];

            // Procesar cada fila de datos
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    $fecha = Date::excelToDateTimeObject($worksheet->getCell('D' . $row)
                    ->getValue())->format('d-m-Y');
                    
                    
                    $validar_fila = Validator::make([
                            'rut' => $worksheet->getCell('A' . $row)->getValue(),
                            'monto' => $worksheet->getCell('B' . $row)->getValue(),
                            'destino' => $worksheet->getCell('C' . $row)->getValue(),
                            'fecha' => $fecha
                        ]
                        ,[
                            'rut' => 'required|regex:/^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]$/',
                            'monto' => 'required|integer',
                            'destino' => 'required|string|max:200',
                            'fecha' => 'required|date_format:d-m-Y'
                        ]);

                    if ($validar_fila->fails()){
                        // Error genérico
                        $errores[] = "Fila $row contiene errores: " . $validar_fila->errors();
                        continue;
                    }

                    $fila_validada = $validar_fila->validated();
                    // Crear registro de subvención
                    // Falta consumir json rut organización para validar rut
                    $subvencion = Subvencion::create([
                        'decreto' => $request->numero_decreto,
                        'fecha_decreto' => $request->fecha_decreto,
                        'monto' => $fila_validada['monto'],
                        'fecha_asignacion' => $fila_validada['fecha'],
                        'destino' => $fila_validada['destino'],
                        'rut' => $this->normalizarRut($fila_validada['rut']),
                        'estado' => 1,
                        'motivo_eliminacion' => null
                    ]);

                    // Crear automáticamente la rendición asociada con estado_rendicion_id = 1
                    $rendicion = Rendicion::create([
                        'subvencion_id' => $subvencion->id,
                        'estado_rendicion_id' => 1, // Estado inicial
                        'estado' => 1
                    ]);

                    // Crear acción automática de subvención creada 
                    $km_data = session('usuario');                   
                    if ($km_data) {
                        $nombre_completo = trim($km_data['nombres'] ?? '') . ' ' . 
                                               ($km_data['apellido_paterno'] ?? '') . ' ' . 
                                               ($km_data['apellido_materno'] ?? '');
                    
                        Accion::create([
                            'fecha' => now(),
                            'comentario' => 'Subvención registrada en el sistema.',
                            'km_rut' => $km_data['run'] ?? '',
                            'km_nombre' => $nombre_completo,
                            'rendicion_id' => $rendicion->id,
                            'estado' => 1
                        ]);
                    }

                    $subvencionesCreadas++;

                } catch (Exception $e) {
                    $errores[] = "Fila $row: Error al procesar - " . $e->getMessage();
                }
            }

            // Preparar respuesta
            $mensaje = "Se procesaron $subvencionesCreadas subvenciones correctamente";
            if (!empty($errores)) {
                $mensaje .= ". Errores encontrados: " . implode('; ', array_slice($errores, 0, 5));
                if (count($errores) > 5) {
                    $mensaje .= " y " . (count($errores) - 5) . " errores más";
                }
            }

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'subvenciones_creadas' => $subvencionesCreadas,
                'errores' => $errores
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Normalizar RUT chileno a formato estándar (12345678-9)
     * Acepta cualquier formato de entrada y lo convierte al formato estándar
     */
    private function normalizarRut($rut)
    {
        // Limpiar el RUT, mantener solo números y K
        $rutLimpio = preg_replace('/[^0-9kK]/', '', $rut);
        
        // Validar longitud mínima y máxima
        if (strlen($rutLimpio) < 7 || strlen($rutLimpio) > 9) {
            return false;
        }

        $dv = strtoupper(substr($rutLimpio, -1));
        $numero = substr($rutLimpio, 0, -1);

        // Validar que el dígito verificador sea válido (0-9 o K)
        if (!in_array($dv, ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'K'])) {
            return false;
        }

        // Validar que el número solo contenga dígitos
        if (!ctype_digit($numero)) {
            return false;
        }

        // Calcular dígito verificador para validar
        $suma = 0;
        $multiplicador = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $numero[$i] * $multiplicador;
            $multiplicador = $multiplicador == 7 ? 2 : $multiplicador + 1;
        }

        $resto = $suma % 11;
        $dvCalculado = 11 - $resto;

        if ($dvCalculado == 11) {
            $dvCalculado = '0';
        } elseif ($dvCalculado == 10) {
            $dvCalculado = 'K';
        } else {
            $dvCalculado = (string) $dvCalculado;
        }

        // Si el dígito verificador es correcto, retornar en formato estándar
        if ($dv === $dvCalculado) {
            return $numero . '-' . $dv;
        }

        return false;
    }

    /**
     * Convertir fecha desde diferentes formatos
     */
    private function convertirFecha($fecha)
    {
        try {
            // Si es un objeto DateTime de PhpSpreadsheet
            if ($fecha instanceof \DateTime) {
                return $fecha->format('Y-m-d');
            }

            // Si es un número (fecha serial de Excel)
            if (is_numeric($fecha)) {
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($fecha);
                return date('Y-m-d', $timestamp);
            }

            // Si es string, intentar parsear diferentes formatos
            $formatos = [
                'd-m-Y',
                'd/m/Y',
                'Y-m-d',
                'Y/m/d',
                'd-m-y',
                'd/m/y'
            ];

            foreach ($formatos as $formato) {
                $fechaObj = \DateTime::createFromFormat($formato, $fecha);
                if ($fechaObj !== false) {
                    return $fechaObj->format('Y-m-d');
                }
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Obtener datos de una subvención específica para edición
     */
    public function obtener(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:subvenciones,id'
            ]);
            // Detalle subvención
            $subvencion = Subvencion::with([
                'rendiciones.acciones' => function ($query) {
                        $query->where('estado', 1);
                    }],[
                'rendiciones.estados_rendiciones' => function ($query) {
                        $query->where('estado', 1);
                    }
                ])
            ->where([
                ['subvenciones.estado', '=', 1], 
                ['subvenciones.id', '=', $request->id]
                ])
            ->get();       

            foreach($subvencion[0]->rendiciones[0]->acciones as $accion){
                $fecha_accion = \Carbon\Carbon::parse($accion->fecha)->format('d/m/Y');
                $accion->fecha = $accion->fecha->format('d/m/Y');
            }

            // Agregar data organización
            $subvencion = $this->conseguirDetalleOrganizacion($subvencion, '/resources/data/endpoint.json')[0];

            // Subvenciones anteriores asociadas al mismo rut
            $consulta_anteriores = Subvencion::where([
                ['rut', '=', $subvencion[0]->rut],
                ['estado', '=', 1]
            ])
            ->whereNot('id', $subvencion[0]->id)
            ->get();

            $anteriores = [];

            if($consulta_anteriores->isEmpty()){
                $anteriores = [
                    'message'=>'No hay subvenciones anteriores asociadas.'
                ];
            }else{
                foreach($consulta_anteriores as $anterior){
                    $fecha_anterior_formateada = \Carbon\Carbon::parse($anterior->fecha)->format('d/m/Y');

                    array_push($anteriores, [
                        'id'=>$anterior->id,
                        'decreto'=>$anterior->decreto,
                        'monto'=>$anterior->monto,
                        'fecha'=>$fecha_anterior_formateada,
                        'destino'=>$anterior->destino
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $subvencion[0]->id,
                    'decreto' => $subvencion[0]->decreto,
                    'fecha_decreto' => $subvencion[0]->fecha_decreto->format('d/m/Y'),
                    'monto' => $subvencion[0]->monto,
                    'destino' => $subvencion[0]->destino,
                    'rut' => $subvencion[0]->rut,
                    'organizacion' => $subvencion[0]->nombre_organizacion,
                    'fecha_asignacion' => $subvencion[0]->fecha_asignacion->format('d/m/Y'),
                    'acciones'=>$subvencion[0]->rendiciones[0]->acciones->toArray(),
                    'anteriores'=>$anteriores,
                    'detalle_organizacion'=>json_decode($this->conseguirDetalleOrganizacion($subvencion, '/resources/data/endpoint.json')[1], true)[0]
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la subvención: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Actualizar una subvención existente
     */
    public function actualizar(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:subvenciones,id',
                'destino' => 'required|string|max:1000',
                'rut' => 'required|regex:/^[0-9]{1,2}[0-9]{6}-[0-9kK]$/',
                'fecha_decreto' => 'required|date',
                'numero_decreto' => 'required|string|max:255',
                'monto'
            ]);

            $subvencion = Subvencion::findOrFail($request->id);
            
            // Normalizar RUT si es necesario
            $rutNormalizado = $this->normalizarRut($request->rut);
            if (!$rutNormalizado) {
                return response()->json([
                    'success' => false,
                    'message' => 'RUT inválido'
                ]);
            }

            // Actualizar la subvención (sin modificar decreto ni monto)
            $subvencion->update([
                'destino' => $request->destino,
                'rut' => $rutNormalizado
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subvención actualizada correctamente',
                'data' => $subvencion
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la subvención: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Eliminar una subvención (soft delete cambiando estado a 9)
     * Elimina todas las subvenciones con el mismo decreto
     */
    public function eliminar(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:subvenciones,id',
                'motivo' => 'required|string|min:10|max:500'
            ]);

            $subvencion = Subvencion::findOrFail($request->id);
            $decreto = $subvencion->decreto;
            
            // Obtener todas las subvenciones con el mismo decreto
            $subvencionesConMismoDecreto = Subvencion::where('decreto', $decreto)
                ->where('estado', '!=', 9) // No incluir las ya eliminadas
                ->get();

            $subvencionesEliminadas = 0;
            $rendicionesEliminadas = 0;

            // Eliminar todas las subvenciones con el mismo decreto
            foreach ($subvencionesConMismoDecreto as $subvencionAEliminar) {
                // Cambiar estado de la subvención a 9 (eliminada)
                $subvencionAEliminar->update([
                    'estado' => 9,
                    'motivo_eliminacion' => $request->motivo
                ]);

                // Cambiar estado de todas las rendiciones asociadas a 9 (eliminadas)
                $rendicionesCount = $subvencionAEliminar->rendiciones()->update([
                    'estado' => 9,
                    'motivo_eliminacion' => $request->motivo
                ]);
                
                $subvencionesEliminadas++;
                $rendicionesEliminadas += $rendicionesCount;
            }

            $mensaje = "Se eliminaron {$subvencionesEliminadas} subvención(es) con el decreto '{$decreto}' y {$rendicionesEliminadas} rendición(es) asociada(s).";

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => [
                    'subvenciones_eliminadas' => $subvencionesEliminadas,
                    'rendiciones_eliminadas' => $rendicionesEliminadas,
                    'decreto' => $decreto
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la subvención: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Obtener datos para el modal de rendir subvención
     */
    public function obtenerDatosRendir(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:subvenciones,id'
            ]);

            $subvencion = Subvencion::findOrFail($request->id);
            $cargos = Cargo::where('estado', 1)->get();
            $personas = Persona::where('estado', 1)->get();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'subvencion' => [
                        'id' => $subvencion->id,
                        'decreto' => $subvencion->decreto,
                        'monto' => $subvencion->monto,
                        'destino' => $subvencion->destino,
                        'rut' => $subvencion->rut,
                        'organizacion' => $subvencion->nombre_organizacion,
                        'fecha_asignacion' => $subvencion->fecha_asignacion
                    ],
                    'cargos' => $cargos,
                    'personas' => $personas
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Guardar rendición de subvención
     */
    public function guardarRendicion(Request $request)
    {
        try {
            $request->validate([
                'subvencion_id' => 'required|integer|exists:subvenciones,id',
                'persona_id' => 'required|integer|exists:personas,id',
                'persona_cargo_id' => 'required|integer|exists:cargos,id',
                'comentario' => 'required|string|max:1000'
            ]);

            // Buscar la persona
            $persona = Persona::findOrFail($request->persona_id);

            // Buscar la rendición existente o crear una nueva
            $subvencion = Subvencion::findOrFail($request->subvencion_id);
            $rendicion = $subvencion->rendiciones()->where('estado', 1)->first();
            
            if (!$rendicion) {
                $rendicion = Rendicion::create([
                    'subvencion_id' => $request->subvencion_id,
                    'estado_rendicion_id' => 2, // Estado "En Revisión" (ID 2)
                    'estado' => 1
                ]);
            } else {
                // Actualizar estado de rendición existente a "En Revisión"
                $rendicion->update([
                    'estado_rendicion_id' => 2 // Estado "En Revisión" (ID 2)
                ]);
            }
            
            // Cambiar el estado de la subvención a 2 (rendida)
            $subvencion->update([
                'estado' => 2
            ]);

            // Obtener datos del usuario autenticado desde la sesión
            $usuarioAutenticado = session('usuario');
            $nombreCompletoUsuario = trim(($usuarioAutenticado['nombres'] ?? '') . ' ' . 
                                   ($usuarioAutenticado['apellido_paterno'] ?? '') . ' ' . 
                                   ($usuarioAutenticado['apellido_materno'] ?? ''));
            
            // Crear acción de rendición usando datos del usuario autenticado
            $accion = Accion::create([
                'fecha' => now(),
                'comentario' => $request->comentario,
                'km_rut' => $usuarioAutenticado['run'] ?? '',
                'km_nombre' => $nombreCompletoUsuario,
                'rendicion_id' => $rendicion->id,
                'persona_id' => $persona->id,
                'cargo_id' => $request->persona_cargo_id,
                'estado' => 1
            ]);
            
            // Crear notificación para la acción de rendición
            // Notificacion::create([
            //     'fecha_envio' => now(),
            //     'fecha_lectura' => null,
            //     'estado_notificacion' => false, // No leída
            //     'accion_id' => $accion->id,
            //     'estado' => 1
            // ]);

            // No se actualiza el destino de la subvención ya que es información original

            return response()->json([
                'success' => true,
                'message' => 'Rendición guardada correctamente'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la rendición: ' . $e->getMessage()
            ]);
        }
    }
}
