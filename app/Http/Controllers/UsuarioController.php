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
    private $db;

    function __construct() {
      $db = array(
         'host' =>$_ENV['DB_HOST'],
         'db' => $_ENV['DB_DATABASE'],
         'user' => $_ENV['DB_USERNAME'],
         'pass' => $_ENV['DB_PASSWORD']
     );
    }

    public function index()
    {
        $nombreUsuario = session('nombreUsuario'); /** recupera nombre del usuario en session */
          if(!empty($nombreUsuario))
          return view('usuario.index')->with('nombre', $nombreUsuario);
         else
           return view('inicio');
    }


}
