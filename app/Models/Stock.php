<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'id_stock';
    public $timestamps = false;

    protected $fillable = [
        'fecha_inicio', 'fecha_actualizada', 'cantidad', 'estado', 'id_producto'
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    // Scope para obtener stock activo
    public function scopeActivo($query)
    {
        return $query->where('estado', 1);
    }
}
