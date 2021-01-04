<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FleteModel extends Model
{


    function  guardarFlete($id_cotizacion,$id_proveedor,$fecha,$fecha_llegada,$id_remitente,$id_consignatario,
                           $nombres,$apellido1,$apellido2,$telefono,$iso2,$correo,$direccion,$id_session)
    {

        /** Guarda consignatario */
        if ($id_consignatario==null)
        {
            $query_persona = new static;
            $query_persona = DB::select('INSERT INTO ldci.tb_persona(
            nombre, apellido1, apellido2, direccion, correo, telefono_2,
            iso_2,  usuario_grabacion, fecha_grabacion)
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?,now()) RETURNING id_persona',
                [$nombres, $apellido1, $apellido2, $direccion, $correo,$telefono,$iso2, $id_session]);

            $id_consignatario=$query_persona[0]->id_persona;
        }


                $query_flete = new static;
                $query_flete = DB::insert('INSERT INTO ldci.tb_flete(
                id_cliente, id_consignatario,fecha, fecha_entrega,
                id_cotizacion, id_proveedor, usuario_grabacion, fecha_grabacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, now())',
                 [$id_remitente, $id_consignatario, $fecha, $fecha_llegada,$id_cotizacion,$id_proveedor, $id_session]);


        if ($query_flete) {
            return collect([
                'mensaje' => 'Cotizacion Actualizada Correctamente',
                'error' => false
            ]);
        } else {
            return collect([
                'mensaje' => 'Ocurrio un error al actualizar Cotizacion',
                'error' => true
            ]);
        }
    }


    /** Funcion que recupera datos de flete*/
    function getFlete($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select id_cliente,id_consignatario,id_proveedor,fecha_entrega
                                    from ldci.tb_flete where id_cotizacion=$id_cotizacion");
        return $query;
    }

    /** Funcion que recupera datos del consignatario*/
    function getConsignatario($id_consignatario)
    {
        $query = new static;
        $query = DB::select("select nombre, apellido1, apellido2, direccion, correo, telefono_2,
                                    iso_2 from ldci.tb_persona where id_persona=$id_consignatario");
        return $query;
    }


    function cambiarEstadoFlete($id_cotizacion,$id_session)
    {
        $query = new static;
        $query = DB::update ("UPDATE ldci.tb_flete
                                SET  estado=2, usuario_modificacion=$id_session, fecha_modificacion=now()
                                WHERE id_cotizacion=$id_cotizacion");
        if ($query) {
            return collect([
                'mensaje' => 'Cotizacion Actualizada Correctamente',
                'error' => false
            ]);
        } else {
            return collect([
                'mensaje' => 'Ocurrio un error al actualizar Cotizacion',
                'error' => true
            ]);
        }
    }

}
