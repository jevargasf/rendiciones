<?php

namespace App\Console\Commands;

use App\Models\Notificacion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\Mailman;

class CheckCorreosLeidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaciones:check-correos-leidos';

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
        // Consulta bd
        $no_leidas = Notificacion::where('estado', 1)->where('estado_notificacion', 0)->whereNotNull('email_id')->get();
        // Comprobación de respuesta
        foreach($no_leidas as $notificacion){
            $data = [
                'email' => $notificacion->email_id
            ];
    
            $mailmanAPI = new Mailman($data, 'status');

            $response = $mailmanAPI->enviarEmail();
            if ($response['response']['success'] === true){
                $notificacion->update([
                    'estado_notificacion' => 1
                ]);
                Log::info('Notificacion id: ' . $notificacion->id . ' Email id: ' . $notificacion->email_id . ' Respuesta: ' . $response['response']['message'] );
            } else {
                Log::info('Notificacion id: ' . $notificacion->id . ' Email id: ' . $notificacion->email_id . ' Respuesta: ' . $response['response']['message'] );
            }
        }
    }
}
