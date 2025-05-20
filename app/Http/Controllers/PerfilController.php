<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function mostrar()
    {
       return view('auth.perfil');
       

    }

    public function actualizar(Request $request)
{
    $user = Auth::user();
    $user->nombre = $request->input('nombre');
    $user->email = $request->input('email');
    $user->telefono = $request->input('telefono');
    $user->direccion = $request->input('direccion');
    $user->save();

    return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
}

}
