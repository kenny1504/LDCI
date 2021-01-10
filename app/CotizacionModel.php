<?php

namespace App;

use App\ssp\SSP;
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

    function  guardarCotizacion($tblDetalleCarga, $tblDetalleServicios, $tipo_transporte, $fecha, $destino, $origen, $nota_adicional, $id_session)
    {
        DB::beginTransaction();
        $transaccionOk = true;
        $query_encabezado = new static;
        $query_encabezado = DB::select('INSERT INTO ldci.tb_cotizacion(
                     id_ciudad_destino, id_ciudad_origen, fecha, nota, id_tipo_transporte, usuario_grabacion, fecha_grabacion)
                    VALUES ( ?, ?, ?, ?, ?, ?, now()) RETURNING id_cotizacion', [$destino, $origen, $fecha, $nota_adicional, $tipo_transporte, $id_session]);


        if (empty($query_encabezado)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar cotizacion',
                'error' => true
            ]);
        } else {

            foreach ($tblDetalleCarga as $carga) {
                $query_detalle = new static;
                $query_detalle = DB::insert('INSERT INTO ldci.tb_detalle_cotizacion(
                descripcion, cantidad, nuevo, id_cotizacion,
                id_tipo_mercancia, id_tipo_modo_transporte,  usuario_grabacion, fecha_grabacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, now())', [$carga->observacion, $carga->Cantidad, $carga->estado, $query_encabezado[0]->id_cotizacion, $carga->id_tipo_mercancia, $carga->id_modo_transporte, $id_session]);
                if (!$query_detalle) {
                    $transaccionOk = false;
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al guardar detalle de carga',
                        'error' => true
                    ]);
                }
            }

            if ($transaccionOk) {
                foreach ($tblDetalleServicios as $servicio) {

                    $query_detalle = new static;
                    $query_detalle = DB::insert('INSERT INTO ldci.tb_detalle_cotizacion(
                     id_cotizacion, id_producto,  usuario_grabacion, fecha_grabacion)
                    VALUES (?, ?, ?, now())', [$query_encabezado[0]->id_cotizacion, $servicio->id_servicio, $id_session]);

                    if (!$query_detalle) {
                        $transaccionOk = false;
                        DB::rollBack();
                        return collect([
                            'mensaje' => 'Hubo un error al guardar servicios',
                            'error' => true
                        ]);
                    }
                }
                DB::commit();
                return collect([
                    'mensaje' => 'Cotizacion guardada con exito',
                    'error' => false,
                    'cotizacion' => $query_encabezado[0]->id_cotizacion
                ]);
            }
        }
    }

    /** Funcion para recuperar correos de usuarios administradores */
    function correos()
    {
        $query = new static;
        $query = DB::select("select trim(correo) as correo from ldci.tb_usuario where estado=1 and confirmado=true and tipo=1");
        return $query;
    }

    /** Funcion para cargar tabla cotizaciones*/
    public function getCotizaciones($estado, $tipoUsuario, $id_session)
    {
        if ($tipoUsuario == 1) {
            if ($estado != 0) {
                $table = "(select co.id_cotizacion, t.nombre as
                        transporte,c1.ciudad ||','||c1.pais as destino,
                        c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                        co.fecha_grabacion,us1.usuario as asignada
                        from ldci.tb_cotizacion co
                        join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                        join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                        join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                        join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                        left join ldci.tb_vendedor_cotizacion vc on vc.id_cotizacion=co.id_cotizacion
                        left join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                        where co.estado=$estado
                        order by co.fecha_grabacion desc) as tb ";
            } else {

                $table = "(select co.id_cotizacion, t.nombre as
                        transporte,c1.ciudad ||','||c1.pais as destino,
                        c2.ciudad ||','|| c2.pais as origen,
                        to_char(co.fecha,'DD/MM/YYYY')as fecha,
                        co.estado,us.usuario,co.fecha_grabacion,
                        us1.usuario as asignada
                    from ldci.tb_cotizacion co
                    join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                    join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                    join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                    join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                    left join ldci.tb_vendedor_cotizacion vc on vc.id_cotizacion=co.id_cotizacion
                    left join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                    order by co.fecha_grabacion desc) as tb ";
            }
        } else {
            if ($estado != 0) {
                $table = "(select distinct t1.id_cotizacion,t1.transporte,t1.destino,
                            t1.origen,t1.fecha,t1.estado,t1.usuario,t1.asignada
                            from(select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                            co.fecha_grabacion,us1.usuario as asignada
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            left join ldci.tb_vendedor_cotizacion vc on vc.id_cotizacion=co.id_cotizacion
                            left join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                            where co.estado=$estado and co.usuario_grabacion=$id_session
                            union all
                            select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                                   co.fecha_grabacion,us2.usuario as asignada
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            join ldci.tb_vendedor_cotizacion vc on co.id_cotizacion=vc.id_cotizacion
                            join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                            left join ldci.tb_vendedor_cotizacion vc1 on vc1.id_cotizacion=co.id_cotizacion
                            left join ldci.tb_usuario us2 on us2.id_usuario=vc1.id_usuario
                            where co.estado=$estado and vc.id_usuario=$id_session  and us1.tipo=2
                            order by  fecha_grabacion desc ) as t1) as tb ";
            } else {
                $table = "(select distinct t1.id_cotizacion,t1.transporte,t1.destino,
                            t1.origen,t1.fecha,t1.estado,t1.usuario,t1.asignada
                            from(select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                            co.fecha_grabacion,us1.usuario as asignada
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            left join ldci.tb_vendedor_cotizacion vc on vc.id_cotizacion=co.id_cotizacion
                            left join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                            where  co.usuario_grabacion=$id_session
                            union all
                            select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                                   co.fecha_grabacion,us2.usuario as asignada
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            join ldci.tb_vendedor_cotizacion vc on co.id_cotizacion=vc.id_cotizacion
                            join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                            left join ldci.tb_vendedor_cotizacion vc1 on vc1.id_cotizacion=co.id_cotizacion
                            left join ldci.tb_usuario us2 on us2.id_usuario=vc1.id_usuario
                            where  vc.id_usuario=$id_session  and us1.tipo=2
                            order by  fecha_grabacion desc ) as t1) as tb ";
            }
        }


        $primaryKey = 'id_cotizacion';
        $columns = [
            ['db' => 'id_cotizacion', 'dt' => 0],
            ['db' => 'transporte', 'dt' => 1],
            ['db' => 'destino', 'dt' => 2],
            ['db' => 'origen', 'dt' => 3],
            ['db' => 'fecha', 'dt' => 4],
            ['db' => 'estado', 'dt' => 5],
            ['db' => 'usuario', 'dt' => 6],
            ['db' => 'asignada', 'dt' => 7],
        ];

        /*** Config DB */
        $db = array(
            'host' => $_ENV['DB_HOST'],
            'db' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD']
        );
        return SSP::complex($_POST, $db, $table, $primaryKey, $columns);
    }

    /** Funcion que recupera todos los usuarios tipo vendedor*/
    function getVendedores()
    {
        $query = new static;
        $query = DB::select("select  id_usuario,usuario from ldci.tb_usuario where estado=1 and confirmado=true and tipo=2");
        return $query;
    }

    /** Funcion que recupera todos de un usuario vendedor*/
    function getVendedor($id_vendedor)
    {
        $query = new static;
        $query = DB::select("select * from ldci.tb_usuario where id_usuario=$id_vendedor");
        return $query;
    }

    /** Funcion que asigna cotizacion a vendedor */
    function setcotizacion($id_vendedor, $id_cotizacion, $asignada, $id_session)
    {

        if ($asignada == "true") {
            $query = new static;
            $query = DB::insert('UPDATE ldci.tb_vendedor_cotizacion
            SET id_usuario=?,  usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_cotizacion=?', [$id_vendedor, $id_session, $id_cotizacion]);

            if ($query) {
                return collect([
                    'mensaje' => 'Asignacion Actualizada Correctamente',
                    'error' => false
                ]);
            } else {
                return collect([
                    'mensaje' => 'Ocurrio un error al actualizar asignacion',
                    'error' => true
                ]);
            }
        } else {
            $query = new static;
            $query = DB::insert('INSERT INTO ldci.tb_vendedor_cotizacion(
            id_cotizacion, id_usuario, usuario_grabacion, fecha_grabacion)
            VALUES (?, ?, ?, now())', [$id_cotizacion, $id_vendedor, $id_session]);

            if ($query) {
                return collect([
                    'mensaje' => 'Cotizacion Asignada Correctamente',
                    'error' => false
                ]);
            } else {
                return collect([
                    'mensaje' => 'Ocurrio un error al asignar vendendor',
                    'error' => true
                ]);
            }
        }
    }

    /** Funcion para buscar si existe una asigancion a una cotizacion*/
    function getAsignacion($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select id_usuario from ldci.tb_vendedor_cotizacion where id_cotizacion=$id_cotizacion");
        return $query;
    }

    /** Funcion que recupera encabezado de cotizacion*/
    function getEncabezado($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select c.id_cotizacion,c1.ciudad ||'/'||c1.pais as origen,upper(c.nota) as nota,upper(c.descripcion) as descripcion,
                                   c2.ciudad ||'/'||c2.pais as destino,c.estado,us.usuario as grabacion,us.correo
                                   ,us1.usuario vendedor,c.fecha ::date ,c.id_tipo_transporte
                            from ldci.tb_cotizacion c
                            join ldci.vw_ciudades c1 on c.id_ciudad_origen=c1.id_ciudad
                            join ldci.vw_ciudades c2 on c.id_ciudad_destino=c2.id_ciudad
                            join ldci.tb_usuario us on c.usuario_grabacion=us.id_usuario
                            left join ldci.tb_vendedor_cotizacion  vc on vc.id_cotizacion=c.id_cotizacion
                            left join ldci.tb_usuario us1 on vc.id_usuario=us1.id_usuario
                            where c.id_cotizacion=$id_cotizacion");
        return $query;
    }

    /** Funcion que recupera detalles de carga*/
    function getDetalleCarga($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select cantidad,id_tipo_modo_transporte,id_tipo_mercancia,upper(descripcion) as descripcion,nuevo,precio
                                    from  ldci.tb_detalle_cotizacion where id_cotizacion=$id_cotizacion and id_producto is null");
        return $query;
    }

    /** Funcion que recupera detalles servicio*/
    function getDetalleServicio($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select id_producto,precio
                            from  ldci.tb_detalle_cotizacion where id_cotizacion=$id_cotizacion and id_producto is not null");
        return $query;
    }

    /** Funcion para obtener la informacion de la cotizacion */
    function getDatosCotizacion($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("SELECT c.id_cotizacion AS n_cotizacion,u.id_usuario,u.usuario AS usuario_crea,
		TO_CHAR (c.fecha,'DD-MM-YYYY') AS fecha,
		TO_CHAR (c.fecha_grabacion,'DD-MM-YYYY') as fecha_creacion,
		c.id_cotizacion AS Numero_cotizacion,upper(c.nota) as nota,
		u.telefono,u.iso2,tt.nombre AS t_transporte,
		co.ciudad||'/'||co.pais AS c_origen,cd.ciudad||'/'||cd.pais as c_destino,
        to_char(coalesce(c.iva,0),'9,999,999.99') as iva ,
        to_char(coalesce(c.monto_total,0),'9,999,999.99') as total,
        to_char(coalesce((c.monto_total-c.iva),0),'9,999,999.99') as subtotal,0 as descuento
		FROM ldci.tb_cotizacion AS c
		JOIN ldci.tb_usuario AS u ON u.id_usuario=c.usuario_grabacion
		JOIN ldci.tb_tipo_transporte AS tt ON c.id_tipo_transporte=tt.id_tipo_transporte
		JOIN ldci.vw_ciudades AS co ON co.id_ciudad=c.id_ciudad_origen
		JOIN ldci.vw_ciudades AS cd ON cd.id_ciudad=c.id_ciudad_destino
		WHERE c.id_cotizacion = $id_cotizacion");

        return $query;
    }

    /**Funcion para mostrar detalle de cotizacion */
    function getDetalleCotizacion($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select row_number() OVER (ORDER BY t.id_detalle_cotizacion) as no,t.codigo,t.carga,t.cantidad,
       t.iva,t.total,t.transporte,t.precio,t.Dto,upper(descripcion) as descripcion
        from (Select dc.id_detalle_cotizacion, tm.id_tipo_mercancia as codigo,
            tm.nombre AS carga,dc.cantidad,
            mt.nombre AS transporte,
            coalesce(dc.precio,0) AS precio,coalesce((dc.precio*0.15),0) as iva,
            coalesce(((coalesce((dc.precio*0.15),0)+(coalesce(dc.precio,0)))),0)total ,0 as Dto, dc.descripcion
            FROM ldci.tb_cotizacion AS c
            JOIN ldci.tb_detalle_cotizacion AS dc ON dc.id_cotizacion=c.id_cotizacion
            JOIN ldci.tb_tipo_mercancia AS tm ON dc.id_tipo_mercancia=tm.id_tipo_mercancia
            JOIN ldci.tb_tipo_modo_transporte AS mt ON mt.id_tipo_modo_transporte= dc.id_tipo_modo_transporte
            WHERE c.id_cotizacion=$id_cotizacion
            UNION
            SELECT cd.id_detalle_cotizacion, p.id_producto, p.nombre, null , ' ',
            coalesce(cd.precio,0) AS precio,coalesce((cd.precio*0.15),0) as iva,
            coalesce(((coalesce((cd.precio*0.15),0)+(coalesce(cd.precio,0)))),0)total,0 as Dto ,'' as descripcion
            from ldci.tb_cotizacion as c
            JOIN ldci.tb_detalle_cotizacion AS cd ON c.id_cotizacion = cd.id_cotizacion
            JOIN ldci.tb_producto AS p on p.id_producto = cd.id_producto
            WHERE c.id_cotizacion = $id_cotizacion)as t");

        return $query;
    }

    /** Elimina detalle de cotizacion */
    function deleteDetalle($id_cotizacion)
    {
        $query = new static;
        $query = DB::delete("DELETE FROM ldci.tb_detalle_cotizacion
                                    WHERE id_cotizacion=$id_cotizacion");
    }

    function  actualizarCotizacion($tblDetalleCarga,$tblDetalleServicios,$descripcion,$estado,$id_cotizacion,$total,$iva,$id_session)
    {
        DB::beginTransaction();
        $transaccionOk = true;
        $query_encabezado = new static;
        $query_encabezado = DB::update ('UPDATE ldci.tb_cotizacion
                            SET  estado=?, descripcion=?, iva=?, monto_total=?,
                                usuario_modificacion=?, fecha_modificacion=now()
                            WHERE id_cotizacion=?', [$estado, $descripcion,$iva, $total, $id_session,$id_cotizacion]);


        if (empty($query_encabezado)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al actualizar cotizacion',
                'error' => true
            ]);
        } else {

            foreach ($tblDetalleCarga as $carga) {
                $query_detalle = new static;
                $query_detalle = DB::insert('INSERT INTO ldci.tb_detalle_cotizacion(
                descripcion, cantidad, nuevo, id_cotizacion,precio,
                id_tipo_mercancia, id_tipo_modo_transporte,  usuario_grabacion, fecha_grabacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, now())', [$carga->observacion, $carga->Cantidad, $carga->estado, $id_cotizacion,$carga->precio, $carga->id_tipo_mercancia, $carga->id_modo_transporte, $id_session]);
                if (!$query_detalle) {
                    $transaccionOk = false;
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al actualizar detalle de carga',
                        'error' => true
                    ]);
                }
            }

            if ($transaccionOk) {
                foreach ($tblDetalleServicios as $servicio) {

                    $query_detalle = new static;
                    $query_detalle = DB::insert('INSERT INTO ldci.tb_detalle_cotizacion(
                     id_cotizacion, id_producto,precio,  usuario_grabacion, fecha_grabacion)
                    VALUES (?, ?, ?, ?, now())', [$id_cotizacion, $servicio->id_servicio,$servicio->precio, $id_session]);

                    if (!$query_detalle) {
                        $transaccionOk = false;
                        DB::rollBack();
                        return collect([
                            'mensaje' => 'Hubo un error al actualizar servicios',
                            'error' => true
                        ]);
                    }
                }
                DB::commit();
                return collect([
                    'mensaje' => 'Cotizacion actualizada con exito',
                    'error' => false
                ]);
            }
        }
    }

    function CambiarEstadoCotizacion ($id_cotizacion,$descripcion,$estado,$id_session)
    {
        $query = new static;
        $query = DB::UPDATE ('UPDATE ldci.tb_cotizacion
            SET  estado=?, descripcion=?,usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_cotizacion=?;', [$estado,$descripcion, $id_session, $id_cotizacion]);

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
