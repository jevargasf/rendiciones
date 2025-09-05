<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UsuariosController extends BaseController
{
    public function index()
    {
        $usuarios = Usuarios::orderBy('id', 'DESC')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function detalles($id)
    {
        $usuario = Usuarios::find($id);

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

        $usuario->update($request->only(['rut', 'nombre', 'apellido', 'correo']));

        return response()->json(['success' => true, 'message' => 'Usuario editado exitosamente.']);
    }
}
