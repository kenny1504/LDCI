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

        $tblDetalleCarga= json_decode($request->tblDetalleCarga);
        $tblDetalleServicios=json_decode($request->tblDetalleServicios);
        $tipo_transporte=$request->tipo_transporte;
        $fecha=$request->fecha;
        $destino=$request->destino;
        $origen=$request->origen;
        $nota_adicional=$request->nota_adicional;
        $id_session = session('idUsuario');
        $nombreUsuario = session('nombreUsuario');

        $guardar=(new CotizacionModel)->guardarCotizacion($tblDetalleCarga,$tblDetalleServicios,$tipo_transporte,$fecha,$destino,$origen,$nota_adicional,$id_session);

        if (!json_decode($guardar)->error)
        {
            $administradores=(new CotizacionModel)->correos();

            foreach ($administradores as $admin)
            {
                $data['No_cotizacion']=json_decode($guardar)->cotizacion;
                $data['name']=$nombreUsuario;

                /**  Inicio funcion para enviar correo  */
                $subject ="Nueva Cotizacion"; /** Asunto del Correo */
                $for =$admin->correo;/** correo que recibira el mensaje */

                Mail::send('cotizacion.mailNuevaCotizacion',$data,function($msj) use($subject,$for){
                    // Correo  y  Nombre que Aparecera
                    $msj->from("system@cargologisticsintermodal.com","LOGISTICA DE CARGA INTERMODAL");
                    $msj->subject($subject);
                    $msj->to($for);
                });
            }
        }
        return $guardar;

    }

    /** funcion que recupera cotizaciones para llenar tabla */
    public function getCotizaciones()
    {
        $datos= (new CotizacionModel)->getCotizaciones();
        return response()->json($datos);
    }
}
