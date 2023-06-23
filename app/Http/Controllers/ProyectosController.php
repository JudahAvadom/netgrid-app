<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Proyectos;
use Illuminate\Support\Facades\DB;

class ProyectosController extends Controller
{
    /**
     * Crear un proyecto
     */
    public function crear(Request $request){
        $nombre = $request->nombre;
        $descripcion = $request->descripcion;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_finalizacion = $request->fecha_finalizacion;
        $creado_por = Auth::id();
        Proyectos::create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_finalizacion' => $fecha_finalizacion,
            'creado_por' => $creado_por
        ]);
        return "SUCCESS";
    }

    /**
     * Obtener proyectos de un usuario
     */
    public function consultar(Request $request){
        if ($request->id) {
            $id = $request->id;
        }
        else {
            $id = Auth::id();
        }
        $query= DB::table('proyectos')->get()->where('creado_por',$id);
        return $query;
    }

    /**
     * Eliminar un proyectos de un usuario
     */
    public function eliminar(Request $request){
        $id = $request->id;
        $query= DB::table('proyectos')->where('id', $id)->delete();
        return "SUCCESS";
    }
}
