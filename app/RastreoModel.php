<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RastreoModel extends Model
{
    /** funcion para listas cotizaciones en estado tramite*/
    public function getCotizaciones($tipoUsuario, $id_session)
    {
        if ($tipoUsuario == 1) {
            $table = "(SELECT f.id_flete,case cl.tipo when 1
                then p.nombre ||' '|| p.apellido1 ||' '|| COALESCE (p.apellido2,'')
                else cl.nombre_empresa end as cliente,
                tt.nombre as transporte, cd.ciudad||'/'||cd.pais as destino,
                co.ciudad||'/'||co.pais as origen, TO_CHAR (c.fecha,'DD-MM-YYYY') AS fecha_envio
                FROM ldci.tb_cotizacion AS c
                JOIN ldci.tb_tipo_transporte AS tt on tt.id_tipo_transporte=c.id_tipo_transporte
                JOIN ldci.vw_ciudades AS cd ON cd.id_ciudad=c.id_ciudad_destino
                JOIN ldci.vw_ciudades AS co ON co.id_ciudad=c.id_ciudad_origen
                JOIN ldci.tb_flete AS f ON f.id_cotizacion=c.id_cotizacion
                JOIN ldci.tb_cliente AS cl ON cl.id_cliente=f.id_cliente
                JOIN ldci.tb_persona AS p ON cl.id_persona=p.id_persona WHERE c.estado=4) as tb";
        } else {
            $table = "(SELECT DISTINCT f.id_flete,f.cliente,f.transporte,f.destino, f.origen, f.fecha_envio FROM(
                SELECT f.id_flete,case cl.tipo when 1
                    then p.nombre ||' '|| p.apellido1 ||' '|| COALESCE (p.apellido2,'')
                    else cl.nombre_empresa end as cliente,
                    tt.nombre as transporte, cd.ciudad||'/'||cd.pais as destino,
                    co.ciudad||'/'||co.pais as origen, TO_CHAR (c.fecha,'DD-MM-YYYY') AS fecha_envio
                    FROM ldci.tb_cotizacion AS c
                    JOIN ldci.tb_tipo_transporte AS tt on tt.id_tipo_transporte=c.id_tipo_transporte
                    JOIN ldci.vw_ciudades AS cd ON cd.id_ciudad=c.id_ciudad_destino
                    JOIN ldci.vw_ciudades AS co ON co.id_ciudad=c.id_ciudad_origen
                    JOIN ldci.tb_flete AS f ON f.id_cotizacion=c.id_cotizacion
                    JOIN ldci.tb_cliente AS cl ON cl.id_cliente=f.id_cliente
                    JOIN ldci.tb_persona AS p ON cl.id_persona=p.id_persona
                    WHERE c.estado=4 AND c.usuario_grabacion=$id_session
                    UNION ALL
                    SELECT f.id_flete,case cl.tipo when 1
                    then p.nombre ||' '|| p.apellido1 ||' '|| COALESCE (p.apellido2,'')
                    else cl.nombre_empresa end as cliente,
                    tt.nombre as transporte, cd.ciudad||'/'||cd.pais as destino,
                    co.ciudad||'/'||co.pais as origen, TO_CHAR (c.fecha,'DD-MM-YYYY') AS fecha_envio
                    FROM ldci.tb_cotizacion AS c
                    JOIN ldci.tb_tipo_transporte AS tt on tt.id_tipo_transporte=c.id_tipo_transporte
                    JOIN ldci.vw_ciudades AS cd ON cd.id_ciudad=c.id_ciudad_destino
                    JOIN ldci.vw_ciudades AS co ON co.id_ciudad=c.id_ciudad_origen
                    JOIN ldci.tb_flete AS f ON f.id_cotizacion=c.id_cotizacion
                    JOIN ldci.tb_cliente AS cl ON cl.id_cliente=f.id_cliente
                    JOIN ldci.tb_persona AS p ON cl.id_persona=p.id_persona
                    JOIN ldci.tb_vendedor_cotizacion AS vc ON vc.id_cotizacion=c.id_cotizacion
                    WHERE c.estado=4 AND vc.id_usuario=$id_session) AS f) as tb";
        }
        $primaryKey = 'id_flete';
        $columns = [
            ['db' => 'id_flete', 'dt' => 0],
            ['db' => 'cliente', 'dt' => 1],
            ['db' => 'transporte', 'dt' => 2],
            ['db' => 'destino', 'dt' => 3],
            ['db' => 'origen', 'dt' => 4],
            ['db' => 'fecha_envio', 'dt' => 5]
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

    //** Funcion para obtener el detalle de seguimiento */
    public function getDetalleSeguimiento($id_flete)
    {
        $query = new static;
        $query = DB::select("SELECT ds.id_detalle_seguimiento, ds.fecha :: Date AS fecha_evento, ds.evento, ds.detalle as descripcion
                        FROM ldci.tb_cotizacion AS c
                        JOIN ldci.tb_flete AS f ON c.id_cotizacion=f.id_cotizacion
                        JOIN ldci.tb_detalle_seguimiento AS ds ON ds.id_flete=f.id_flete
                        WHERE f.id_flete= $id_flete AND ds.estado=1");
        return $query;
    }

    /** Funcion para guardar el detalle de rastreo de la cotizacion */
    public function guardarRastreo($id_flete, $fecha, $evento, $descripcion, $id_detalle_seguimiento, $id_session)
    {
        DB::beginTransaction();
        for ($i = 0; $i < count($fecha); $i++) {
            if ($id_detalle_seguimiento[$i] == null) {
                $query_detalle_seguimiento = new static;
                $query_detalle_seguimiento = DB::insert('INSERT INTO ldci.tb_detalle_seguimiento(
                fecha, evento, detalle, estado, id_flete,  usuario_grabacion, fecha_grabacion)
                VALUES (?, ?, ?, ?, ?, ?, now())', [$fecha[$i], $evento[$i], $descripcion[$i], 1, $id_flete, $id_session]);

                if (!$query_detalle_seguimiento) {
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al guardar el detalle de rastreo',
                        'error' => true
                    ]);
                }
            } else {
                $query_detalle_seguimiento_p = new static;
                $query_detalle_seguimiento_p = DB::Update("UPDATE ldci.tb_detalle_seguimiento SET
                fecha=?, evento=?, detalle=?,  usuario_modificacion=?, fecha_modificacion=now()
                WHERE id_detalle_seguimiento=?", [$fecha[$i], $evento[$i], $descripcion[$i], $id_session, $id_detalle_seguimiento[$i]]);

                if (!$query_detalle_seguimiento_p) {
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al guardar el detalle de rastreo',
                        'error' => true
                    ]);
                }
            }
        }
        DB::commit();
        return collect([
            'mensaje' => 'Detalle Rastreo guardada con exito',
            'error' => false
        ]);
    }

    /** Funcion para guardar la imagen del rastreo de la cotizacion */
    public function guardarImagenRastreo($id_flete, $url, $imageName, $id_session)
    {
        DB::beginTransaction();

        $query_imagen = new static;
        $query_imagen = DB::select('INSERT INTO ldci.tb_imagen(
                    url, nombre, usuario_grabacion, fecha_grabacion)
                    VALUES (?, ?, ?, now()) RETURNING id_imagen', [$url, $imageName, $id_session]);

        if (empty($query_imagen)) {
            DB::rollBack();
            return false;
        } else {
            $query_detalle = new static;
            $query_detalle = DB::select('INSERT INTO ldci.tb_detalle_imagen(
                id_tipo, id_tabla, id_imagen, usuario_grabacion, fecha_grabacion)
            VALUES ( 2, ?, ?, ?, now())', [$id_flete, $query_imagen[0]->id_imagen, $id_session]);

            if ($query_detalle) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }
    }

    /** Funcion para extraer imagenes de rastreo*/
    public function getImagen($id_flete)
    {
        $query = new static;
        $query = DB::select('select i.nombre,i.url from ldci.tb_detalle_imagen det
                            join ldci.tb_imagen i on det.id_imagen=i.id_imagen
                            where id_tabla=? and id_tipo=2', [$id_flete]);

        return $query;
    }

    /** Metodo para validar si existe una imagen*/
    public function existeImagen($imagen)
    {
        $query = new static;
        $query = DB::select('select * from ldci.tb_imagen where nombre=?', [$imagen]);

        if (empty($query))
            return false;
        else
            return true;
    }

    /** Funcion para eliminar una imagen */
    public function eliminarImagen($imagen)
    {
        DB::beginTransaction();

        $query_imagen = new static;
        $query_imagen = DB::select('DELETE FROM ldci.tb_imagen
                        WHERE nombre=? RETURNING id_imagen', [$imagen]);

        if (empty($query_imagen)) {
            DB::rollBack();
            return false;
        } else {
            $query_detalle = new static;
            $query_detalle = DB::select('DELETE FROM ldci.tb_detalle_imagen
                        WHERE id_imagen=?', [$query_imagen[0]->id_imagen]);

            if ($query_detalle) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }
    }

    /** Recupera imagenes de rastreo  para vista usuario cliente*/
    public function  getRastreoImagenes($id_flete)
    {
        $query = new static;
        $query = DB::select('select i.nombre as imagen,i.url
                    from ldci.tb_detalle_imagen det
                    join ldci.tb_imagen i on det.id_imagen=i.id_imagen
                    where det.id_tabla=? and id_tipo=2', [$id_flete]);

        return $query;
    }

    /** funcion oara eliminar un evento de una rastreo */
    public function eliminar($id_detalle, $id_session)
    {
        $query = new static;
        $query = DB::UPDATE('UPDATE ldci.tb_detalle_seguimiento
                                SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                                WHERE id_detalle_seguimiento=?', [$id_session, $id_detalle]);

        return $query;
    }
}
