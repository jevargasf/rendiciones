<?php

namespace App\Services;
use Illuminate\Support\Carbon;
use App\Models\Accion;
use App\Helpers\Mailman;
use App\Models\Notificacion;
use App\Models\Persona;
use App\Models\Rendicion;
use Illuminate\Support\Facades\Log;


class NotificacionesService{

    public function notificacionVencimiento($rendicion_id){

        $rendicion = Rendicion::findOrFail($rendicion_id);
        $rendicion->update([
            'estado_rendicion_id' => 4
        ]);
    
        
        // Todo cambio de estado conlleva un registro de acción
        $accion = Accion::create([
            'fecha' => now(),
            'estado_rendicion' => 'Rechazada',
            'comentario' => 'Rendición rechazada por estar fuera de plazo.',
            'km_nombre' => 'Sistema',
            'rendicion_id' => $rendicion->id,
            'estado' => 1
        ]);

        // array correos permite no enviar la misma notificación dos veces
        $correos_exitosos = [];
        $errores = [];
        // Enviar notificación por correo a organización
        $rendicion->subvencion = conseguirDetalleOrganizacion($rendicion->subvencion, '/resources/data/endpoint.json');
        if($rendicion->subvencion->data_organizacion['nombre_organizacion'] != 'S/D'){
            $correo_organizacion = $rendicion->subvencion->data_organizacion['correo'];
            // Crear el payload para evento de correo
            $data = [
                'email' => [
                        'plantilla_id' => '9',
                        'asunto' => 'Seguimiento de rendición',
                        'destinatario' => $correo_organizacion,
                ],
                'contenido' => [
                        'titulo' => 'Su rendición ha sido rechazada',
                        'mensaje' => 'Estimado usuario/a, su rendición ha sido rechazada debido a vencimiento del plazo.',
                ]
            ];
    
            $mailmanAPI = new Mailman($data, 'send');

            $resultado = $mailmanAPI->enviarEmail();

            if($resultado['http_code'] === 200){
                Notificacion::create([
                    'destinatario' => $correo_organizacion,
                    'email_id' => $resultado['response']['email'][0],
                    'fecha_envio' => now(),
                    'accion_id' => $accion->id,
                    'estado_notificacion' => 0,
                    'estado' => 1
                ]);
                
                $correos_exitosos[] = $correo_organizacion;
            } else if($resultado['response']['error']) {
                $errores[] = $correo_organizacion;
            }
        }

        // Conseguir correos de las acciones anteriores
        $acciones_anteriores = $rendicion->acciones;
        foreach($acciones_anteriores as $accion_anterior){
            if($accion_anterior->persona_id != null){
                $persona_anterior = Persona::where('id', $accion_anterior->persona_id)->first();
                $correo = $persona_anterior->correo;
                if(!in_array($correo, $correos_exitosos)){
                    // Crear el payload para evento de correo
                    $data = [
                        'email' => [
                                'plantilla_id' => '9',
                                'asunto' => 'Seguimiento de rendición',
                                'destinatario' => "$correo",
                        ],
                        'contenido' => [
                            'titulo' => 'Su rendición ha sido rechazada',
                            'mensaje' => 'Estimado usuario/a, su rendición ha sido rechazada debido a vencimiento del plazo.'
                        ]
                    ];
            
                    $mailmanAPI = new Mailman($data, 'send');

                    $resultado = $mailmanAPI->enviarEmail();

                    if($resultado['http_code'] === 200){
                        Notificacion::create([
                            'destinatario' => $correo,
                            'email_id' => $resultado['response']['email'][0],
                            'fecha_envio' => now(),
                            'accion_id' => $accion->id,
                            'estado_notificacion' => 0,
                            'estado' => 1
                        ]);
                        $correos_exitosos[] = $correo;
                    } else {
                        $errores[] = $correo;
                    }
                }
            } 
        } 
        if (count($errores) === 0 && count($correos_exitosos) === 0){
            return [
                'success' => false,
                'errores' => 'No hay datos para envío de correo.'
            ];
        }
        else if(count($errores) === 0){
            return [
                'success' => true,
                'exitosos' => $correos_exitosos
            ];
        }else if (count($correos_exitosos) === 0){
            return [
                'success' => false,
                'errores' => $errores
            ];
        } else {
            return [
                'success' => true,
                'exitosos' => $correos_exitosos,
                'errores' => $errores
            ];
        }
    }     

