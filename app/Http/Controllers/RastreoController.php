<?php

namespace App\Http\Controllers;

use App\RastreoModel;
use Illuminate\Http\Request;


class RastreoController extends Controller
{
    //funcion para listar cotizacion en estado tramite
    function getCotizaciones()
    {
        $tipoUsuario = session('tipoUsuario');
        $id_session = session('idUsuario');
        $datos = (new RastreoModel)->getCotizaciones($tipoUsuario, $id_session);
        return response()->json($datos);
    }

    //funcion para cargar el detalle de seguimiento de cotizacion
    function getDetalleSeguimiento(Request $request)
    {
        $id_flete = $request->id_flete;
        $datos = (new RastreoModel)->getDetalleSeguimiento($id_flete);
        return response()->json($datos);
    }

    //** funcion para guardar rastreo sin imagen */
    function guardarRastreoSI(Request $request)
    {
        $tblRastreo = json_decode($request->tblRastreo); //sin imagen
        $id_fleteR = $request->id_flete; //sin imagen
        $id_session = session('idUsuario');

        $guardar_rastreo_s = (new RastreoModel)->guardarRastreoSImagen($id_fleteR, $tblRastreo, $id_session);
        return $guardar_rastreo_s;
    }
    //Funcion rastreo
    function guardarRastreo(Request $request)
    {

        $fecha = $request->fecha_evento;
        $evento = $request->txt_evento;
        $descripcion = $request->txt_descripcion_evento;
        $id_detalle_seguimiento = $request->id_detalle;
        $id_flete = $request->id_flete;
        $image = $request->file('file');
        $id_session = session('idUsuario');

        $guardar_rastreo = (new RastreoModel)->guardarRastreo($id_flete, $fecha, $evento, $descripcion, $id_detalle_seguimiento, $id_session);
        if (!empty($guardar_rastreo)) {
            /** Recorre Arreglo de imagenes */
            foreach ($image as $imagen) {

                $imageName = uniqid() . '.' . $imagen->extension();
                $url = '/images/rastreo'; //Ruta donde guarda imagenes de rastreo
                $imagen->move(public_path('images/rastreo'), $imageName, 0777, true); //Guarda imagen en servidor

                $guardarImagen = (new RastreoModel)->guardarImagenRastreo($id_flete, $url, $imageName, $id_session);
            }
            return collect([
                'mensaje' => 'Detalle de Rastreo Actualizado con exito!',
                'error' => false,
            ]);
        } else {
            return collect([
                'mensaje' => 'Error al guardar imagen',
                'error' => true,
            ]);
        }
    }

    //** Funcion para obtener imagenes de rastreo */
    function getImagen(Request $request)
    {
        $id_flete = $request->id_flete;

        $datos = (new RastreoModel)->getImagen($id_flete);
        return $datos;
    }

    /** Elimina imagen de rastreo */
    function  eliminarImagen(Request $request)
    {
        $imagen = $request->imagen;
        $existe = (new RastreoModel)->existeImagen($imagen);

        if ($existe) {
            $eliminar = (new RastreoModel)->eliminarImagen($imagen);
            if ($eliminar) {
                /** Elimina imagen del servidor */
                unlink(public_path('images/rastreo/' . $imagen));

                return collect([
                    'mensaje' => 'Imagen eliminada con exito!',
                    'error' => false,
                ]);
            } else {
                return collect([
                    'mensaje' => 'Error al eliminar imagen',
                    'error' => true,
                ]);
            }
        }
        return collect([
            'mensaje' => '',
            'error' => false,
        ]);
    }

    /** Recupera imagenes de un rastreo  para vista cliente*/
    function  getRastreoImagenes(Request $request)
    {
        $id_flete = $request->id_flete;

        $datos = (new RastreoModel)->getRastreoImagenes($id_flete);
        return $datos;
        var_dump($datos);
    }

    /** Funcion para eliminar un evento de un rastreo */
    function eliminarEvento(Request $request)
    {
        $id_detalle = $request->id_detalle;
        $id_session = session('idUsuario');
        $guardar = (new RastreoModel)->eliminar($id_detalle, $id_session);
        if (!empty($guardar)) {
            return collect([
                'mensaje' => 'Evento eliminado exitosamente!',
                'error' => false
            ]);
        } else
            return collect([
                'mensaje' => 'Error al eliminar evento',
                'error' => true,
            ]);
    }

    /** Funcion para obtener fecha de llegada */
    function fechaRastreo(Request $request)
    {
        $id_rastreo = $request->id_flete;
        $fecha = (new RastreoModel)->fechaRastreo($id_rastreo);
        return $fecha;
    }
}
