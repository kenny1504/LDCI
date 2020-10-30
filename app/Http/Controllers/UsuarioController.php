<?php

namespace App\Http\Controllers;
use App\usuarioModel;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /** Funcion que recupera todos los usuarios*/
    public function getUsuarios()
    {
        $datos= (new usuarioModel)->getUsuarios();
        return response()->json($datos);

    }

    /** Metodo para activar o desactivar usuario */
    public function cambiarEstado(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_usuario= $request->id_usuario;
        $estado=$request->estado;
        $id_session = session('idUsuario');


        $datos= (new usuarioModel)->cambiarEstado(intval($id_session),$id_usuario,$estado);
        return response()->json($datos);

    }

}
