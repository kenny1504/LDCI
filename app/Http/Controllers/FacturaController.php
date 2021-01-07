<?php

namespace App\Http\Controllers;
use App\FacturaModel;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /** funcion que recupera cotizaciones para llenar tabla */
    public function getCotizaciones(Request $request)
    {

        $tipoUsuario = session('tipoUsuario');
        $id_session = session('idUsuario');

        $datos= (new FacturaModel)->getCotizaciones($tipoUsuario,$id_session);
        return response()->json($datos);
    }

}
