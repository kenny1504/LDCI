<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CotizacionModel extends Model
{
    /** Funcion que recupera todos las ciudades*/
    function getCiudades()
    {
        $query = new static;
        $query = DB::select("select id_ciudad,(ciudad ||','||pais) as ciudad from ldci.vw_ciudades");
        return $query;
    }

    /** Funcion que recupera todos los tipos de transporte*/
    function getTrasnporte()
    {
        $query = new static;
        $query = DB::select('select id_tipo_transporte,nombre from ldci.tb_tipo_transporte where estado=1');
        return $query;
    }

    /** Funcion que recupera todos los modo transporte*/
    function getModoTransporte()
    {
        $query = new static;
        $query = DB::select('select id_tipo_modo_transporte,nombre from ldci.tb_tipo_modo_transporte where estado=1');
        return $query;
    }

    /** Funcion que recupera todos los tipos de mercancia*/
    function getTipoMercancia()
    {
        $query = new static;
        $query = DB::select('select id_tipo_mercancia,nombre from ldci.tb_tipo_mercancia where estado=1');
        return $query;
    }

    /** Funcion que recupera todos los servicios*/
    function getServicios()
    {
        $query = new static;
        $query = DB::select('select id_producto,nombre from ldci.tb_producto where tipo=2 and estado=1');
        return $query;
    }

    function  guardarCotizacion($tblDetalleCarga,$tblDetalleServicios,$tipo_transporte,$fecha,$destino,$origen,$nota_adicional,$id_session)
    {
        DB::beginTransaction();
        $transaccionOk = true;
        $query_encabezado = new static;
        $query_encabezado = DB::select('INSERT INTO ldci.tb_cotizacion(
                     id_ciudad_destino, id_ciudad_origen, fecha, nota, id_tipo_transporte, usuario_grabacion, fecha_grabacion)
                    VALUES ( ?, ?, ?, ?, ?, ?, now()) RETURNING id_cotizacion', [$destino,$origen,$fecha,$nota_adicional,$tipo_transporte,$id_session]);


        if (empty($query_encabezado))
        {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar cotizacion',
                'error' => true
            ]);
        }
        else {

            foreach ($tblDetalleCarga as $carga)
            {
                $query_detalle = new static;
                $query_detalle = DB::insert('INSERT INTO ldci.tb_detalle_cotizacion(
                descripcion, cantidad, nuevo, id_cotizacion,
                id_tipo_mercancia, id_tipo_modo_transporte,  usuario_grabacion, fecha_grabacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, now())', [$carga->observacion,$carga->Cantidad,$carga->estado,$query_encabezado[0]->id_cotizacion,$carga->id_tipo_mercancia,$carga->id_modo_transporte,$id_session]);
                if (!$query_detalle)
                {
                    $transaccionOk = false;
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al guardar detalle de carga',
                        'error' => true
                    ]);
                }
            }

            if ($transaccionOk)
            {
                foreach ($tblDetalleServicios as $servicio)
                {

                    $query_detalle = new static;
                    $query_detalle = DB::insert('INSERT INTO ldci.tb_detalle_cotizacion(
                     id_cotizacion, id_producto,  usuario_grabacion, fecha_grabacion)
                    VALUES (?, ?, ?, now())', [$query_encabezado[0]->id_cotizacion,$servicio->id_servicio,$id_session]);

                    if (!$query_detalle)
                    {
                        $transaccionOk = false;
                        DB::rollBack();
                        return collect([
                            'mensaje' => 'Hubo un error al guardar servicios adicionales',
                            'error' => true
                        ]);
                    }
                }
                    DB::commit();
                    return collect([
                        'mensaje' => 'Cotizacion guardada con exito',
                        'error' => false,
                    ]);
            }
        }
    }

}
