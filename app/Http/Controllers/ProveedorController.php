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

    /** Funcion para actualizar/guardar un proveedor */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_proveedor = $request->id_proveedor;
        $nombres = $request->nombres;
        $apellido1 = $request->apellido1;
        $apellido2 = $request->apellido2;
        $cedula = $request->cedula;
        $direccion = $request->direccion;
        $departamento = $request->departamento;
        $telefono_1 = $request->telefono_1;
        $telefono_2 = $request->telefono_2;
        $edad = $request->edad;
        $correo = $request->correo;
        $sexo = $request->sexo;
        $iso = $request->iso;
        $iso2 = $request->iso2;


        $id_session = session('idUsuario');

        $existe = (new ProveedorModel)->existe($cedula, $id_proveedor);

        if (!$existe) {
            if (empty($id_proveedor)) {
                $guardar = (new ProveedorModel)->guardar($nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $edad, $correo, $sexo, $iso, $iso2, $id_session);
                return $guardar;
            } else {
                $guardar = (new ProveedorModel)->actualizar($id_proveedor, $nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $edad, $correo, $sexo, $iso, $iso2, $id_session);
                return $guardar;
            }
        } else
            return collect([
                'mensaje' => 'Ya existe un registro con la cedula proporcionada',
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
