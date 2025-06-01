<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
    public function index()
{
    $productos = Producto::where('estado', 1)->get();
    return view('inicio.index', compact('productos'));
}

    

}
