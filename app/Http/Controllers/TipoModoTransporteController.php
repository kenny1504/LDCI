<?php

namespace App\Http\Controllers;

use App\TipoModoTransporteModel;
use Illuminate\Http\Request;

class TipoModoTransporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   /** Funcion que recupera todos los registro de tipo modo transporte*/
   public function getTipoModoTransporte()
   {
       $datos= (new TipoModoTransporteModel)->getTipoModoTransporte();
       return response()->json($datos);

   }

    /** Metodo para guardar o actualizar un tipo modo transporte */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_TipoModoTransporte= $request->id_TipoModoTransporte;
        $nombre=$request->nombre;
        $id_session = session('idUsuario');

                $existe=(new TipoModoTransporteModel)->existe($nombre);

        if(!$existe)
        {
            $guardar=(new TipoModoTransporteModel)->guardarTipoModoTransporte($id_TipoModoTransporte,strtoupper($nombre),$id_session);
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
                'mensaje' => 'El Tipo Modo Transporte ya existe',
                'error' => true,
            ]);
    }

    /** Metodo para eliminar un tipo modo transporte */
    public function eliminar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_TipoModoTransporte = $request->id_TipoModoTransporte;
        $id_session = session('idUsuario');

        $guardar = (new TipoModoTransporteModel)->eliminar($id_TipoModoTransporte,$id_session);
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
