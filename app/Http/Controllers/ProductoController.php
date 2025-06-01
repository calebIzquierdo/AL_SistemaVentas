<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        return view('productos.index');
    }

    public function ajaxListar()
    {
    $productos = Producto::where('estado', 1)->with('categoria')->get();

    $data = $productos->map(function ($producto, $index) {
        return [
            $index + 1,
            '<div class="d-flex gap-1">
                <button class="btn btn-sm btn-primary btn-ver-imagen custom-view"
                        data-img="'.asset('storage/'.$producto->imagen).'">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-sm btn-warning btn-editar custom-edit"
                        data-id="'.$producto->id_producto.'"
                        data-nombre="'.$producto->nombre_producto.'"
                        data-talla="'.$producto->talla.'"
                        data-precio="'.$producto->precio.'"
                        data-id_categoria="'.$producto->id_categoria.'"
                        data-imagen_url="'.asset('storage/'.$producto->imagen).'">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-eliminar custom-delete"
                        data-id="'.$producto->id_producto.'">
                    <i class="bi bi-trash"></i>
                </button>
            </div>',
            $producto->nombre_producto,
            $producto->talla,
            $producto->precio,
            $producto->categoria->nombre ?? 'Sin categoría',
            '<img src="'.asset('storage/'.$producto->imagen).'" alt="Imagen" width="50">',
            '<span class="badge bg-success">Activo</span>',
        ];
    });

    return response()->json(['data' => $data]);
    }

    



    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'talla' => 'nullable|string|max:10',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_categoria' => 'required|exists:categoria,id_categoria',
        ]);

        $imagen = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        Producto::create([
            'nombre_producto' => $request->nombre_producto,
            'talla' => $request->talla,
            'precio' => $request->precio,
            'imagen' => $imagen,
            'estado' => 1,
            'id_categoria' => $request->id_categoria,
        ]);

        return response()->json(['message' => 'Producto creado']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'talla' => 'nullable|string|max:10',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_categoria' => 'required|exists:categoria,id_categoria',
        ]);

        $producto = Producto::findOrFail($id);

        if ($request->hasFile('imagen')) {
            // Borrar anterior si existe
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $producto->nombre_producto = $request->nombre_producto;
        $producto->talla = $request->talla;
        $producto->precio = $request->precio;
        $producto->id_categoria = $request->id_categoria;
        $producto->save();

        return response()->json(['message' => 'Producto actualizado']);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update(['estado' => 0]);
        return response()->json(['message' => 'Producto eliminado']);
    }
}
