<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    //
    protected $table = 'tipo_usuario';
    protected $primaryKey = 'id_tipo_usuario';
    public $timestamps = false;

    protected $fillable = ['nombre', 'estado'];

    // Scope para mostrar solo activas por defecto
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }
    
}
