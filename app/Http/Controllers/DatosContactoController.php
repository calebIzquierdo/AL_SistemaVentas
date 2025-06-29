<?php

namespace App\Http\Controllers;

use App\Models\DatosContacto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatosContactoController extends Controller
{
    public function index()
    {
        return view('datos_contacto.index');
    }
    
    public function servicio()
    {
        return view('datos_contacto.servicio');
    }   

    public function ajaxListar()
    {
        $contactos = DatosContacto::where('estado', 1)
            ->with('usuario')
            ->get();

        $data = $contactos->map(function ($contacto, $index) {
            $nombreUsuario = $contacto->usuario ? $contacto->usuario->nombre : 'Sin usuario';
            $fechaInicio = $contacto->fecha_inicio ? date('d/m/Y', strtotime($contacto->fecha_inicio)) : '';
            $fechaFin = $contacto->fecha_fin ? date('d/m/Y', strtotime($contacto->fecha_fin)) : '';

            return [
                $index + 1,
                $fechaInicio,
                $fechaFin,
                $contacto->cantidad,
                $nombreUsuario,
                '<div class="d-flex gap-1">
                    <button class="btn btn-sm btn-warning btn-editar custom-edit"
                            data-id="'.$contacto->id_contrato.'"
                            data-fecha_inicio="'.$contacto->fecha_inicio.'"
                            data-fecha_fin="'.$contacto->fecha_fin.'"
                            data-cantidad="'.$contacto->cantidad.'"
                            data-id_usuario="'.$contacto->id_usuario.'">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar custom-delete"
                            data-id="'.$contacto->id_contrato.'">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>'
            ];
        });

        return response()->json([
            'draw' => 1,
            'recordsTotal' => $contactos->count(),
            'recordsFiltered' => $contactos->count(),
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validación de datos
            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'cantidad' => 'required|integer|min:1'
            ]);

            // Verificar si el usuario está autenticado
            $usuarioId = Auth::id();
            if (!$usuarioId) {
                return view('auth.login');
            }

            // Verificar si el usuario existe
            $usuario = Usuario::where('id_usuario', $usuarioId)->first();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Crear nuevo registro
            $contacto = new DatosContacto();
            $contacto->id_usuario = $usuarioId;
            $contacto->fecha_inicio = $request->fecha_inicio;
            $contacto->fecha_fin = $request->fecha_fin;
            $contacto->cantidad = $request->cantidad;
            $contacto->estado = 1; // Asegurarse que el estado es 1 por defecto
            $contacto->save();

            return  redirect()->route('datos-contacto.servicio')->with('success', 'Datos de contacto guardados exitosamente');

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $contacto = DatosContacto::findOrFail($id);
        $contacto->delete();
        return response()->json(['success' => true]);
    }
}
