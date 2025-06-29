<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedido'; // Nombre de la tabla
    protected $primaryKey = 'id_detalle_pedido'; // Clave primaria de la tabla
    public $timestamps = false; // Si no tienes columnas `created_at` y `updated_at` en la tabla

    protected $fillable = [
        'id_pedido',
        'id_producto',
        'cantidad',
        'sub_total',
        'estado'
    ];

    // Relación con el modelo Pedido (un detalle pertenece a un pedido)
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    // Relación con el modelo Producto (un detalle pertenece a un producto)
    public function producto()
    {
        return $this->belongsTo(Product::class, 'id_producto', 'id_producto');
    }
}
