<?php

namespace App\Http\Controllers;

use App\CotizacionModel;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    /** Funcion que recupera todos las ciudades*/
    public function getCiudades()
    {
        $datos= (new CotizacionModel)->getCiudades();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los tipos de transporte*/
    public function getTrasnporte()
    {
        $datos= (new CotizacionModel)->getTrasnporte();
        return response()->json($datos);
    }

}
