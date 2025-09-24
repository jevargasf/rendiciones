<?php

namespace App\Http\Controllers;

use App\Models\Rendicion;
use App\Models\Accion;
use App\Models\EstadoRendicion;
use Illuminate\Http\Request;
use App\Models\Subvencion;
use App\Models\Notificacion;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Persona;
use App\Http\Controllers\SubvencionController;
use App\Http\Resources\RendicionResource;
use Illuminate\Support\Facades\File as FileReader;

use function PHPSTORM_META\type;

class RendicionController extends BaseController
{

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


    
    public function conseguirDetalleOrganizacion($subvencion_objeto, $endpoint){
        $data_organizacion = FileReader::get(base_path($endpoint));
        // Adjunta data organización al objeto, rellena con S/D en caso de que no encuentre datos
            $json_organizacion = json_decode($data_organizacion, associative: true);
            $rut_json = $json_organizacion[0]['rut'];
            if ($rut_json == $subvencion_objeto['rut']){
                $subvencion_objeto->data_organizacion = $json_organizacion[0];
            } else {
                $subvencion_objeto->data_organizacion = ['nombre_organizacion' => 'S/D'];
            }
        return $subvencion_objeto;
    }

    public function index()
    {
        // En revisión (estado_rendicion_id = 2)
        $revision = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 2) // En revisión
            ->get();
        
        if(!$revision->isEmpty()){
            foreach($revision as $rendicion){
                $rendicion = $this->conseguirDetalleOrganizacion($rendicion, '/resources/data/endpoint.json');
            }
        }
        
