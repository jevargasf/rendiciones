<?php

namespace App\Http\Controllers;

use App\Models\Rendicion;
use App\Models\Accion;
use Illuminate\Http\Request;
use App\Models\Subvencion;
use App\Models\Notificacion;
use Exception;
use Illuminate\Routing\Controller as BaseController;

class RendicionController extends BaseController
{


    public function index()
    {
        $rendiciones = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)->get();

        $pendientes = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 2)->get();

        $observadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 3)->get();

        $rechazadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 4)->get();




        // dd($rendiciones);

        return view(

            'rendiciones.index',

            compact('rendiciones', 'pendientes', 'observadas', 'rechazadas')

        );
    }

   
    public function detalleRendicion(Request $request) /** detalleRendicion es el mismo nombre de la ruta, Así Laravel sabe qué método ejecutar cuando llega una petición a esa ruta*/
    {
        try{
            $acciones = Accion::with(['persona', 'cargo'])
                ->where('estado', 1)
                ->where('rendicion_id', $request->id)
                ->get();

            $notificaciones = Notificacion::with(['tipoNotificacion'])
                ->where('rendicion_id', $request->id)
                ->get();

            return response()->json([
                /**Devuelve todas las acciones que encontró la consulta en formato JSON */
                'acciones' => $acciones,
                'notificaciones' => $notificaciones,
            ]);
        } catch(Exception $e) {
            print($e);
        }
    }
    
    
}


