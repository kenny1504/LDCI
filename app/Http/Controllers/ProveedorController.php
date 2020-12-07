<?php

namespace App\Http\Controllers;

use App\ProveedorModel;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function getProveedores()
    {
        $datos = (new ProveedorModel)->getProveedores();
        return response()->json($datos);
    }
    public function getPaises()
    {
        $datos = (new ProveedorModel)->getPaises();
        return response()->json($datos);
    }
    /** Funcion para actualizar/guardar un proveedor */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_proveedor = $request->id_proveedor;
        $nombre = $request->nombre;
        $correo = $request->correo;
        $direccion = $request->direccion;
        $pais = $request->pais;
        $pagina_web = $request->pagina_web;
        $telefono_1 = $request->telefono_1;
        $telefono_2 = $request->telefono_2;
        $iso = $request->iso;
        $iso2 = $request->iso2;

        $id_session = session('idUsuario');

        $existe = (new ProveedorModel)->existe($correo, $id_proveedor);

        if (!$existe) {
            if (empty($id_proveedor)) {
                $guardar = (new ProveedorModel)->guardar($nombre, $correo, $direccion, $pais, $pagina_web, $telefono_1, $telefono_2, $iso, $iso2, $id_session);
                return $guardar;
            } else {
                $guardar = (new ProveedorModel)->actualizar($id_proveedor, $nombre, $correo, $direccion, $pais, $pagina_web, $telefono_1, $telefono_2, $iso, $iso2, $id_session);
                return $guardar;
            }
        } else
            return collect([
                'mensaje' => 'Ya existe un registro con el correo ingresado',
                'error' => true,
            ]);
    }

    /** Funcion para eliminar un proveedor */
    public  function eliminar(Request $request)
    {
        $id_proveedor = $request->id_proveedor;
        $id_session = session('idUsuario');

        $guardar = (new ProveedorModel)->eliminar($id_proveedor, $id_session);
        return $guardar;
    }

    public  function getDatosProveedor(Request $request)
    {
        $id_proveedor = $request->id_proveedor;
        $datos = (new ProveedorModel)->getDatosProveedor($id_proveedor);
        return response()->json($datos);
    }
}
