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
        // En revisión (estado_rendicion_id = 2)
        $rendiciones = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 2) // En revisión
            ->get();

        // Objetadas (estado_rendicion_id = 3)
        $pendientes = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 3) // Objetadas
            ->get();

        // Aprobadas (estado_rendicion_id = 5)
        $observadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 5) // Aprobadas
            ->get();

        // Rechazadas (estado_rendicion_id = 4)
        $rechazadas = Rendicion::with(['subvencion', 'estadoRendicion'])
            ->where('estado', 1)
            ->where('estado_rendicion_id', 4) // Rechazadas
            ->get();

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
                ->select('id', 'fecha', 'comentario', 'km_nombre', 'rendicion_id', 'persona_id', 'cargo_id', 'estado')
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
    
    /**
     * Eliminar temporalmente una rendición (cambiar estado de subvención a 1 y estado_rendicion_id a 1)
     */
    public function eliminarTemporalmente(Request $request)
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
                    'message' => 'Solo se pueden eliminar temporalmente las rendiciones en revisión'
                ]);
            }

            // Actualizar estado de la subvención a 1
            $rendicion->subvencion->update(['estado' => 1]);
            
            // Actualizar estado_rendicion_id a 1 (Recepcionada)
            $rendicion->update(['estado_rendicion_id' => 1]);

            // Registrar la acción
            Accion::create([
                'rendicion_id' => $rendicion->id,
                'persona_id' => auth()->user()->persona_id ?? 1, // Usar ID de persona del usuario autenticado o 1 por defecto
                'cargo_id' => 1, // Asumir cargo por defecto
                'comentario' => 'eliminada momentaneamente',
                'fecha' => now(),
                'estado' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rendición eliminada temporalmente. La subvención ha vuelto al estado inicial.'
            ]);

        } catch (Exception $e) {
            \Log::error('Error en eliminarTemporalmente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar temporalmente la rendición: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
}


