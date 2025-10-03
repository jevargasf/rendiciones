<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionesService; 
use Exception;

class NotificarRendicionesPorVencer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rendiciones:notificar-por-vencer';
    // El plazo por vencer está seteado a 10 días antes de la fecha de vencimiento final
    protected $plazo_por_vencer = 20;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $correoService = app(NotificacionesService::class); 
            Log::info("Iniciando revisión de plazo de rendiciones.");
            $rendiciones_por_vencer = DB::table('rendiciones')
            ->join('subvenciones', 'rendiciones.subvencion_id', '=', 'subvenciones.id')
            ->where('rendiciones.estado', 1)
            ->where('subvenciones.estado', 1)
            ->where('rendiciones.estado_rendicion_id', 3)
            ->whereRaw("DATE_ADD(subvenciones.fecha_asignacion, INTERVAL {$this->plazo_por_vencer} DAY) = NOW()")
            ->select('rendiciones.id', 'rendiciones.estado_rendicion_id', 'subvenciones.fecha_asignacion')
            ->get();
            
            $contador = 0;
            if ($rendiciones_por_vencer->isEmpty()){
                Log::info("No hay rendiciones por vencer.");
            } else {
                // Cambiar estado de rendiciones que ya vencieron y enviar notificaciones
                foreach($rendiciones_por_vencer as $rendicion){
                    // Cuidado con este método que actualiza la rendición a rechazada
                    $resultado = $correoService->notificacionPorVencer($rendicion->id);
                    if (isset($resultado['success']) && $resultado['success'] === true){
                        $contador++;
                        // Caso mixto
                        if (isset($resultado['errores']) && is_array($resultado['errores'])){
                            Log::info("Notificaciones de vencimiento enviadas exitosamente: Id rendición: {$rendicion->id} | Correos enviados: ". implode(', ', $resultado['exitosos']) . 'Ocurrió un error al notificar al(los) siguiente(s) correos:' . implode(', ', $resultado['errores']) . '.');
                        // Caso sin información de correos
                        } else if (isset($resultado['errores']) && !is_array($resultado['errores'])) {
                            Log::info("No se enviaron notificaciones de rendiciones por vencer: Id rendición: {$rendicion->id} | Error: No se enviaron notificaciones. " . implode(', ', $resultado['errores']));
                        // Caso exitoso se enviaron todos los correos
                        } else {
                            Log::info("Notificaciones de vencimiento enviadas exitosamente: Id rendición: {$rendicion->id} | Correos enviados:" . implode(', ', $resultado['exitosos']) . '.');
                        }
                        // Caso fallaron todos los correos
                    } else {
                        Log::info("No se enviaron notificaciones de rendiciones por vencer: Id rendición: {$rendicion->id} | Ocurrió un error al notificar al(los) siguiente(s) correos:" . $resultado['errores'] . '.');

                    }
                }
            }
            Log::info("Tarea finalizada: Número de organizaciones notificadas: $contador");
        } catch(Exception $e) {
            Log::error("Error: {$e}");
        }    }
}
