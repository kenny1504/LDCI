<?php

namespace App\Http\Controllers;

use Mail;
use App\CotizacionModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class CotizacionController extends Controller
{
    /** Funcion que recupera todos las ciudades*/
    public function getCiudades()
    {
        $datos = (new CotizacionModel)->getCiudades();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los tipos de transporte*/
    public function getTransporte()
    {
        $datos = (new CotizacionModel)->getTrasnporte();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los tipos de mercancia*/
    public function getTipoMercancia()
    {
        $datos = (new CotizacionModel)->getTipoMercancia();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los modo transporte*/
    public function getModoTransporte()
    {
        $datos = (new CotizacionModel)->getModoTransporte();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los servicios*/
    public function getServicios()
    {
        $datos = (new CotizacionModel)->getServicios();
        return response()->json($datos);
    }

    public function  guardarCotizacion(Request $request)
    {

        $tblDetalleCarga = json_decode($request->tblDetalleCarga);
        $tblDetalleServicios = json_decode($request->tblDetalleServicios);
        $tipo_transporte = $request->tipo_transporte;
        $fecha = $request->fecha;
        $destino = $request->destino;
        $origen = $request->origen;
        $nota_adicional = $request->nota_adicional;
        $id_session = session('idUsuario');
        $nombreUsuario = session('nombreUsuario');

        $guardar = (new CotizacionModel)->guardarCotizacion($tblDetalleCarga, $tblDetalleServicios, $tipo_transporte, $fecha, $destino, $origen, $nota_adicional, $id_session);

        if (!json_decode($guardar)->error) {
            $administradores = (new CotizacionModel)->correos();

            foreach ($administradores as $admin) {
                $data['No_cotizacion'] = json_decode($guardar)->cotizacion;
                $data['name'] = $nombreUsuario;

                /**  Inicio funcion para enviar correo  */
                $subject = "Nueva Cotizacion";
                /** Asunto del Correo */
                $for = $admin->correo;
                /** correo que recibira el mensaje */

                Mail::send('cotizacion.mailNuevaCotizacion', $data, function ($msj) use ($subject, $for) {
                    // Correo  y  Nombre que Aparecera
                    $msj->from("system@cargologisticsintermodal.com", "LOGISTICA DE CARGA INTERMODAL");
                    $msj->subject($subject);
                    $msj->to($for);
                });
            }
        }
        return $guardar;
    }

    /** funcion que recupera cotizaciones para llenar tabla */
    public function getCotizaciones(Request $request)
    {

        $estado = $request->estado;
        $tipoUsuario = session('tipoUsuario');
        $id_session = session('idUsuario');

        $datos = (new CotizacionModel)->getCotizaciones($estado, $tipoUsuario, $id_session);
        return response()->json($datos);
    }

    /** Funcion que recupera todos los usuarios tipo vendedor*/
    public function getVendedores()
    {
        $datos = (new CotizacionModel)->getVendedores();
        return response()->json($datos);
    }

    /** Funcion que asigna cotizacion a vendedor */
    public  function setcotizacion(Request $request)
    {

        $id_vendedor = $request->id_vendedor;
        $id_cotizacion = $request->id_cotizacion;
        $asignada = $request->asignada;
        $id_session = session('idUsuario');

        /** Recuepera datos del vendedor*/
        $vendedor = (new CotizacionModel)->getVendedor($id_vendedor);

        $guardar = (new CotizacionModel)->setcotizacion($id_vendedor, $id_cotizacion, $asignada, $id_session);


        if (!json_decode($guardar)->error) {

            $data['name'] = $vendedor[0]->usuario;
            $data['No_cotizacion'] = $id_cotizacion;

            /**  Inicio funcion para enviar correo  */
            $subject = "Nueva Cotizacion";
            /** Asunto del Correo */
            $for = $vendedor[0]->correo;
            /** correo que recibira el mensaje */

            Mail::send('cotizacion.mailAsignaCotizacion', $data, function ($msj) use ($subject, $for) {
                // Correo  y  Nombre que Aparecera
                $msj->from("system@cargologisticsintermodal.com", "LOGISTICA DE CARGA INTERMODAL");
                $msj->subject($subject);
                $msj->to($for);
            });
        }
        return $guardar;
    }

    /** Funcion para buscar si existe una asigancion a una cotizacion*/
    public function getAsignacion(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $datos = (new CotizacionModel)->getAsignacion($id_cotizacion);
        return response()->json($datos);
    }

    /** Funcion que recupera encabezado de cotizacion*/
    public function getEncabezado(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $datos = (new CotizacionModel)->getEncabezado($id_cotizacion);
        return response()->json($datos);
    }

    /** Funcion que recupera detalles de carga*/
    public function getDetalleCarga(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $datos = (new CotizacionModel)->getDetalleCarga($id_cotizacion);
        return response()->json($datos);
    }

    /** Funcion que recupera detalles servicio*/
    public function getDetalleServicio(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $datos = (new CotizacionModel)->getDetalleServicio($id_cotizacion);
        return response()->json($datos);
    }

    /** Funcion que recupera si el servicio cobra iva*/
    public function getServicioIva(Request $request)
    {
        $id_servicio = $request->id_servicio;
        $datos = (new CotizacionModel)->getServicioIva($id_servicio);
        return response()->json($datos);
    }

    public  function ActualizarCotizacion(Request $request)
    {

        $tblDetalleCarga = json_decode($request->tblDetalleCarga);
        $tblDetalleServicios = json_decode($request->tblDetalleServicios);
        $nota_interna = $request->nota_interna;
        $nota_adicional = $request->nota_adicional;
        $estado = $request->estado;
        $id_cotizacion = $request->id_cotizacion;
        $correo = $request->correo;
        $total = $request->total;
        $iva = $request->iva;
        $id_session = session('idUsuario');

        (new CotizacionModel)->deleteDetalle($id_cotizacion);
        /** Elimina Detalle de cotizacion*/
        $guardar = (new CotizacionModel)->actualizarCotizacion($tblDetalleCarga, $tblDetalleServicios, $nota_interna, $nota_adicional, $estado, $id_cotizacion, $total, $iva, $id_session);

        /** Envia Cotizacion al correo proporsionado */
        if ($correo != "" || $correo != null) {
            /** Datos de la cotizacion */
            $datos = (new CotizacionModel)->getDatosCotizacion($id_cotizacion);
            $detalle = (new CotizacionModel)->getDetalleCotizacion($id_cotizacion);
            $data = ['Informacion' => $datos];
            $detalle = ['Detalle' => $detalle];

            $pdf = PDF::loadView('reportes.rpt_nueva_cotizacion', $data, $detalle)->setPaper('a4');

            $dataEmail['No_cotizacion'] = $id_cotizacion;

            /**  Inicio funcion para enviar correo  */
            $subject = "Cotizacion";
            /** Asunto del Correo */
            $for = $correo;
            /** correo que recibira el mensaje */

            Mail::send('cotizacion.mailRespuestaCotizacion', $dataEmail, function ($msj) use ($subject, $for, $pdf) {
                // Correo  y  Nombre que Aparecera
                $msj->from("system@cargologisticsintermodal.com", "LOGISTICA DE CARGA INTERMODAL");
                $msj->subject($subject);
                $msj->to($for);
                $msj->attachData($pdf->output(), 'Cotizacion.pdf');
            });
        }
        return $guardar;
    }

    public function  RechazarCotizacion(Request $request)
    {
        $id_cotizacion = $request->id_cotizacion;
        $descripcion = $request->nota_interna;
        $estado = $request->estado;
        $id_session = session('idUsuario');

        $actualizar = (new CotizacionModel)->CambiarEstadoCotizacion($id_cotizacion, $descripcion, $estado, $id_session);

        return $actualizar;
    }
}
