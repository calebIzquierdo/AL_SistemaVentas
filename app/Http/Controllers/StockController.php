<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Producto;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(){
        // Solo recuperar productos activos
        $productos = Producto::where('estado', 1)->get();
        return view('stock.index', compact('productos'));
    }


    public function ajaxListar()
    {
        $stock = Stock::with(['producto' => function($query) {
            $query->where('estado', 1);  // Filtrar productos con estado 1
        }])->activo()->get();

        $data = $stock->map(function ($item, $index) {
            // Lógica para determinar el color de la barra
            $stockLevel = $item->cantidad;
            $progressClass = 'bg-success';  // Por defecto es verde

            if ($stockLevel <= 5) {
                $progressClass = 'bg-danger'; // Rojo
            } elseif ($stockLevel <= 15) {
                $progressClass = 'bg-warning'; // Naranja
            }

            return [
                $index + 1,
                '<div class="d-flex gap-1">
                    <button class="btn btn-sm btn-warning btn-editar custom-edit" 
                            data-id="'.$item->id_stock.'" 
                            data-fecha_inicio="'.$item->fecha_inicio.'" 
                            data-cantidad="'.$item->cantidad.'" 
                            data-id_producto="'.$item->id_producto.'">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar custom-delete" 
                            data-id="'.$item->id_stock.'">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>',
                $item->producto->nombre_producto ?? 'Sin producto',
                $item->fecha_inicio,
                $item->cantidad,
                $item->fecha_actualizada,  // Mostrar la fecha de la última actualización
                '<div class="progress">
                    <div class="progress-bar ' . $progressClass . '" role="progressbar" style="width: ' . $stockLevel . '%;" aria-valuenow="' . $stockLevel . '" aria-valuemin="0" aria-valuemax="100"></div>
                </div>',
                '<span class="badge bg-success">Activo</span>',
            ];
        });

        return response()->json(['data' => $data]);
    }





    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'cantidad' => 'required|integer',
            'id_producto' => 'required|exists:producto,id_producto',
        ]);

        Stock::create([
            'fecha_inicio' => $request->fecha_inicio,
            
            'cantidad' => $request->cantidad,
            'estado' => 1,
            'id_producto' => $request->id_producto,
        ]);

        return response()->json(['message' => 'Stock creado']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'cantidad' => 'required|integer',
            'id_producto' => 'required|exists:producto,id_producto',
        ]);

        $stock = Stock::findOrFail($id);

        // Sumar la cantidad existente con la nueva cantidad
        $stock->cantidad += $request->cantidad;

        // Actualizar el resto de los campos
        $stock->update([
            'fecha_inicio' => $request->fecha_inicio,
            'cantidad' => $stock->cantidad,  // Actualizar la cantidad sumada
            'id_producto' => $request->id_producto,
            'fecha_actualizada' => now(),  // Fecha de actualización
        ]);

        return response()->json(['message' => 'Stock actualizado']);
    }


    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->update(['estado' => 0]);
        return response()->json(['message' => 'Stock eliminado']);
    }

   public function getProductosDisponibles()
{
    // Obtener productos activos que no están en la tabla stock
    $productos = Producto::where('estado', 1)
        ->whereNotIn('id_producto', Stock::pluck('id_producto')) // Excluir productos ya en stock
        ->get();

    // Convertir a un array y devolverlo como respuesta JSON
    return response()->json(['productos' => $productos->toArray()]);
}




}
