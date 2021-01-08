<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FacturaModel extends Model
{
    /** Funcion para cargar tabla cotizaciones*/
    public function getCotizaciones($tipoUsuario, $id_session)
    {
        if ($tipoUsuario == 1) {

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
                        where co.estado=4
                        order by co.fecha_grabacion desc) as tb ";

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
                            where co.estado=4 and co.usuario_grabacion=$id_session
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
                            where co.estado=4 and vc.id_usuario=$id_session  and us1.tipo=2
                            order by  fecha_grabacion desc ) as t1) as tb ";
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

    /** Funcion que recupera encabezado de cotizacion*/
    function getEncabezado($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("select c.id_cotizacion,c1.ciudad ||'/'||c1.pais as origen,
                           c2.ciudad ||'/'||c2.pais as destino,
                           p1.nombre ||' '|| p1.apellido1 ||' '|| coalesce(p1.apellido2,' ') as cliente,
                           to_char(c.fecha,'DD/MM/YYYY')as fecha,c.id_tipo_transporte,
                           to_char(coalesce(c.iva,0),'9,999,999.99') as iva ,
                            to_char(coalesce(c.monto_total,0),'9,999,999.99') as total,
                            to_char(coalesce((c.monto_total-c.iva),0),'9,999,999.99') as subtotal,0 as descuento
                            from ldci.tb_cotizacion c
                            join ldci.vw_ciudades c1 on c.id_ciudad_origen=c1.id_ciudad
                            join ldci.vw_ciudades c2 on c.id_ciudad_destino=c2.id_ciudad
                            join ldci.tb_flete f on f.id_cotizacion=c.id_cotizacion
                            join ldci.tb_cliente cl on cl.id_cliente=f.id_cliente
                            join ldci.tb_persona p1 on p1.id_persona=cl.id_persona
                            where c.id_cotizacion=$id_cotizacion");
        return $query;
    }


}
