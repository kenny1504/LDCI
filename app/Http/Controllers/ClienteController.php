<?php

namespace App\Http\Controllers;
use App\ClienteModel;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /** Funcion para actualizar/guardar un cliente*/
    public function guardar(Request $request)
    {
        /** Recupera parametros enviados por ajax */
        $id_cliente= $request->id_cliente;
        $giro_Negocio= $request->giro_Negocio;
        $nombre_Empresa= $request->nombre_Empresa;
        $ruc= $request->ruc;
        $nombres=$request->nombres;
        $apellido1=$request->apellido1;
        $apellido2=$request->apellido2;
        $cedula=$request->cedula;
        $direccion=$request->direccion;
        $departamento=$request->departamento;
        $telefono_1=$request->telefono_1;
        $telefono_2=$request->telefono_2;
        $edad=$request->edad;
        $correo=$request->correo;
        $sexo=$request->sexo;
        $tipo=$request->tipo;
        $iso2=$request->iso2;
        $iso=$request->iso;


        $id_session = session('idUsuario');

        $existe= (new ClienteModel)->existe($cedula,$ruc,$id_cliente);

        if(!$existe)
        {
            if (empty($id_cliente))
            {
                $guardar= (new ClienteModel)->guardar($giro_Negocio,$nombre_Empresa,$ruc,$nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$edad,$correo,$sexo,$tipo,$id_session,$iso2,$iso);
                return $guardar;
            }
            else
            {
                $guardar= (new ClienteModel)->actualizar($id_cliente,$giro_Negocio,$nombre_Empresa,$ruc,$nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$correo,$sexo,$tipo,$id_session,$iso2,$iso);
                return $guardar;
            }
        }
        else
            return collect([
                'mensaje' => 'Ya existe un registro con la cedula y/o Ruc proporcionado',
                'error' => true,
            ]);

    }

    /** Funcion que recupera todos los clientes*/
    public function getClientes()
    {
        $datos= (new ClienteModel)->getClientes();
        return response()->json($datos);

    }

    public  function getDatosCliente(Request $request)
    {
        $id_cliente= $request->id_cliente;

        $datos= (new ClienteModel)->getDatosCliente($id_cliente);
        return response()->json($datos);

    }

    /** Funcion para eliminar un cliente */
    public  function eliminar(Request $request)
    {
        $id_cliente= $request->id_cliente;
        $id_session = session('idUsuario');

        $guardar= (new ClienteModel)->eliminar($id_cliente,$id_session);
        return $guardar;

    }

}
