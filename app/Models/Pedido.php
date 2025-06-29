<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido'; // Nombre de la tabla
    protected $primaryKey = 'id_pedido'; // Clave primaria de la tabla
    public $timestamps = false; // Si no tienes columnas `created_at` y `updated_at` en la tabla

    protected $fillable = [
        'id_usuario',
        'fecha_pedido',
        'estado_pedido',
        'total',
        'estado'
    ];

    // Relación con la tabla detalle_pedido (un pedido tiene muchos detalles)
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }
}
