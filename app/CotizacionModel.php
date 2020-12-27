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
                        'cotizacion'=>$query_encabezado[0]->id_cotizacion
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
    public function getCotizaciones($estado,$tipoUsuario,$id_session)
    {
        if ($tipoUsuario==1)
        {
            if($estado!=0){
                $table = "(select co.id_cotizacion, t.nombre as
                        transporte,c1.ciudad ||','||c1.pais as destino,
                        c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                        co.fecha_grabacion
                        from ldci.tb_cotizacion co
                        join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                        join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                        join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                        join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                        where co.estado=$estado
                        order by co.fecha_grabacion desc) as tb ";

            }else
            {

                $table = "(select co.id_cotizacion, t.nombre as
                        transporte,c1.ciudad ||','||c1.pais as destino,
                        c2.ciudad ||','|| c2.pais as origen,
                        to_char(co.fecha,'DD/MM/YYYY')as fecha,
                        co.estado,us.usuario,co.fecha_grabacion
                    from ldci.tb_cotizacion co
                    join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                    join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                    join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                    join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                    order by co.fecha_grabacion desc) as tb ";
            }
        }
        else
        {
            if($estado!=0) {
                $table = "(select distinct t1.id_cotizacion,t1.transporte,t1.destino,
                            t1.origen,t1.fecha,t1.estado,t1.usuario
                            from(select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                            co.fecha_grabacion
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            where co.estado=$estado and co.usuario_grabacion=$id_session
                            union all
                            select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                                   co.fecha_grabacion
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            join ldci.tb_vendedor_cotizacion vc on co.id_cotizacion=vc.id_cotizacion
                            join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                            where co.estado=$estado and vc.id_usuario=$id_session  and us1.tipo=2
                            order by  fecha_grabacion desc ) as t1) as tb ";

            }else{
                $table = "(select distinct t1.id_cotizacion,t1.transporte,t1.destino,
                            t1.origen,t1.fecha,t1.estado,t1.usuario
                            from(select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                            co.fecha_grabacion
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            where co.usuario_grabacion=$id_session
                            union all
                            select co.id_cotizacion, t.nombre as transporte,c1.ciudad ||','||c1.pais as destino,
                            c2.ciudad ||','|| c2.pais as origen,co.fecha :: date,co.estado,us.usuario,
                                   co.fecha_grabacion
                            from ldci.tb_cotizacion co
                            join ldci.vw_ciudades c1 on co.id_ciudad_destino=c1.id_ciudad
                            join ldci.vw_ciudades c2 on co.id_ciudad_origen=c2.id_ciudad
                            join ldci.tb_tipo_transporte t on t.id_tipo_transporte=co.id_tipo_transporte
                            join ldci.tb_usuario us on us.id_usuario=co.usuario_grabacion
                            join ldci.tb_vendedor_cotizacion vc on co.id_cotizacion=vc.id_cotizacion
                            join ldci.tb_usuario us1 on us1.id_usuario=vc.id_usuario
                            where vc.id_usuario=$id_session and us1.tipo=2
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
        ];

        /*** Config DB */
        $db = array(
            'host' =>$_ENV['DB_HOST'],
            'db' =>$_ENV['DB_DATABASE'],
            'user' =>$_ENV['DB_USERNAME'],
            'pass' =>$_ENV['DB_PASSWORD']
        );
        return SSP::complex($_POST,$db,$table, $primaryKey, $columns);

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
    function setcotizacion($id_vendedor,$id_cotizacion,$id_session)
    {

        $query = new static;
        $query = DB::insert('INSERT INTO ldci.tb_vendedor_cotizacion(
            id_cotizacion, id_usuario, usuario_grabacion, fecha_grabacion)
            VALUES (?, ?, ?, now())', [$id_cotizacion,$id_vendedor,$id_session]);

        if ($query)
        {
            return collect([
                'mensaje' => 'Cotizacion Asignada Correctamente',
                'error' => false
            ]);
        }
        else{
            return collect([
                'mensaje' => 'Ocurrio un error al asignar vendendor',
                'error' => true
            ]);
        }
    }


}
