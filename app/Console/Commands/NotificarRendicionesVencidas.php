<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionesService;

class CheckRendicionesVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rendiciones:notificar-vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa si se cumplió el plazo máximo de rendición. Cambia a estado "rechazada" todas las rendiciones fuera de plazo y envía una notificación por correo electrónico a la organización cuando faltan 10 días para su vencimiento.';
    // El plazo de vencimiento está seteado a 30 días después de la fecha de asignación
    protected $plazo_vencidas = 30;
    // El plazo por vencer está seteado a 10 días antes de la fecha de vencimiento final
    protected $plazo_por_vencer = 20;
    /**
     * Execute the console command.
     */


    public function handle()
    {
        try{
            $correoService = app(NotificacionesService::class); 
            Log::info("Iniciando revisión de plazo de rendiciones.");
            $rendiciones_vencidas = DB::table('rendiciones')
            ->join('subvenciones', 'rendiciones.subvencion_id', '=', 'subvenciones.id')
            ->where('rendiciones.estado', 1)
            ->where('subvenciones.estado', 1)
            ->whereIn('rendiciones.estado_rendicion_id', [2, 3])
            ->whereRaw("DATE_ADD(subvenciones.fecha_asignacion, INTERVAL {$this->plazo_vencidas} DAY) <= NOW()")
            ->select('rendiciones.id', 'rendiciones.estado_rendicion_id', 'subvenciones.fecha_asignacion')
            ->get();
            
            $contador = 0;
            if ($rendiciones_vencidas->isEmpty()){
                Log::info("No hay rendiciones vencidas");
            } else {
                // Cambiar estado de rendiciones que ya vencieron y enviar notificaciones
                foreach($rendiciones_vencidas as $rendicion){
                    $resultado = $correoService->notificacionVencimiento($rendicion->id);
                    if (isset($resultado['success']) && $resultado['success'] === true){
                        $contador++;
                        if (isset($resultado['errores']) && is_array($resultado['errores'])){
                            Log::info("Rendición actualizada exitosamente a estado rechazada: Id rendición: {$rendicion->id} | Correos enviados: ". implode(', ', $resultado['exitosos']) . 'Ocurrió un error al notificar al(los) siguiente(s) correos:' . implode(', ', $resultado['errores']) . '.');
                        } else if (isset($resultado['errores']) && !is_array($resultado['errores'])) {
                            Log::info("Rendición actualizada exitosamente a estado rechazada: Id rendición: {$rendicion->id} | Error: No se enviaron notificaciones. " . implode(', ', $resultado['errores']));
                        } else {
                            Log::info("Rendición actualizada exitosamente a estado rechazada: Id rendición: {$rendicion->id} | Correos enviados:" . implode(', ', $resultado['exitosos']) . '.');
                        }
                    } else {
                        Log::info("Rendición actualizada exitosamente a estado rechazada: Id rendición: {$rendicion->id} | Ocurrió un error al notificar al(los) siguiente(s) correos:" . $resultado['errores'] . '.');

                    }
                }
            }
            Log::info("Tarea finalizada: Número de organizaciones notificadas: $contador");
        } catch(Exception $e) {
            Log::error("Error: {$e}");
        }
        
 
    }
}
