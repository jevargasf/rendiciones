<?php

namespace App\Http\Controllers;
// pido el modelo
use App\Models\Rendicion;
use App\Models\Subvencion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class InicioController extends BaseController
{


    public function index(Request $request)
    {
        // utilizo el modelo a través de una consulta
        // conteo de las subvenciones registradas -> Eloquent (ORM->capa de la aplicación que se comunica con la bd)
        $subvenciones = Subvencion::count();
        $rendiciones = Rendicion::count();
        $usuarios = Usuario::count();
        // envío los datos
        return view('inicio', compact('subvenciones', 'rendiciones', 'usuarios'));
    }
}
