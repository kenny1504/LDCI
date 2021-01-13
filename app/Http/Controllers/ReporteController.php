<?php

namespace App\Http\Controllers;

use App\VendedorModel;
use App\ProductoModel;
use App\ClienteModel;
use App\FacturaModel;
use App\CotizacionModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{
    /** Funcion para generar reporte total de vendedores*/
    public function downloadVendedores()
    {
        $tipo_usuario = session('tipoUsuario');

        /** Valida que este logueado un usuario administrador */
        if ($tipo_usuario == 1) {
            $datos = (new VendedorModel)->getDatosVendedores();
            $data = [
                'vendedores' => $datos
            ];

            $pdf = PDF::loadView('reportes.rpt_vendedores', $data)->setPaper('a4', 'landscape');
            echo utf8_encode(($pdf->stream('archivo.pdf')));
        } else {
            return view('inicio');
        }
    }

    /** Funcion para generar reporte de productos*/
    public function downloadProductos()
    {
        $tipo_usuario = session('tipoUsuario');

        /** Valida que este logueado un usuario administrador */
        if ($tipo_usuario == 1) {
            $datos = (new ProductoModel)->getDatosProductos();
            $data = [
                'productos' => $datos
            ];

            $pdf = PDF::loadView('reportes.rpt_productos', $data)->setPaper('a4');
            echo utf8_encode(($pdf->stream('archivo.pdf')));
        } else {
            return view('inicio');
        }
    }

    /** Funcion para generar reporte total de clientes*/
    public function downloadClientes()
    {
        $tipo_usuario = session('tipoUsuario');

        /** Valida que este logueado un usuario administrador */
        if ($tipo_usuario == 1) {
            $datos = (new ClienteModel)->getDatosClientes();
            $data = [
                'clientes' => $datos
            ];

            $pdf = PDF::loadView('reportes.rpt_clientes', $data)->setPaper('a4', 'landscape');
            echo utf8_encode(($pdf->stream('archivo.pdf')));
        } else {
            return view('inicio');
        }
    }

    /** Funcion para generar reporte cotizacion*/
    public function downloadCotizacion(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;

            $datos = (new CotizacionModel)->getDatosCotizacion($id_cotizacion);
            $detalle = (new CotizacionModel)->getDetalleCotizacion($id_cotizacion);
            $data = [
                'Informacion' => $datos
            ];
            $detalle = [
                'Detalle' => $detalle
            ];

            $pdf = PDF::loadView('reportes.rpt_nueva_cotizacion', $data, $detalle)->setPaper('a4');
            echo utf8_encode(($pdf->stream('archivo.pdf')));

    }

    /** Funcion para generar factura de una cotizacion*/
    public function downloadFacturaCotizacion(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $codConsig = $request->codConsig;
        $codCliente = $request->codCliente;

        $datos = (new FacturaModel)->getDatosFacturaCotizacion($id_cotizacion);
        $detalle = (new FacturaModel)->getDetalleCotizacion($id_cotizacion);

        $data = [
            'Informacion' => $datos,
            'Detalle' => $detalle,
            'Consig' => $codConsig,
            'codCliente' => $codCliente,
        ];


        $pdf = PDF::loadView('reportes.rpt_factura', $data)->setPaper('a4');
        echo utf8_encode(($pdf->stream('archivo.pdf')));

    }

    /** Funcion para generar factura de una venta directa*/
    public function downloadFacturaProductos(Request $request)
    {
        $codigoFactura = $request->codigoFactura;

        $datos = (new FacturaModel)->getDatosFacturaProductos($codigoFactura);
        $detalle = (new FacturaModel)->getDetalleFactura($codigoFactura);

        $data = [
            'Informacion' => $datos,
             'Detalle' => $detalle,
        ];


        $pdf = PDF::loadView('reportes.rpt_factura_productos', $data)->setPaper('a4');
        echo utf8_encode(($pdf->stream('archivo.pdf')));

    }

}
