<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tareas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TareasController extends Controller
{
    /**
     * Crear una tarea
     */
    public function crearTarea(Request $request){
        $proyecto_id = $request->proyecto_id;
        $nombre = $request->nombre;
        $estado = $request->estado;
        $descripcion = $request->descripcion;
        $creado_por = Auth::id();
        Tareas::create([
            'proyecto_id' => $proyecto_id,
            'nombre' => $nombre,
            'estado' => $estado,
            'creado_por' => $creado_por,
            'descripcion' => $descripcion
        ]);
        return "SUCCESS";
    }

    /**
     * Consultar tareas
     */
    public function consultarTareas(Request $request){
        if ($request->proyecto_id) {
            $proyecto_id = $request->proyecto_id;
            $query= DB::table('tareas')->get()->where('proyecto_id',$proyecto_id);
            return $query;
        }
        else {
            return "NO ID";
        }
    }

    /**
     * Actualizar tareas
     */
    public function actualizar(Request $request){
        $id=$request->id;
        $nombre = $request->nombre;
        $estado = $request->estado;
        $descripcion = $request->descripcion;
        $affected = DB::table('tareas')
            ->where('id', $id)
            ->update(['nombre' => $nombre, 'estado'=>$estado, 'descripcion'=>$descripcion]);
        return "SUCCESS";
    }

    /**
     * Eliminar tarea
     */
    public function eliminar(Request $request){
        $id = $request->id;
        $query= DB::table('tareas')->where('id', $id)->delete();
        return "SUCCESS";
    }
}
