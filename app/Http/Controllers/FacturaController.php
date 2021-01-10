<?php

namespace App\Http\Controllers;
use App\CotizacionModel;
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

    /** Funcion que recupera encabezado de cotizacion*/
    public function getEncabezadoCotizacion(Request $request)
    {
        $id_cotizacion=$request->id_cotizacion;
        $datos= (new FacturaModel)->getEncabezado($id_cotizacion);
        return response()->json($datos);
    }

    public function generarFacturaCotizacion(Request $request)
    {
        $tblDetalleCargos= json_decode($request->tblDetalleCargos);
        $termino=$request->termino;
        $tipo=$request->tipo;
        $id_cotizacion=$request->id_cotizacion;
        $id_flete=$request->id_flete;
        $codigoFactura=$request->codigoFactura;
        $descuento=$request->descuento;
        $total=$request->total;
        $micelaneos=$request->micelaneos;
        $moneda=$request->moneda;
        $id_session = session('idUsuario');

        $guardar=(new FacturaModel)->guardarFacturaCotizacion($tblDetalleCargos,$termino,$tipo,$id_flete,$codigoFactura,$descuento,$total,$micelaneos,$moneda,$id_session);

        if (!json_decode($guardar)->error) {

            $actualizar=(new CotizacionModel)->CambiarEstadoCotizacion($id_cotizacion,'',5,$id_session);

        }
        return $guardar;

    }

    public function validaNoFactura(Request $request)
    {
        $codigoFactura=$request->codigoFactura;
        $datos= (new FacturaModel)->getNoFactura($codigoFactura);
        return response()->json($datos);

    }

    /** funcion que recupera registros de factura para llenar tabla */
    public function getFacturas()
    {
        $tipoUsuario = session('tipoUsuario');
        $id_session = session('idUsuario');

        $datos= (new FacturaModel)->getFacturas($tipoUsuario,$id_session);
        return response()->json($datos);
    }

    /** Funcion que recupera todos los productos*/
    public function getProductos()
    {
        $datos = (new FacturaModel)->getProductos();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los clientes*/
    public function getClientes()
    {
        $datos = (new FacturaModel)->getClientes();
        return response()->json($datos);
    }

    /** Funcion para recuperar lista de ventas*/
    public function getVentas()
    {
        $datos = (new FacturaModel)->getVentas();
        return response()->json($datos);
    }

    /** Funcion para recuperar precio de un producto*/
    public function getPrecio(Request $request)
    {
        $id_producto=$request->id_producto;
        $datos = (new FacturaModel)->getPrecio($id_producto);
        return response()->json($datos);
    }

}
