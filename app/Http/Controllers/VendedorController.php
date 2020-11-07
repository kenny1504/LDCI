<?php

namespace App\Http\Controllers;

use App\VendedorModel;
use Illuminate\Http\Request;

class VendedorController extends Controller
{

    /** Funcion que recupera todos los departamentos del pais*/
    public function getDepartamentos()
    {
        $datos= (new VendedorModel)->getDepartamentos();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los vendedores*/
    public function getVendedores()
    {
        $datos= (new VendedorModel)->getVendedores();
        return response()->json($datos);

    }


}
