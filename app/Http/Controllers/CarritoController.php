<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Stock;


class CarritoController extends Controller
{
    // Ver carrito
    public function verCarrito()
    {
        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        // Retornar el carrito en formato JSON
        return response()->json(['cart' => $cart]);
    }

    // Agregar producto al carrito
    public function agregarAlCarrito(Request $request)
    {
        // Obtener los datos del producto
        $productoId = $request->producto_id;
        $productoNombre = $request->producto_nombre;
        $productoPrecio = $request->producto_precio;
        $cantidad = (int)$request->cantidad;  // Asegurarse de que la cantidad sea un número entero

        // Verificar que los datos del producto no estén vacíos
        if (!$productoId || !$productoNombre || !$productoPrecio || !$cantidad) {
            return response()->json(['error' => 'Datos incompletos'], 400);
        }

        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Verificar si el producto ya existe en el carrito
        if (isset($cart[$productoId])) {
            // Si ya está, aumentar la cantidad
            $cart[$productoId]['cantidad'] += $cantidad;  // Asegurarse de sumar correctamente
        } else {
            // Si no está en el carrito, agregar el producto con todos los detalles
            $cart[$productoId] = [
                'nombre' => $productoNombre,
                'precio' => $productoPrecio,
                'cantidad' => $cantidad,  // Asegurarse de que la cantidad es un número entero
            ];
        }

        // Guardar el carrito actualizado en la sesión
        session()->put('cart', $cart);

        // Retornar la respuesta con el carrito actualizado
        return response()->json(['cart' => $cart]);
    }

    // Actualizar cantidad de un producto en el carrito
    public function actualizarCantidad(Request $request)
    {
        $productoId = $request->producto_id;
        $nuevaCantidad = (int)$request->cantidad;  // Asegurarse de que la cantidad sea un número entero

        // Verificar que la cantidad sea válida
        if ($nuevaCantidad <= 0) {
            return response()->json(['error' => 'La cantidad debe ser mayor que cero'], 400);
        }

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

    // Eliminar un producto del carrito
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

    public function finalizarCompra(Request $request)
    {
    // Obtener el carrito de la sesión
    $cart = session()->get('cart', []);
    
    // Verificar que el carrito no esté vacío
    if (empty($cart)) {
        return response()->json(['error' => 'El carrito está vacío'], 400);
    }

    // Crear un nuevo pedido en la base de datos
    $pedido = new Pedido();
    $pedido->id_usuario = auth()->id();  // Suponiendo que se tiene autenticación
    $pedido->fecha_pedido = now();
    $pedido->estado_pedido = 'Pendiente'; // O el estado que desees
    $pedido->total = 0;  // Inicialmente el total es 0
    $pedido->save(); // Guardar el pedido para obtener el id

    // Iterar sobre el carrito y agregar cada producto al detalle del pedido
    foreach ($cart as $productId => $product) {
        $detallePedido = new DetallePedido();
        $detallePedido->id_pedido = $pedido->id_pedido;
        $detallePedido->id_producto = $productId;
        $detallePedido->cantidad = $product['cantidad'];
        $detallePedido->sub_total = $product['cantidad'] * $product['precio'];
        $detallePedido->save();

        // Actualizar el stock después de que el producto se haya agregado al pedido
        $stock = Stock::where('id_producto', $productId)->first();
        if ($stock) {
            $stock->cantidad -= $product['cantidad'];  // Reducir el stock
            $stock->save();
        }
    }

    // Limpiar el carrito
    session()->forget('cart');

    // Retornar respuesta de éxito
    return response()->json(['message' => 'Compra finalizada con éxito'], 200);
}


}