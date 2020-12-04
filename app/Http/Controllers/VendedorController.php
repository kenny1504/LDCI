<?php

namespace App\Http\Controllers;
use App\VendedorModel;
use Illuminate\Http\Request;

class VendedorController extends Controller
{

    /** Funcion que recupera todos los departamentos del pais*/
    public function getDepartamentos()
    {
        $datos= (new VendedorModel)->getDepartamentos();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los vendedores*/
    public function getVendedores()
    {
        $datos= (new VendedorModel)->getVendedores();
        return response()->json($datos);

    }

    /** Funcion para actualizar/guardar un vendedor */
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_empleado= $request->id_empleado;
        $nombres=$request->nombres;
        $apellido1=$request->apellido1;
        $apellido2=$request->apellido2;
        $cedula=$request->cedula;
        $direccion=$request->direccion;
        $departamento=$request->departamento;
        $telefono_1=$request->telefono_1;
        $telefono_2=$request->telefono_2;
        $nomb_notifica=$request->nomb_notifica;
        $estado_civil=$request->estado_civil;
        $telefono_not=$request->telefono_not;
        $edad=$request->edad;
        $correo=$request->correo;
        $sexo=$request->sexo;


        $id_session = session('idUsuario');

        $existe= (new VendedorModel)->existe($cedula,$id_empleado);

        if(!$existe)
        {
            if (empty($id_empleado))
            {
                $guardar= (new VendedorModel)->guardar($nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$nomb_notifica,$estado_civil,$telefono_not,$edad,$correo,$sexo,$id_session);
                return $guardar;
            }
            else
            {
                $guardar= (new VendedorModel)->actualizar($id_empleado,$nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$nomb_notifica,$estado_civil,$telefono_not,$edad,$correo,$sexo,$id_session);
                return $guardar;
            }
        }
        else
            return collect([
            'mensaje' => 'Ya existe un registro con la cedula proporcionada',
            'error' => true,
            ]);


    }

    /** Funcion para eliminar un vendedor */
    public  function eliminar(Request $request)
    {
        $id_empleado= $request->id_empleado;
        $id_session = session('idUsuario');

        $guardar= (new VendedorModel)->eliminar($id_empleado,$id_session);
        return $guardar;

    }

    public  function getDatosVendedor(Request $request)
    {
        $id_vendedor= $request->id_vendedor;

        $datos= (new VendedorModel)->getDatosVendedor($id_vendedor);
        return response()->json($datos);

    }

}
