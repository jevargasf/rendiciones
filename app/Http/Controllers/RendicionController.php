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
            ->where('estado', 1)
            ->where('estado_rendicion_id', '!=', 1) // Excluir rendiciones con estado_rendicion_id = 1 (Pendiente)
            ->get();

        $pendientes = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 2)
            ->where('estado_rendicion_id', '!=', 1) // Excluir rendiciones con estado_rendicion_id = 1 (Pendiente)
            ->get();

        $observadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 3)
            ->where('estado_rendicion_id', '!=', 1) // Excluir rendiciones con estado_rendicion_id = 1 (Pendiente)
            ->get();

        $rechazadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 4)
            ->where('estado_rendicion_id', '!=', 1) // Excluir rendiciones con estado_rendicion_id = 1 (Pendiente)
            ->get();




        // dd($rendiciones);

        return view(

            'rendiciones.index',

            compact('rendiciones', 'pendientes', 'observadas', 'rechazadas')

        );
    }

   
    public function detalleRendicion(Request $request) /** detalleRendicion es el mismo nombre de la ruta, Así Laravel sabe qué método ejecutar cuando llega una petición a esa ruta*/
    {
        try{
            // Obtener el ID de la rendición
            $rendicionId = $request->input('id');
            
            if (!$rendicionId) {
                return response()->json(['error' => 'ID de rendición requerido'], 400);
            }

            // Obtener acciones
            $acciones = Accion::with(['persona', 'cargo'])
                ->where('estado', 1)
                ->where('rendicion_id', $rendicionId)
                ->orderBy('fecha', 'desc')
                ->get();

            // Obtener notificaciones a través de acciones
            $notificaciones = Notificacion::with(['accion'])
                ->whereHas('accion', function($query) use ($rendicionId) {
                    $query->where('rendicion_id', $rendicionId);
                })
                ->orderBy('fecha_envio', 'desc')
                ->get();

            return response()->json([
                'acciones' => $acciones,
                'notificaciones' => $notificaciones,
            ]);
        } catch(Exception $e) {
            \Log::error('Error en detalleRendicion: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al obtener los detalles de la rendición',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
}


