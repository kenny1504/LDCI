<?php

namespace App\Http\Controllers;
use App\usuarioModel;

use Illuminate\Http\Request;
use App\http\Requests;

class inicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
       return view('inicio');
    }

    public function inicio()
    {
       $nombreUsuario = session('nombreUsuario'); /** recupera nombre del usuario en session */
      /** revuelve vista y nombre del suuario logueado */
       return view('theme\bracket\layout')->with('nombre', $nombreUsuario);;
    }
    
    public function login(Request $request)
    {

        /** Recupera parametros enviados por ajax */
       $password= $request->password;
       $user= $request->user;
       /** Llama metodo del modelo Usuario */
       $query = (new usuarioModel)->GetUsuario($password,$user);
        
        if(isset($query))
         {
            /** iniciamos variables de session con valores recuperados de la consulta */
            session(['idUsuario' =>($query[0]->id_usuario) ]);
            session(['nombreUsuario' =>($query[0]->nombre) ]);
            return response()->json(1);
         }else
         {
            return response()->json(0); /** si es usuario no existe o esta eliminado */
         } 
         

    }

}
