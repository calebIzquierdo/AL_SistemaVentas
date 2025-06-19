<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Auth;

class CarritoController extends Controller
{
    // Ver carrito
    public function verCarrito()
    {
        $cart = session()->get('cart', []);
        return response()->json(['cart' => $cart]);
    }

    public function agregarAlCarrito(Request $request)
{
    // Obtener los datos del producto
    $productoId = $request->producto_id;
    $productoNombre = $request->producto_nombre;
    $productoPrecio = $request->producto_precio;
    $cantidad = $request->cantidad;

    // Verificar que los datos del producto no estén vacíos
    if (!$productoId || !$productoNombre || !$productoPrecio || !$cantidad) {
        return response()->json(['error' => 'Datos incompletos'], 400);
    }

    // Obtener el carrito actual de la sesión
    $cart = session()->get('cart', []);

    // Verificar si el producto ya existe en el carrito
    if (isset($cart[$productoId])) {
        // Si ya está, aumentar la cantidad
        $cart[$productoId]['cantidad'] += $cantidad;
    } else {
        // Si no está en el carrito, agregar el producto con todos los detalles
        $cart[$productoId] = [
            'nombre' => $productoNombre,
            'precio' => $productoPrecio,
            'cantidad' => $cantidad,
        ];
    }

    // Guardar el carrito actualizado en la sesión
    session()->put('cart', $cart);

    // Retornar la respuesta con el carrito actualizado
    return response()->json(['cart' => $cart]);
}



    // Actualizar cantidad
    public function actualizarCantidad(Request $request)
    {
        $productoId = $request->producto_id;
        $nuevaCantidad = $request->cantidad;

        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        // Verificar si el producto existe en el carrito
        if (isset($cart[$productoId])) {
            // Actualizar la cantidad del producto
            $cart[$productoId]['cantidad'] = $nuevaCantidad;
        }

        // Guardar el carrito actualizado en la sesión
        session()->put('cart', $cart);

        // Retornar la respuesta con el carrito actualizado
        return response()->json(['cart' => $cart]);
    }


    // Eliminar producto del carrito
    public function quitarDelCarrito(Request $request, $productoId)
    {
        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        // Verificar si el producto existe en el carrito
        if (isset($cart[$productoId])) {
            // Eliminar el producto del carrito
            unset($cart[$productoId]);
        }

        // Guardar el carrito actualizado en la sesión
        session()->put('cart', $cart);

        // Retornar la respuesta con el carrito actualizado
        return response()->json(['cart' => $cart]);
    }

}