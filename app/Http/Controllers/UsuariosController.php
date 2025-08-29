<?php

namespace App\Http\Controllers;

use App\Models\Detalle_unidad_usuario;
use App\Models\Unidades;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UsuariosController extends BaseController
{
    public function index()
    {
        $unidades = Unidades::where('estado', 1)->get();
        $usuarios = Usuarios::where('estado', 1)->orderBy('id', 'DESC')->get();

        return view('usuarios.index', compact('unidades', 'usuarios'));
    }

    public function detalles($id)
    {
        $usuario = Usuarios::leftJoin('unidades', 'usuarios.fk_unidad_id', 'unidades.id')
            ->select('usuarios.*', 'unidades.nombre AS unidad')
            ->find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
          
        return response()->json($usuario);
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->fk_unidad_id = $request->input('fk_unidad_id');
        $usuario->save();

        return response()->json(['success' => true, 'message' => 'Usuario editado exitosamente.']);
    }
}
