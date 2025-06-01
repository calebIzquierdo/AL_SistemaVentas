<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Mostrar vista principal
    public function index()
    {
        return view('categories.index');
    }

    // ✅ Listado para DataTables (AJAX)
    public function ajaxListar()
    {
        $categorias = Categoria::where('estado', 1)->get();

        $data = $categorias->map(function ($categoria, $index) {
            return [
                $index + 1,
                '<div class="d-flex gap-1">
                    <button class="btn btn-sm btn-warning btn-editar custom-edit" 
                            data-id="'.$categoria->id_categoria.'" 
                            data-nombre="'.$categoria->nombre.'">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar custom-delete" 
                            data-id="'.$categoria->id_categoria.'">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>',
                $categoria->nombre,
                '<span class="badge bg-success">Activo</span>',
            ];
        });

        return response()->json(['data' => $data]);
    }

    // ✅ Guardar nueva categoría
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        Categoria::create([
            'nombre' => $request->nombre,
            'estado' => 1
        ]);
        return response()->json(['message' => 'Categoría creada']);
    }

    // ✅ Actualizar categoría
    public function update(Request $request, $id)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        $categoria = Categoria::findOrFail($id);
        $categoria->update(['nombre' => $request->nombre]);
        return response()->json(['message' => 'Categoría actualizada']);
    }

    // ✅ Borrado lógico
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update(['estado' => 0]);
        return response()->json(['message' => 'Categoría eliminada']);
    }
}
