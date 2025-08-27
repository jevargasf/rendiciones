<?php

namespace App\Http\Controllers;

use App\Models\Rendicion;
use App\Models\Subvencion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class InicioController extends Controller
{


    public function index(Request $request)
    {
        $subvenciones = Subvencion::count();
        $rendiciones = Rendicion::count();
        $usuarios = Usuario::count();
        return view('inicio', compact('subvenciones', 'rendiciones', 'usuarios'));
    }
}
