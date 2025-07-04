<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = ['nombre', 'estado'];

    // Scope para mostrar solo activas por defecto
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }
}
