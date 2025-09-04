<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subvencion;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Routing\Controller as BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SubvencionController extends BaseController
{


    public function index()
    {
        $subvenciones = Subvencion::where('estado', 1)->get();

        // dd($subvenciones);

        return view(

            'subvenciones.index',

            compact('subvenciones')

        );  
    }

    public function crear(Request $request)
    {
        try {
            // Validar formulario
            $request->validate([
                'fecha_decreto' => 'required|date',
                'numero_decreto' => 'required|string|max:255',
                'seleccionar_archivo' => 'required|file|mimes:xls,xlsx|max:10240' // 10MB máximo
            ]);

            // Validar que el archivo sea Excel
            $file = $request->file('seleccionar_archivo');
            $extension = $file->getClientOriginalExtension();
            
            if (!in_array($extension, ['xls', 'xlsx'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se permiten archivos Excel (.xls o .xlsx)'
                ]);
            }

            // Almacenar el archivo temporalmente
            $filePath = $file->getRealPath();
            
            // Crear el lector apropiado según la extensión
            if ($extension === 'xlsx') {
                $reader = new Xlsx();
            } else {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            }
            
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);

            // Obtener la primera hoja
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestDataColumn();

            // Validar que el archivo tenga datos
            if ($highestRow < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no contiene datos válidos'
                ]);
            }

            // Obtener encabezados para validar formato
            $headers = $worksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $expectedHeaders = ['Rut Organización', 'Organización', 'Monto', 'Destino', 'Fecha'];
            
            // Validar que los encabezados sean correctos
            $headerRow = array_values($headers[1]);
            if (count($headerRow) < 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo debe tener al menos 5 columnas: RUT Organización, Organización, Monto, Destino, Fecha'
                ]);
            }

            $subvencionesCreadas = 0;
            $errores = [];

            // Procesar cada fila de datos
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    $rut = $worksheet->getCell('A' . $row)->getValue();
                    $organizacion = $worksheet->getCell('B' . $row)->getValue();
                    $monto = $worksheet->getCell('C' . $row)->getValue();
                    $destino = $worksheet->getCell('D' . $row)->getValue();
                    $fecha = $worksheet->getCell('E' . $row)->getValue();

                    // Validar datos de la fila
                    if (empty($rut) || empty($organizacion) || empty($monto) || empty($destino) || empty($fecha)) {
                        $errores[] = "Fila $row: Todos los campos son obligatorios";
                        continue;
                    }

                    // Normalizar y validar RUT
                    $rutNormalizado = $this->normalizarRut($rut);
                    if (!$rutNormalizado) {
                        $errores[] = "Fila $row: RUT inválido ($rut)";
                        continue;
                    }

                    // Validar monto
                    if (!is_numeric($monto) || $monto <= 0) {
                        $errores[] = "Fila $row: Monto inválido ($monto)";
                        continue;
                    }

                    // Convertir fecha si es necesario
                    $fechaAsignacion = $this->convertirFecha($fecha);
                    if (!$fechaAsignacion) {
                        $errores[] = "Fila $row: Fecha inválida ($fecha)";
                        continue;
                    }

                    // Crear registro de subvención
                    Subvencion::create([
                        'decreto' => $request->numero_decreto,
                        'monto' => (int) $monto,
                        'destino' => $destino,
                        'fecha_asignacion' => $fechaAsignacion,
                        'rut' => $rutNormalizado,
                        'organizacion' => $organizacion,
                        'estado' => 1
                    ]);

                    $subvencionesCreadas++;

                } catch (Exception $e) {
                    $errores[] = "Fila $row: Error al procesar - " . $e->getMessage();
                }
            }

            // Preparar respuesta
            $mensaje = "Se procesaron $subvencionesCreadas subvenciones correctamente";
            if (!empty($errores)) {
                $mensaje .= ". Errores encontrados: " . implode('; ', array_slice($errores, 0, 5));
                if (count($errores) > 5) {
                    $mensaje .= " y " . (count($errores) - 5) . " errores más";
                }
            }

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'subvenciones_creadas' => $subvencionesCreadas,
                'errores' => $errores
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Normalizar RUT chileno a formato estándar (12345678-9)
     * Acepta cualquier formato de entrada y lo convierte al formato estándar
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

    /**
     * Convertir fecha desde diferentes formatos
     */
    private function convertirFecha($fecha)
    {
        try {
            // Si es un objeto DateTime de PhpSpreadsheet
            if ($fecha instanceof \DateTime) {
                return $fecha->format('Y-m-d');
            }

            // Si es un número (fecha serial de Excel)
            if (is_numeric($fecha)) {
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($fecha);
                return date('Y-m-d', $timestamp);
            }

            // Si es string, intentar parsear diferentes formatos
            $formatos = [
                'd-m-Y',
                'd/m/Y',
                'Y-m-d',
                'Y/m/d',
                'd-m-y',
                'd/m/y'
            ];

            foreach ($formatos as $formato) {
                $fechaObj = \DateTime::createFromFormat($formato, $fecha);
                if ($fechaObj !== false) {
                    return $fechaObj->format('Y-m-d');
                }
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Eliminar una subvención (soft delete cambiando estado a 0)
     */
    public function eliminar(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:subvenciones,id'
            ]);

            $subvencion = Subvencion::findOrFail($request->id);
            
            // Verificar si la subvención tiene rendiciones asociadas
            if ($subvencion->rendiciones()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la subvención porque tiene rendiciones asociadas'
                ]);
            }

            // Cambiar estado a 0 (soft delete)
            $subvencion->update(['estado' => 0]);

            return response()->json([
                'success' => true,
                'message' => 'Subvención eliminada correctamente'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la subvención: ' . $e->getMessage()
            ]);
        }
    }
}
