<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Exception;

class PersonaController extends BaseController
{
    /**
     * Obtener datos de una persona específica
     */
    public function obtener(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:personas,id'
            ]);

            $persona = Persona::findOrFail($request->id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $persona->id,
                    'rut' => $persona->rut,
                    'nombre' => $persona->nombre,
                    'apellido' => $persona->apellido,
                    'correo' => $persona->correo,
                    'telefono' => $persona->telefono ?? '',
                    'estado' => $persona->estado
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la persona: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Buscar personas por RUT (para autocompletado)
     */
    public function buscar(Request $request)
    {
        try {
            $request->validate([
                'q' => 'required|string|min:2'
            ]);

            $query = $request->q;
            $personas = Persona::where('estado', 1)
                ->where('rut', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $personas->map(function($persona) {
                    return [
                        'id' => $persona->id,
                        'rut' => $persona->rut,
                        'nombre' => $persona->nombre,
                        'apellido' => $persona->apellido,
                        'correo' => $persona->correo,
                        'telefono' => $persona->telefono ?? ''
                    ];
                })
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar personas: ' . $e->getMessage()
            ]);
        }
    }
}
