<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoMercanciaModel;

class TipoMercanciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTipoMercancia()
    {
        $datos= (new TipoMercanciaModel)->getTipoMercancia();
        return response()->json($datos);

    }

    /** Metodo para guardar o actualizar un tipo de mercancia */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_TipoMercancia= $request->id_TipoMercancia;
        $nombre=$request->nombre;
        $id_session = session('idUsuario');

                $existe=(new TipoMercanciaModel)->existe($nombre);

        if(!$existe)
        {
            $guardar=(new TipoMercanciaModel)->guardarTipoMercancia($id_TipoMercancia,strtoupper($nombre),$id_session);
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
                'mensaje' => 'El Tipo de Mercancia ya existe',
                'error' => true,
            ]);
    }

    /** Metodo para eliminar un tipo de mercancia */
    public function eliminar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_TipoMercancia = $request->id_TipoMercancia;
        $id_session = session('idUsuario');

        $guardar = (new TipoMercanciaModel)->eliminar($id_TipoMercancia,$id_session);
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
