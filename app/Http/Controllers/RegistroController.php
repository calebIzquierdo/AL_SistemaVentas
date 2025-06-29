<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


class RegistroController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => [
                'required',
                'email',
                'max:100',
                'unique:usuario,correo',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/i'
            ],
            'celular' => ['required', 'regex:/^9\d{8}$/'],
            'direccion' => 'nullable|string|max:255',
            'contrasena' => [
                'required',
                'string',
                'min:7',
                'regex:/[A-Z]/',     // Al menos una mayúscula
                'regex:/[0-9]/',     // Al menos un número
                'regex:/[\W_]/'      // Al menos un carácter especial
            ],
            'id_tipo_usuario' => 'required|integer'
        ], [
            'correo.regex' => 'El correo debe ser válido (ej. usuario@dominio.com).',
            'correo.unique' => 'Este correo ya está registrado.',
            'celular.regex' => 'El número debe comenzar con 9 y tener 9 dígitos.',
            'contrasena.regex' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial.',
            'contrasena.min' => 'La contraseña debe tener mínimo 7 caracteres.'
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

        session()->flash('success', 'Usuario registrado con éxito. Puedes iniciar sesión ahora.');
        return redirect()->route('login');
    }
}
