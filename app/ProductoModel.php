<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\False_;

class ProductoModel extends Model
{
    public function getProducto()
    {
        $table = "(select id_producto,nombre,descripcion,precio,existencia,tipo,iva
                    from ldci.tb_producto where estado=1 order by  id_producto desc) as tb ";

        $primaryKey = 'id_producto';
        $columns = [
            ['db' => 'id_producto', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1],
            ['db' => 'descripcion', 'dt' => 2],
            ['db' => 'precio', 'dt' => 3],
            ['db' => 'existencia', 'dt' => 4],
            ['db' => 'tipo', 'dt' => 5],
            ['db' => 'iva', 'dt' => 6]
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

    /** Metodo para validar si existe el nombre del producto*/
    public function existe($nombre, $id_Producto)
    {
        if (empty($id_Producto))
            $id_Producto = 0;

        $query = new static;
        $query = DB::select('select * from ldci.tb_producto
                        where upper(nombre)=upper(?) and estado=1 and id_producto!=?', [$nombre, $id_Producto]);

        if (empty($query))
            return false;
        else
            return true;
    }

    /** Metodo para guardar /actuliazar un registro*/
    public function guardarProducto($id_Producto, $nombre, $existencia, $precio, $descripcion, $tipo,$iva, $id_session)
    {
        $query = new static;

        if (!empty($id_Producto)) // si existe un id, actualiza
        {
            $query = DB::select("UPDATE ldci.tb_producto
                                SET  nombre=?, precio=?, descripcion=?,  existencia=?,tipo=?,iva=?,
                                usuario_modificacion=?, fecha_modificacion=now()
                                WHERE id_producto=? RETURNING id_producto", [$nombre, $precio, $descripcion, $existencia, $tipo,$iva, $id_session, $id_Producto]);
        } else {
            $query = DB::select("INSERT INTO ldci.tb_producto(
                                nombre, precio, descripcion,tipo,iva,
                                existencia, usuario_grabacion,fecha_grabacion)
                                VALUES (?, ?, ?, ?, ?,?,?, now()) RETURNING id_producto", [$nombre, $precio, $descripcion, $tipo,$iva, $existencia, $id_session]);
        }
        return $query;
    }

    /** Funcion para guardar imagenes de producto */
    public function guardarImagenProducto($id_producto, $url, $imageName, $id_session)
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
            VALUES ( 1, ?, ?, ?, now())', [$id_producto, $query_imagen[0]->id_imagen, $id_session]);

            if ($query_detalle) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }
    }

    /** Recupera imagenes de un producto */
    function  getImagen($id_producto)
    {
        $query = new static;
        $query = DB::select('select i.nombre,i.url from ldci.tb_detalle_imagen det
                            join ldci.tb_imagen i on det.id_imagen=i.id_imagen
                            where id_tabla=? and id_tipo=1', [$id_producto]);

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

    /** Funcion para eliminar un producto */
    public  function  eliminar($id_Producto, $id_session)
    {

        $query = new static;
        $query = DB::UPDATE('UPDATE ldci.tb_producto
                    SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                    WHERE id_producto=? AND
                    NOT EXISTS (SELECT dc.id_producto FROM ldci.tb_detalle_cotizacion AS dc
                    WHERE dc.id_producto=?) AND
                    NOT EXISTS (SELECT de.id_producto FROM ldci.tb_detalle_entrada AS de
                    WHERE de.id_producto=?) AND
                    NOT EXISTS (SELECT df.id_producto FROM ldci.tb_detalle_factura AS df
                    WHERE df.id_producto=?)', [$id_session, $id_Producto, $id_Producto, $id_Producto, $id_Producto]);

        return $query;
    }

    /** Recupera Productos para mostrar en vista productos usuario */
    function  getProductoUsuario()
    {
        $query = new static;
        $query = DB::select('select id_producto,precio from ldci.tb_producto where estado=1 and tipo=1 and existencia!=0');

        return $query;
    }

    /** Recupera imagenes de un producto  para vista usuario*/
    function  getProductoImagenes($id_producto)
    {
        $query = new static;
        $query = DB::select('select i.nombre as imagen,i.url,p.nombre,p.descripcion
                                    from ldci.tb_detalle_imagen det
                                    join ldci.tb_imagen i on det.id_imagen=i.id_imagen
                                    join ldci.tb_producto p on p.id_producto=id_tabla
                                    where p.id_producto=? and id_tipo=1
                                    ', [$id_producto]);

        return $query;
    }

    /** funcion para cargar tabla en reporte clientes */
    public function getDatosProductos()
    {

        $query = new static;
        $query = DB::select("select ROW_NUMBER() OVER( ORDER BY tipo DESC) AS no, nombre as nombre_producto,
            case tipo when 1
            then 'Producto'
            else 'Servicio' end as tipo,
            existencia,'$'|| precio as precio, descripcion
            from ldci.tb_producto where estado = 1");

        return $query;
    }
}
