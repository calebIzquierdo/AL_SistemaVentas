<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ⚠️ Cambiado: extiende de Authenticatable
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'correo', 'celular', 'direccion', 'contrasena', 'estado', 'id_tipo_usuario'
    ];

    protected $hidden = [
        'contrasena', // ocultar campo sensible
    ];

    // ⚠️ Laravel busca un campo "password", pero tu campo es "contrasena"
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // 🔁 Relación con tipo de usuario
    public function tipo()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo_usuario');
    }

    // 👀 Scope para mostrar solo los activos
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }
}
