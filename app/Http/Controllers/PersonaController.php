<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Exception;

class PersonaController
{
    /**
     * Obtener datos de una persona específica
     */
    public function obtener(Request $request)
    {
        try {
            $validated = $request->validate([
                'rut' => 'required|regex:/^[0-9]{1,2}[0-9]{3}[0-9]{3}-[0-9kK]$/|exists:personas,rut'
            ]);

            $persona = Persona::where('rut', $validated['rut'])
            ->where('estado', 1)
            ->first();
            
            return response()->json([
                'success' => true,
                'persona' => [
                    'rut' => $persona->rut,
                    'nombre' => $persona->nombre,
                    'apellido' => $persona->apellido,
                    'correo' => $persona->correo
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
            
            // Intentar normalizar el RUT si es posible
            $rutNormalizado = $this->normalizarRut($query);
            if ($rutNormalizado) {
                // Si el RUT es válido, buscar exactamente
                $personas = Persona::where('estado', 1)
                    ->where('rut', $rutNormalizado)
                    ->limit(10)
                    ->get();
            } else {
                // Si no es un RUT válido, buscar por coincidencia parcial
                $personas = Persona::where('estado', 1)
                    ->where('rut', 'LIKE', '%' . $query . '%')
                    ->limit(10)
                    ->get();
            }
            
            return response()->json([
                'success' => true,
                'data' => $personas->map(function($persona) {
                    return [
                        'id' => $persona->id,
                        'rut' => $persona->rut,
                        'nombre' => $persona->nombre,
                        'apellido' => $persona->apellido,
                        'correo' => $persona->correo,
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

    /**
     * Crear o actualizar una persona
     */
    public function guardar(Request $request)
    {
        try {
            $request->validate([
                'rut' => 'required|string|max:20',
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'correo' => 'required|email|max:100',
            ]);

            // Normalizar RUT
            $rutNormalizado = $this->normalizarRut($request->rut);
            if (!$rutNormalizado) {
                return response()->json([
                    'success' => false,
                    'message' => 'RUT inválido'
                ]);
            }

            // Buscar si ya existe una persona con el mismo RUT
            $persona = Persona::where('rut', $rutNormalizado)->first();

            if ($persona) {
                // Actualizar persona existente
                $persona->update([
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'correo' => $request->correo,
                    'estado' => 1
                ]);
                
                $mensaje = 'Persona actualizada correctamente';
            } else {
                // Crear nueva persona
                $persona = Persona::create([
                    'rut' => $rutNormalizado,
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'correo' => $request->correo,
                    'estado' => 1
                ]);
                
                $mensaje = 'Persona creada correctamente';
            }
            
            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => [
                    'id' => $persona->id,
                    'rut' => $persona->rut,
                    'nombre' => $persona->nombre,
                    'apellido' => $persona->apellido,
                    'correo' => $persona->correo,
                    'estado' => $persona->estado
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la persona: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Normalizar RUT chileno
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
}
