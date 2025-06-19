<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'correo' => 'required|email',
        'contrasena' => 'required'
    ]);

    if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['contrasena']])) {
        $request->session()->regenerate();
        $usuario = Auth::user();

        if ($usuario->id_tipo_usuario == 1) {
            // Admin
            return redirect()->intended('/usuarios');
        } else {
            // Cliente
            return redirect()->route('inicio.index'); // o la ruta del catálogo
        }
    }

    return back()->withErrors(['correo' => 'Credenciales inválidas.'])->withInput();
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

