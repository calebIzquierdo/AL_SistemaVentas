<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas por Semana (calculadas correctamente)
        $ventasSemana = DB::table('detalle_pedido')
            ->join('pedido', 'detalle_pedido.id_pedido', '=', 'pedido.id_pedido')
            ->join('producto', 'detalle_pedido.id_producto', '=', 'producto.id_producto')
            ->selectRaw("DAYNAME(pedido.fecha_pedido) as dia, SUM(detalle_pedido.cantidad * producto.precio) as total")
            ->whereBetween('pedido.fecha_pedido', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupByRaw("DAYNAME(pedido.fecha_pedido)")
            ->get();

        // Ventas por Mes (cantidad × precio por mes del año actual)
        $ventasMes = DB::table('detalle_pedido')
            ->join('pedido', 'detalle_pedido.id_pedido', '=', 'pedido.id_pedido')
            ->join('producto', 'detalle_pedido.id_producto', '=', 'producto.id_producto')
            ->selectRaw("MONTHNAME(pedido.fecha_pedido) as mes, SUM(detalle_pedido.cantidad * producto.precio) as total")
            ->whereYear('pedido.fecha_pedido', now()->year)
            ->groupByRaw("MONTH(pedido.fecha_pedido), MONTHNAME(pedido.fecha_pedido)")
            ->orderByRaw("MONTH(pedido.fecha_pedido)")
            ->get();

        // Ventas por Año
        $ventasAnio = DB::table('detalle_pedido')
            ->join('pedido', 'detalle_pedido.id_pedido', '=', 'pedido.id_pedido')
            ->join('producto', 'detalle_pedido.id_producto', '=', 'producto.id_producto')
            ->selectRaw("YEAR(pedido.fecha_pedido) as anio, SUM(detalle_pedido.cantidad * producto.precio) as total")
            ->groupByRaw("YEAR(pedido.fecha_pedido)")
            ->orderByRaw("anio")
            ->get();

        // Productos más Vendidos
        $productos = DB::table('detalle_pedido')
            ->join('producto', 'detalle_pedido.id_producto', '=', 'producto.id_producto')
            ->select('producto.nombre_producto as producto', DB::raw('SUM(detalle_pedido.cantidad) as total'))
            ->groupBy('producto.nombre_producto')
            ->get();

        return view('dashboard.index', compact('ventasSemana', 'ventasMes', 'ventasAnio', 'productos'));
    }
}

