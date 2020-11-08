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


        $id_session = session('idUsuario');

        $existe= (new VendedorModel)->existe($cedula);

        if(!$existe)
        {
            if (empty($id_empleado))
            {
                $guardar= (new VendedorModel)->guardar($nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$nomb_notifica,$estado_civil,$telefono_not,$edad,$correo,$id_session);
                return $guardar;
            }
            else
            {
                //Actualizar
            }
        }
        else
            return collect([
            'mensaje' => 'Ya existe un registro con la cedula proporcionada',
            'error' => true,
            ]);


    }


}
