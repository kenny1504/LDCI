<?php

namespace App\Http\Controllers;
use App\CotizacionModel;
use App\FleteModel;
use Illuminate\Http\Request;


class FleteController extends Controller
{

    public function  guardarFlete(Request $request)
    {

        $id_cotizacion=$request->id_cotizacion;
        $id_proveedor=$request->id_proveedor;
        $fecha=$request->fecha;
        $fecha_llegada=$request->fecha_llegada;
        $id_remitente=$request->id_remitente;
        $estado=$request->estado;

        /** Consignatario*/
        $id_consignatario=$request->id_consignatario;
        $nombres=$request->nombresConsignatario;
        $apellido1=$request->apellido1Consignatario;
        $apellido2=$request->apellido2Consignatario;
        $telefono=$request->telefonoConsignatario;
        $iso2=$request->iso2;
        $correo=$request->correoConsignatario;
        $direccion=$request->direccionConsignatario;

        $id_session = session('idUsuario');

        $guardar=(new FleteModel())->guardarFlete($id_cotizacion,$id_proveedor,$fecha,$fecha_llegada,$id_remitente,$id_consignatario,
            $nombres,$apellido1,$apellido2,$telefono,$iso2,$correo,$direccion,$id_session);

        if (!json_decode($guardar)->error) {

            $actualizar=(new CotizacionModel)->CambiarEstadoCotizacion($id_cotizacion,'',$estado,$id_session);

        }

        return $guardar;

    }

    public function getFlete(Request $request)
    {

        $id_cotizacion=$request->id_cotizacion;
        $datos= (new FleteModel())->getFlete($id_cotizacion);
        return response()->json($datos);

    }

    public function getConsignatario(Request $request)
    {

        $id_consignatario=$request->id_consignatario;
        $datos= (new FleteModel())->getConsignatario($id_consignatario);
        return response()->json($datos);

    }

    public function cambiarEstadoFlete(Request $request)
    {
        $estado=$request->estado;
        $id_cotizacion=$request->id_cotizacion;
        $id_session = session('idUsuario');


        $guardar=(new FleteModel())->cambiarEstadoFlete($id_cotizacion,$id_session);

        if (!json_decode($guardar)->error) {

            $actualizar=(new CotizacionModel)->CambiarEstadoCotizacion($id_cotizacion,'',$estado,$id_session);

        }

        return $guardar;

    }

}
