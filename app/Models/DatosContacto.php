<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosContacto extends Model
{
    protected $table = 'datos_de_contacto';
    protected $primaryKey = 'id_contrato';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha_inicio',
        'fecha_fin',
        'cantidad',
        'estado'
    ];

    // Scope para mostrar solo activos por defecto
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