        // Observadas (estado_rendicion_id = 3)
        $observadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 3) // Observadas
            ->get();

        if(!$observadas->isEmpty()){
            foreach($observadas as $rendicion){
                $rendicion = $this->conseguirDetalleOrganizacion($rendicion, '/resources/data/endpoint.json');
            }
        }
        // Rechazadas (estado_rendicion_id = 4)
        $rechazadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 4) // Rechazadas
            ->get();

        if(!$rechazadas->isEmpty()){
            foreach($rechazadas as $rendicion){
                $rendicion = $this->conseguirDetalleOrganizacion($rendicion, '/resources/data/endpoint.json');
            }
        }
        // Aprobadas (estado_rendicion_id = 5)
        $aprobadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 5) // Aprobadas
            ->get();
        
        if(!$aprobadas->isEmpty()){
            foreach($aprobadas as $rendicion){
                $rendicion = $this->conseguirDetalleOrganizacion($rendicion, '/resources/data/endpoint.json');
            }
        }
        
        return view(
            'rendiciones.index',
            compact('revision', 'observadas', 'rechazadas', 'aprobadas')
        );
    }

        /**
     * Guardar rendición de subvención
     */
    public function crear(Request $request)
    {
        try {
            // HACERLO COMO TRANSACCIÓN POR SI ALGO FALLA
            // Validar data
            $data_validada = $request->validate([
                'id' => 'required|integer|exists:rendiciones,id',
                'rut' => 'required|regex:/^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]$/',
                'nombre' => 'required|string|max:50',
                'apellido' => 'required|string|max:50',
                'correo' => 'required|email|max:100',
                'cargo' => 'required|integer|exists:cargos,id',
                'comentario' => 'required|string|max:400'
            ]);

            // Limpiar RUT
            $data_validada['rut'] = $this->normalizarRut($data_validada['rut']);
            
            // Buscar si ya existe una persona con el mismo RUT
            $persona = Persona::where('rut', $data_validada['rut'])->first();

            if ($persona) {
                // Actualizar persona existente
                $persona->update([
                    'nombre' => $data_validada['nombre'],
                    'apellido' => $data_validada['apellido'],
                    'correo' => $data_validada['correo'],
                    'estado' => 1
                ]);
            } else {
                // Crear nueva persona
                $persona = Persona::create([
                    'rut' => $data_validada['rut'],
                    'nombre' => $data_validada['nombre'],
                    'apellido' => $data_validada['apellido'],
                    'correo' => $data_validada['correo'],
                    'estado' => 1
                ]);
            }
            
            // Buscar rendición solo estado 1 = Creada
            $rendicion = Rendicion::where([['id', '=', $data_validada['id']], ['estado', '=', 1], ['estado_rendicion_id', '=', 1]])->first();
            
            // Cambiar el estado de la rendición a 2 (en revisión)
            $rendicion->update([
                'estado_rendicion_id' => 2
            ]);

            // Obtener datos del usuario autenticado desde la sesión
            $usuarioAutenticado = session('usuario');
            $nombreCompletoUsuario = trim(($usuarioAutenticado['nombres'] ?? '') . ' ' . 
                                   ($usuarioAutenticado['apellido_paterno'] ?? '') . ' ' . 
                                   ($usuarioAutenticado['apellido_materno'] ?? ''));
            
            // Crear acción de rendición usando datos del usuario autenticado
            Accion::create([
                'fecha' => now(),
                'estado_rendicion' => 'En revisión',
                'comentario' => $request->comentario,
                'km_rut' => $usuarioAutenticado['run'] ?? 'S/D',
                'km_nombre' => $nombreCompletoUsuario ?? 'S/D',
                'rendicion_id' => $rendicion->id,
                'persona_id' => $persona->id,
                'cargo_id' => $data_validada['cargo'],
                'estado' => 1
            ]);

            $subvenciones = Subvencion::where('estado', 1)
            ->whereHas('rendiciones', function ($query) {
                $query->where('estado_rendicion_id', 1);
            })
            ->get();

            if($subvenciones->isEmpty()){
                return response()->json([
                    'success' => true,
                    'subvenciones' => $subvenciones
                    
                ]);  
            }else{
                // Realiza consulta al json de datos para cada subvención
                foreach($subvenciones as $subvencion){
                    $subvencion = $this->conseguirDetalleOrganizacion($subvencion, '/resources/data/endpoint.json');

                }
                return response()->json([
                    'success' => true,
                    'subvenciones' => $subvenciones
                ]); 
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la rendición: ' . $e->getMessage()
            ]);
        }
    }
   
    public function obtener(Request $request) /** detalleRendicion es el mismo nombre de la ruta, Así Laravel sabe qué método ejecutar cuando llega una petición a esa ruta*/
    {
        try{
            $request->validate([
                'id' => 'required|integer|exists:rendiciones,id'
            ]);

            // Obtener acciones
            $rendicion = Rendicion::with([
                'subvencion' => function ($query){
                    $query->where('estado', 1);
                },
                'acciones' => function ($query){
                    $query->where('estado', 1);
                },
                'acciones.persona' => function ($query){
                    $query->where('estado', 1);
                },
                'acciones.cargo' => function ($query){
                    $query->where('estado', 1);
                },
                'estadoRendicion' => function ($query){
                    $query->where('estado', 1);
                },
                'acciones.notificacion' => function ($query){
                    $query->where('estado', 1);
                }
            ])
            ->where([
                ['rendiciones.estado', '=', 1],
                ['rendiciones.id', '=', $request->id]
            ])
            ->get();

            $resource = new RendicionResource($rendicion[0]);
            
            $rendicion[0]->setAttribute('subvencion', $this->conseguirDetalleOrganizacion($rendicion[0]->subvencion, '/resources/data/endpoint.json'));
            
            $estados_rendicion = EstadoRendicion::whereBetween('id', [3, 5])->get();
            return response()->json([
                'success' => true,
                'rendicion' => $resource,
                'estados_rendicion' => $estados_rendicion
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la rendición: ' . $e->getMessage()
            ]);
        }
    }
    

    public function cambiarEstado(Request $request){
        try{
            // agregar validación 3, 4, 5 aquí
            $data_validada = $request->validate([
                'id' => 'required|integer|exists:rendiciones,id',
                'nuevo_estado_id' => 'required|integer|exists:estados_rendiciones,id',
                'comentario' => 'required|string|max:400'
            ]);
            // buscar rendición por id
            $rendicion = Rendicion::with(['estadoRendicion', 'acciones'])->where('id', $data_validada['id'])->first();

            // capturar estado actual
            $estado_actual_nombre = $rendicion->estadoRendicion->nombre;
            $estado_nuevo_nombre = EstadoRendicion::where('id', $data_validada['nuevo_estado_id'])->first()->nombre;
            // actualizar el estado de la rendición
            $rendicion->update([
                'estado_rendicion_id' => $data_validada['nuevo_estado_id']
            ]);
            
                // Crear acción automática de subvención creada 
                $km_data = session('usuario');   
    
                if ($km_data) {
                    $nombre_completo = trim($km_data['nombres'] ?? '') . ' ' . 
                                            ($km_data['apellido_paterno'] ?? '') . ' ' . 
                                            ($km_data['apellido_materno'] ?? '');
                
                // registrar la acción
                $accion = Accion::create([
                    'fecha' => now(),
                    'estado_rendicion' => $estado_nuevo_nombre,
                    'comentario' => $data_validada['comentario'],
                    'km_rut' => $km_data['run'],
                    'km_nombre' => $nombre_completo,
                    'rendicion_id' => $rendicion->id,
                    'estado' => 1
                ]);

                // array correos es una memoria temporal para no
                // enviar la misma notificación dos veces

                $correos = [];
                // registrar la notificación 
                $acciones = $rendicion->acciones;
                foreach($acciones as $accion){
                    if($accion->persona_id){
                        $persona = Persona::findOrFail($accion->persona_id);
                        $correo = $persona->correo;
                        if(!in_array($correo, $correos)){
                            $correos[] = $correo;
                        }
                        Notificacion::create([
                            'destinatario' => $correo,
                            'fecha_envio' => now(),
                            'accion_id' => $accion->id,
                            'estado_notificacion' => 0,
                            'estado' => 1
                        ]);
                        // El payload de la notificación sale del modelo
                        // notificación + la referencia a la acción que lo generó
                    }
                }




                // retornar la respuesta
                return response()->json([
                            'success' => true,
                            'message' => "Rendición actualizada exitosamente de estado: {$estado_actual_nombre} a estado: {$estado_nuevo_nombre}"
                        ]); 
                    }else{
                        return response()->json([
                            'success' => false,
                            'message' => 'Debe iniciar sesión para realizar esta acción'
                        ]); 
                }
                
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado de la rendición: ' . $e->getMessage()
            ]);
        }
    }

    public function actualizar(Request $request){
        try{
            $request->validate([
                'id' => 'required|integer|exists:subvenciones,id',
                'destino' => 'required|string|max:1000',
                'rut' => 'required|regex:/^[0-9]{1,2}[0-9]{6}-[0-9kK]$/',
                'fecha_decreto' => 'required|date',
                'fecha_asignacion' => 'required|date',
                'decreto' => 'required|string|max:255',
                'monto' => 'required|integer'
            ]);

            $rendicion = Rendicion::findOrFail($request->id);

            // Normalizar RUT si es necesario
            $rutNormalizado = $this->normalizarRut($request->rut);
            if (!$rutNormalizado) {
                return response()->json([
                    'success' => false,
                    'message' => 'RUT inválido'
                ]);
            }

            // Actualizar los datos subvención
            $rendicion->subvencion->update([
                'destino' => $request->destino,
                'rut' => $rutNormalizado,
                'decreto' => $request->decreto,
                'fecha_decreto' => $request->fecha_decreto,
                'fecha_asignacion' => $request->fecha_asignacion,
                'monto' => $request->monto
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rendición actualizada correctamente',
                'data' => $rendicion
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la subvención: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:rendiciones,id'
            ]);

            $rendicion = Rendicion::with('subvencion')->findOrFail($request->id);
            
            // Verificar que la rendición esté en revisión (estado_rendicion_id = 2)
            if ($rendicion->estado_rendicion_id != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar las rendiciones en revisión.'
                ]);
            }

            // Actualizar estado_rendicion_id a 1 (Recepcionada)
            $rendicion->update(['estado_rendicion_id' => 1]);
            $usuarioAutenticado = session('usuario');
            $nombreCompletoUsuario = trim(($usuarioAutenticado['nombres'] ?? '') . ' ' . 
                                   ($usuarioAutenticado['apellido_paterno'] ?? '') . ' ' . 
                                   ($usuarioAutenticado['apellido_materno'] ?? ''));
            
            // Registrar la acción
            Accion::create([
                'rendicion_id' => $rendicion->id,
                'estado_rendicion' => 'En revisión', 
                'comentario' => 'Inicio de rendición anulado.',
                'fecha' => now(),
                'estado' => 1,
                'km_rut' => $usuarioAutenticado['run'], // RUT del usuario de la sesión
                'km_nombre' => $nombreCompletoUsuario // Nombre completo del usuario
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rendición eliminada correctamente. La subvención ha vuelto a su estado inicial.'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado de la rendición: ' . $e->getMessage()
            ]);
        }
    }

    
}


