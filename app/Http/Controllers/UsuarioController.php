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
    

     /** Retorna vista Usuarios */
    public function index()
    {
        $nombreUsuario = session('nombreUsuario'); /** recupera nombre del usuario en session */
          if(!empty($nombreUsuario))
          return view('usuario.index')->with('nombre', $nombreUsuario);
         else
           return view('inicio');
    }

    /** Funcion que recupera todos los usuarios*/
    public function getUsuarios()
    {
        $datos= (new usuarioModel)->getUsuarios();
        return response()->json($datos);
 
    }

}
