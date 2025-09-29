<?php

namespace App\Http\Controllers;
use App\Models\Rendicion;
use App\Models\Subvencion;
use App\Models\Persona;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadisticasController extends BaseController
{

    private function rendicionPorMes($estado, $anio){
        $query = DB::select("SELECT MONTH(subvenciones.fecha_asignacion) AS mes, 
                        COUNT(*) AS total
                        FROM rendiciones 
                        INNER JOIN subvenciones 
                        ON subvenciones.id = rendiciones.subvencion_id
                        WHERE subvenciones.estado = 1
                        AND rendiciones.estado = 1
                        AND rendiciones.estado_rendicion_id = $estado
                        AND YEAR(subvenciones.fecha_asignacion) = $anio
                        GROUP BY mes
                        ORDER BY mes;
                        "
        );

        $coleccion = collect($query);
        $meses = collect(range(1, 12));
        $rendiciones = $meses->mapWithKeys(function($mes) use($coleccion){
            $total = $coleccion->firstWhere('mes', $mes)->total ?? 0;
            $nombreMes = Carbon::create()->month($mes)->locale('es')->monthName;
            return [ucfirst($nombreMes) => $total];
        })->toArray(); 
        return $rendiciones;
    }

        public function index(Request $request)
    {

        // pedir todos los años que existen para poblar el select de años
        $query_anios = DB::select('SELECT YEAR(fecha_asignacion) as anio
                FROM subvenciones 
                WHERE subvenciones.estado = 1
                GROUP BY anio           
                ORDER BY anio desc  
                '
        );

        $anios_disponibles = collect($query_anios)->pluck('anio')->toArray();
        $ultimo_anio = $anios_disponibles[0];
        // pedir todas las rendiciones por estado
        $rendiciones_no_iniciadas = $this->rendicionPorMes(1, $ultimo_anio);
        $rendiciones_revision = $this->rendicionPorMes(2, $ultimo_anio);
        $rendiciones_objetadas = $this->rendicionPorMes(3, $ultimo_anio);
        $rendiciones_aceptadas = $this->rendicionPorMes(4, $ultimo_anio);
        $rendiciones_rechazadas = $this->rendicionPorMes(5, $ultimo_anio);

        // conteos
        $conteo_subvenciones = Rendicion::where([['estado', 1], ['estado_rendicion_id', 1]])->count();
        $conteo_rendiciones = Rendicion::where([['estado', 1], ['estado_rendicion_id', '>', 1]])->count();
        $data = [
            'grafico' => [
                    'rendiciones_no_iniciadas' => $rendiciones_no_iniciadas, 
                    'rendiciones_revision' => $rendiciones_revision,
                    'rendiciones_objetadas' => $rendiciones_objetadas,
                    'rendiciones_aceptadas' => $rendiciones_aceptadas,
                    'rendiciones_rechazadas' => $rendiciones_rechazadas, 
                    'personas' => []
                ],
            'conteos' => [
                'subvenciones' => $conteo_subvenciones,
                'rendiciones' => $conteo_rendiciones,
                'personas' => null
            ],
            'select' => $anios_disponibles
        ];
        return view('inicio', compact('data'));
    }

    public function cambiarAnio(Request $request){
        $validated = $request->validate([
            'anio' => 'required|integer'
        ]);
        $anio = $validated['anio'];

        // pedir todas las rendiciones por estado
        $rendiciones_no_iniciadas = $this->rendicionPorMes(1, $anio);
        $rendiciones_revision = $this->rendicionPorMes(2, $anio);
        $rendiciones_objetadas = $this->rendicionPorMes(3, $anio);
        $rendiciones_aceptadas = $this->rendicionPorMes(4, $anio);
        $rendiciones_rechazadas = $this->rendicionPorMes(5, $anio);
        return response()->json([
            'success' => true,
            'grafico' => [
                    'rendiciones_no_iniciadas' => $rendiciones_no_iniciadas, 
                    'rendiciones_revision' => $rendiciones_revision,
                    'rendiciones_objetadas' => $rendiciones_objetadas,
                    'rendiciones_aceptadas' => $rendiciones_aceptadas,
                    'rendiciones_rechazadas' => $rendiciones_rechazadas, 
                    'personas' => []
                ] 
            ]);
    }

}