    public function notifcacionPorVencer($rendicion_id){
        $rendicion = Rendicion::findOrFail($rendicion_id);

        // Toda notificación necesita un registro de acción
        $accion = Accion::create([
            'fecha' => now(),
            'estado_rendicion' => 'Rechazada',
            'comentario' => 'Quedan 10 días para el vencimiento del plazo de rendición.',
            'km_nombre' => 'Sistema',
            'rendicion_id' => $rendicion->id,
            'estado' => 1
        ]);

        // array correos permite no enviar la misma notificación dos veces
        $correos_exitosos = [];
        $errores = [];
        // Enviar notificación por correo a organización
        $rendicion->subvencion = conseguirDetalleOrganizacion($rendicion->subvencion, '/resources/data/endpoint.json');
        if($rendicion->subvencion->data_organizacion['nombre_organizacion'] != 'S/D'){
            $correo_organizacion = $rendicion->subvencion->data_organizacion['correo'];
            // Crear el payload para evento de correo
            $data = [
                'email' => [
                        'plantilla_id' => '9',
                        'asunto' => 'Vencimiento plazo de rendición',
                        'destinatario' => $correo_organizacion,
                ],
                'contenido' => [
                        'titulo' => "Vencimiento plazo de rendición",
                        'mensaje' => 'Estimado usuario/a, quedan 10 días para el vencimiento del plazo de rendición.',
                ]
            ];
    
            $mailmanAPI = new Mailman($data, 'send');

            $resultado = $mailmanAPI->enviarEmail();

            if($resultado['http_code'] === 200){
                Notificacion::create([
                    'destinatario' => $correo_organizacion,
                    'email_id' => $resultado['response']['email'][0],
                    'fecha_envio' => now(),
                    'accion_id' => $accion->id,
                    'estado_notificacion' => 0,
                    'estado' => 1
                ]);
                
                $correos_exitosos[] = $correo_organizacion;
            } else if($resultado['response']['error']) {
                $errores[] = $correo_organizacion;
            }
        }

        // Conseguir correos de las acciones anteriores
        $acciones_anteriores = $rendicion->acciones;
        foreach($acciones_anteriores as $accion_anterior){
            if($accion_anterior->persona_id != null){
                $persona_anterior = Persona::where('id', $accion_anterior->persona_id)->first();
                $correo = $persona_anterior->correo;
                if(!in_array($correo, $correos_exitosos)){
                    // Crear el payload para evento de correo
                    $data = [
                        'email' => [
                                'plantilla_id' => '9',
                                'asunto' => 'Vencimiento plazo de rendición',
                                'destinatario' => $correo,
                        ],
                        'contenido' => [
                            'titulo' => 'Vencimiento plazo de rendición',
                            'mensaje' => 'Estimado usuario/a, quedan 10 días para el vencimiento del plazo de rendición.'
                        ]
                    ];
            
                    $mailmanAPI = new Mailman($data, 'send');

                    $resultado = $mailmanAPI->enviarEmail();

                    if($resultado['http_code'] === 200){
                        Notificacion::create([
                            'destinatario' => $correo,
                            'email_id' => $resultado['response']['email'][0],
                            'fecha_envio' => now(),
                            'accion_id' => $accion->id,
                            'estado_notificacion' => 0,
                            'estado' => 1
                        ]);
                        $correos_exitosos[] = $correo;
                    } else {
                        $errores[] = $correo;
                    }
                }
            } 
        } 
        if (count($errores) === 0 && count($correos_exitosos) === 0){
            return [
                'success' => false,
                'errores' => 'No hay datos para envío de correo.'
            ];
        }
        else if(count($errores) === 0){
            return [
                'success' => true,
                'exitosos' => $correos_exitosos
            ];
        }else if (count($correos_exitosos) === 0){
            return [
                'success' => false,
                'errores' => $errores
            ];
        } else {
            return [
                'success' => true,
                'exitosos' => $correos_exitosos,
                'errores' => $errores
            ];
        }
    }

    public function enviarCorreos(){
        
    }
}