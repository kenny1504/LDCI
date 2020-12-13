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
    public function getTransporte()
    {
        $datos= (new CotizacionModel)->getTrasnporte();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los tipos de mercancia*/
    public function getTipoMercancia()
    {
        $datos= (new CotizacionModel)->getTipoMercancia();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los modo transporte*/
    public function getModoTransporte()
    {
        $datos= (new CotizacionModel)->getModoTransporte();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los servicios*/
    public function getServicios()
    {
        $datos= (new CotizacionModel)->getServicios();
        return response()->json($datos);
    }

}
