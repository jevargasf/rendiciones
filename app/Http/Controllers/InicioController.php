<?php

namespace App\Http\Controllers;
// pido el modelo
use App\Models\Rendicion;
use App\Models\Subvencion;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class InicioController extends BaseController
{


    public function index(Request $request)
    {
        // utilizo el modelo a través de una consulta
        // conteo de las subvenciones registradas -> Eloquent (ORM->capa de la aplicación que se comunica con la bd)
        $subvenciones = Subvencion::where('estado', 1)
            ->where('estado', '!=', 9) // Excluir subvenciones eliminadas
            ->count();
        $rendiciones = Rendicion::where('estado', 1)
            ->where('estado_rendicion_id', '!=', 1) // Excluir rendiciones con estado_rendicion_id = 1 (Pendiente)
            ->where('estado', '!=', 9) // Excluir rendiciones eliminadas
            ->count();
        $personas = Persona::count();
        // envío los datos
        return view('inicio', compact('subvenciones', 'rendiciones', 'personas'));
    }
}
