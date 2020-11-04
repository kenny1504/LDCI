<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoTransporteModel;

class TipoTransporteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /** Funcion que recupera todos los registro de tipo de transporte*/
    public function getTipoTransporte()
    {
        $datos= (new TipoTransporteModel)->getTipoTransporte();
        return response()->json($datos);

    }

    /** Metodo para guardar o actualizar un tipo de transporte */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_TipoTransporte= $request->id_TipoTransporte;
        $nombre=$request->nombre;
        $id_session = session('idUsuario');

                $existe=(new TipoTransporteModel)->existe($nombre);

        if(!$existe)
        {
            $guardar=(new TipoTransporteModel)->guardarTipoTransporte($id_TipoTransporte,strtoupper($nombre),$id_session);
            if (!empty($guardar))
            {
                return collect([
                    'mensaje' => 'Registro guardado exitosamente!',
                    'error' => false
                ]);
            }
            else
                return collect([
                    'mensaje' => 'Error al guardar registro',
                    'error' => true,
                ]);
        }
        else
            return collect([
                'mensaje' => 'El Tipo Transporte ya existe',
                'error' => true,
            ]);
    }

    /** Metodo para eliminar un tipo de transporte */
    public function eliminar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_TipoTransporte = $request->id_TipoTransporte;
        $id_session = session('idUsuario');

        $guardar = (new TipoTransporteModel)->eliminar($id_TipoTransporte,$id_session);
        if (!empty($guardar)) {
            return collect([
                'mensaje' => 'Registro eliminado exitosamente!',
                'error' => false
            ]);
        } else
            return collect([
                'mensaje' => 'Error al eliminar registro',
                'error' => true,
            ]);
    }

}
