<?php

namespace App\Http\Controllers;

use App\Helpers\Mailman;
use App\Models\Atenciones;
use App\Models\Plantillas;
use App\Models\Registros;
use App\Models\Rel_solicitud_usuario;
use App\Models\Solicitudes;
use App\Models\Unidades;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UnidadesController extends Controller
{
    public function index()
    {
        $unidades = Unidades::where('estado', 1)->orderBy('id', 'DESC')->get();

        return view('unidades.index', compact('unidades'));
    }

    public function crear(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'descripcion' => 'required|max:255',
                'nombre' => 'required|max:255'
            ]);

            do {
                $token = Str::random(5);
            } while (Unidades::where('token', $token)->exists());

            $unidades = Unidades::create([
                'descripcion' => $request->descripcion,
                'nombre' => $request->nombre,
                'token' => $token,
            ]);

            return response()->json(['success' => true, 'message' => 'Unidad registrada exitosamente.']);
        }
    }

    public function editar(Request $request, Unidades $id)
    {

        if ($request->isMethod('put')) {

            $request->validate([
                'descripcion' => 'required|max:255',
                'nombre' => 'required|max:255'
            ]);

            $id->update([
                'descripcion' => $request->descripcion,
                'nombre' => $request->nombre,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Unidad editada exitosamente.']);
        }
    }

    public function eliminar(Unidades $id)
    {
        $id->update([
            'estado' => '9'
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidad eliminada exitosamente');
    }
}
