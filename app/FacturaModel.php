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
        $query = DB::select("select f.id_flete,c.id_cotizacion,c1.ciudad ||'/'||c1.pais as origen,
                           c2.ciudad ||'/'||c2.pais as destino,
                           p1.nombre ||' '|| p1.apellido1 ||' '|| coalesce(p1.apellido2,' ') as cliente,
                           to_char(f.fecha_entrega,'DD/MM/YYYY')as fecha,c.id_tipo_transporte,
                           to_char(coalesce(c.iva,0),'9,999,999.99') as iva ,
                            to_char(coalesce(c.monto_total,0),'9,999,999.99') as total,
                            to_char(coalesce((c.monto_total-c.iva),0),'9,999,999.99') as subtotal,0 as descuento,
                            p1.iso_2 as telcliente,p2.iso_2 as telconsignatario
                            from ldci.tb_cotizacion c
                            join ldci.vw_ciudades c1 on c.id_ciudad_origen=c1.id_ciudad
                            join ldci.vw_ciudades c2 on c.id_ciudad_destino=c2.id_ciudad
                            join ldci.tb_flete f on f.id_cotizacion=c.id_cotizacion
                            join ldci.tb_cliente cl on cl.id_cliente=f.id_cliente
                            join ldci.tb_persona p1 on p1.id_persona=cl.id_persona
                            join ldci.tb_persona p2 on p2.id_persona=f.id_cotizacion
                            where c.id_cotizacion=$id_cotizacion");
        return $query;
    }

    /** Funcion que recupera encabezado de factura cotizacion*/
    function getDatosFacturaCotizacion($id_cotizacion)
    {
        $query = new static;
        $query = DB::select("SELECT  fa.codigo, p1.nombre ||' '|| p1.apellido1 ||' '|| coalesce(p1.apellido2,' ') as cliente,
        p1.telefono_2 as telefonocl,p1.correo as correocl ,p1.direccion as direccioncl,
        upper(p2.nombre) ||' '|| upper(p2.apellido1) ||' '|| coalesce(upper(p2.apellido2),' ') as consignatario,
        p2.telefono_2 as telefonoc ,p2.correo as correoc ,p2.direccion as direccionc,
		TO_CHAR (c.fecha ,'DD-MM-YYYY') AS fecha_envio,
		TO_CHAR (f.fecha_entrega,'DD-MM-YYYY') as fecha_entrega,
		TO_CHAR (fa.fecha_emision,'DD-MM-YYYY') as fecha_factura,
		upper(c.nota) as nota,tt.nombre AS t_transporte,
		co.ciudad||'/'||co.pais AS c_origen,cd.ciudad||'/'||cd.pais as c_destino,
        to_char(coalesce(c.iva,0),'9,999,999.99') as iva ,
        to_char(coalesce((c.monto_total-c.iva),0),'9,999,999.99') as subtotal,
       case when fa.moneda=1 then '$' ||to_char(coalesce(fa.monto,0),'9,999,999.99')
       else 'C$' ||to_char(coalesce((fa.monto)*(select monto from ldci.tb_tasa_cambio where fecha::date =fa.fecha_emision::date ),0),'9,999,999.99')end as total,
        to_char(coalesce((fa.descuento),0),'9,999,999.99') as descuento,
        to_char(coalesce((fa.micelaneo),0),'9,999,999.99') as micelaneos,
        upper(fa.termino) as terminos,case when fa.moneda=1 then 'DOLLAR' else 'CORDOBA' end as moneda
		FROM ldci.tb_cotizacion AS c
		join ldci.tb_flete f on c.id_cotizacion=f.id_cotizacion
		join ldci.tb_factura fa on f.id_flete=fa.id_flete
		JOIN ldci.tb_cliente cl on f.id_cliente=cl.id_cliente
		join ldci.tb_persona p1 on p1.id_persona=cl.id_persona
		join ldci.tb_persona p2 on p2.id_persona=f.id_consignatario
		JOIN ldci.tb_tipo_transporte AS tt ON c.id_tipo_transporte=tt.id_tipo_transporte
		JOIN ldci.vw_ciudades AS co ON co.id_ciudad=c.id_ciudad_origen
		JOIN ldci.vw_ciudades AS cd ON cd.id_ciudad=c.id_ciudad_destino
		where c.id_cotizacion=$id_cotizacion");
        return $query;
    }

    /**Funcion para mostrar detalle de factura cotizacion */
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
            WHERE c.id_cotizacion = $id_cotizacion
            UNION
            select ca.id_cargo_aplicado as no,ca.id_cargo_aplicado,ca.descricion,null,null,ca.monto,null
            ,null,null,null
            from ldci.tb_cargo_aplicado ca
            join ldci.tb_factura fa on fa.id_factura=ca.id_factura
            join ldci.tb_flete f on f.id_flete=fa.id_flete
             where f.id_cotizacion=$id_cotizacion
            )as t");

        return $query;
    }

    function  guardarFacturaCotizacion($tblDetalleCargos,$termino,$tipo,$id_flete,$codigoFactura,$descuento,$total,$micelaneos,$moneda,$id_session)
    {
        DB::beginTransaction();
        $transaccionOk = true;
        $query_factura = new static;
        $query_factura = DB::select('INSERT INTO ldci.tb_factura(
	codigo, termino, tipo, moneda, descuento, monto, micelaneo,
	fecha_emision,id_flete, usuario_grabacion, fecha_grabacion)
	VALUES ( ?, ?, ?, ?, ?, ?, ?, now()::date, ?, ?,now()) RETURNING id_factura', [$codigoFactura,$termino, $tipo, $moneda, $descuento, $total,$micelaneos,$id_flete, $id_session]);


        if (empty($query_factura)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar factura',
                'error' => true
            ]);
        } else {

            foreach ($tblDetalleCargos as $cargo) {
                $query_detalle = new static;
                $query_detalle = DB::insert('INSERT INTO ldci.tb_cargo_aplicado(
                 monto, descricion, id_factura, usuario_grabacion, fecha_grabacion)
                VALUES (?, ?, ?, ?,now())', [$cargo->monto, $cargo->descripcion, $query_factura[0]->id_factura,$id_session]);
                if (!$query_detalle) {
                    $transaccionOk = false;
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al guardar detalle de cargos',
                        'error' => true
                    ]);
                }
            }

            if ($transaccionOk) {
                DB::commit();
                return collect([
                    'mensaje' => 'Factura Gurdada con exito',
                    'error' => false,
                ]);
            }
        }
    }


}
