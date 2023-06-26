<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Obtener datos del usuario loggeado
     */
    public function usuarioLoggeado(Request $request){
        $id = Auth::id();
        $query= DB::table('users')->get()->where('id',$id);
        return $query[$id-1]->role;
    }

    /**
     * Obtener lista de usuarios
     */
    public function listaUsuarios(Request $request){
        $id = Auth::id();
        $query= DB::table('users')->get();
        return $query;
    }

    /**
     * Editar usuario
     */
    public function editarUsuarios(Request $request){
        $id = $request->id;
        $role = $request->role;
        $affected = DB::table('users')
            ->where('id', $id)
            ->update(['role' => $role]);
        return "SUCCESS";
    }

    /**
     * Eliminar usuario
     */
    public function eliminarUsuario(Request $request){

    }
}
