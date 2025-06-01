<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $tipos = TipoUsuario::all();
        return view('usuarios.index', compact('tipos'));
    }

    public function ajaxListar()
    {
        $usuarios = Usuario::with('tipo')->where('estado', 1)->get();

        $data = $usuarios->map(function ($usuario, $index) {
            return [
                $index + 1,
                '<div class="d-flex gap-1">
                    <button class="btn btn-sm btn-warning btn-editar custom-edit" 
                            data-id="'.$usuario->id_usuario.'" 
                            data-nombre="'.$usuario->nombre.'" 
                            data-correo="'.$usuario->correo.'" 
                            data-celular="'.$usuario->celular.'" 
                            data-direccion="'.$usuario->direccion.'" 
                            data-id_tipo_usuario="'.$usuario->id_tipo_usuario.'">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar custom-delete" 
                            data-id="'.$usuario->id_usuario.'">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>',
                $usuario->nombre,
                $usuario->correo,
                $usuario->celular,
                $usuario->direccion,
                $usuario->tipo->nombre ?? 'Sin tipo',
                '<span class="badge bg-success">Activo</span>',
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:100|unique:usuario',
            'celular' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'contrasena' => 'required|string|min:6',
            'id_tipo_usuario' => 'required|integer'
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'contrasena' => bcrypt($request->contrasena),
            'estado' => 1,
            'id_tipo_usuario' => $request->id_tipo_usuario
        ]);

        return response()->json(['message' => 'Usuario creado']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:100|unique:usuario,correo,'.$id.',id_usuario',
            'celular' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'id_tipo_usuario' => 'required|integer'
        ]);

        $usuario = Usuario::findOrFail($id);

        $usuario->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'id_tipo_usuario' => $request->id_tipo_usuario
        ]);

        return response()->json(['message' => 'Usuario actualizado']);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->update(['estado' => 0]);
        return response()->json(['message' => 'Usuario eliminado']);
    }
}
