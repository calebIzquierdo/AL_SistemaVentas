<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    // Mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Almacenar los datos del usuario
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:100|unique:usuario',
            'celular' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'contrasena' => 'required|string|min:6',
            'id_tipo_usuario' => 'required|integer'
        ]);

        // Crear el usuario
        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'contrasena' => bcrypt($request->contrasena),
            'estado' => 1,
            'id_tipo_usuario' => $request->id_tipo_usuario
        ]);

        // Usamos session flash para guardar un mensaje de éxito
        session()->flash('success', 'Usuario registrado con éxito. Puedes iniciar sesión ahora.');

        // Redirigimos a la página de login
        return redirect()->route('login');
    }
}
