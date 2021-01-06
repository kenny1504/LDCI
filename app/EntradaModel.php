<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EntradaModel extends Model
{
    /** Funcion que recupera todos los proveedores*/
    public function getproveedores()
    {
        $query = new static;
        $query = DB::select('SELECT p.id_proveedor,p.nombre FROM ldci.tb_proveedor as p WHERE p.estado=1');
        return $query;
    }

    /** Funcion que recupera todos los productos*/
    public function getproductos()
    {
        $query = new static;
        $query = DB::select('SELECT p.id_producto,p.nombre FROM ldci.tb_producto as p WHERE p.estado=1 AND p.tipo=1');
        return $query;
    }

    /** Funcion para Recuperar Entradas en tabla*/
    public function getEntradas()
    {
        $table = "(SELECT e.id_entrada,pr.nombre as proveedor,e.monto,TO_CHAR (e.fecha,'DD-MM-YYYY') AS fecha, e.estado
                    FROM ldci.tb_entrada AS e
                    JOIN ldci.tb_proveedor AS pr ON e.id_proveedor=pr.id_proveedor
                    order by e.id_entrada desc) as tb";

        $primaryKey = 'id_entrada';
        $columns = [
            ['db' => 'id_entrada', 'dt' => 0],
            ['db' => 'proveedor', 'dt' => 1],
            ['db' => 'monto', 'dt' => 2],
            ['db' => 'fecha', 'dt' => 3],
            ['db' => 'estado', 'dt' => 4]
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

    /**Funcion para Guardar una nueva Entrada */
    function  guardarEntrada($tblDetalleEntrada, $monto, $fecha, $proveedor, $id_session)
    {
        DB::beginTransaction();
        $guardarOk = true;
        $query_entrada = new static;
        $query_entrada = DB::select('INSERT INTO ldci.tb_entrada(
                    id_proveedor, monto, estado, fecha, usuario_grabacion, fecha_grabacion)
                    VALUES ( ?, ?, ?, ?, ?, now()) RETURNING id_entrada', [$proveedor, $monto, 1, $fecha, $id_session]);

        if (empty($query_entrada)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar entrada',
                'error' => true
            ]);
        } else {
            foreach ($tblDetalleEntrada as $entrada) {
                $query_detalle_entrada = new static;
                $query_detalle_entrada = DB::insert('INSERT INTO ldci.tb_detalle_entrada(
                    id_entrada, id_producto, precio, cantidad, estado,  usuario_grabacion, fecha_grabacion)
                    VALUES (?, ?, ?, ?, ?, ?, now())', [$query_entrada[0]->id_entrada, $entrada->id_producto, $entrada->precio, $entrada->Cantidad, 1, $id_session]);

                if (!$query_detalle_entrada) {
                    DB::rollBack();
                    $guardarOk = false;
                    return collect([
                        'mensaje' => 'Hubo un error al guardar el detalle de nueva entrada',
                        'error' => true
                    ]);
                }
            }

            if ($guardarOk) {
                foreach ($tblDetalleEntrada as $existencia) {
                    $query_update_p = new static;
                    $query_update_p = DB::insert('UPDATE ldci.tb_producto SET existencia=existencia+? WHERE id_producto=?', [$existencia->Cantidad, $existencia->id_producto]);

                    if (!$query_update_p) {
                        $guardarOk = false;
                        DB::rollBack();
                        return collect([
                            'mensaje' => 'Hubo un error al actualizar existencia de producto',
                            'error' => true
                        ]);
                    }
                }
                DB::commit();
                return collect([
                    'mensaje' => 'Entrada guardada con exito',
                    'id_entrada' => $query_entrada,
                    'error' => false
                ]);
            }
        }
    }

    /**Funcion para obtener la informacion de una entrada */
    function informacionEntrada($id_entrada)
    {
        $query = new static;
        $query = DB::select("SELECT e.id_entrada,e.id_proveedor,e.monto,e.fecha:: Date as  f_entrada
                    FROM ldci.tb_entrada AS e WHERE e.id_entrada=$id_entrada");
        return $query;
    }

    /**Funcion para obtener detalle de una entrada */
    function getDetalleEntrada($id_entrada)
    {
        $query = new static;
        $query = DB::select("SELECT de.cantidad,de.id_producto,de.precio
                        FROM ldci.tb_detalle_entrada as de WHERE de.id_entrada=$id_entrada");
        return $query;
    }

    /** Funcion para anular una entrada */
    public  function  anularEntrada($id_entrada, $id_session)
    {
        DB::beginTransaction();
        $query_restar_existencia = new static;
        $query_restar_existencia = DB::select('SELECT id_producto, cantidad FROM ldci.tb_detalle_entrada
                                                WHERE id_entrada=?', [$id_entrada]);
        foreach ($query_restar_existencia as $resta) {
            $query_restar = new static;
            $query_restar = DB::select('UPDATE ldci.tb_producto SET existencia=existencia-? WHERE id_producto=? RETURNING existencia', [$resta->cantidad, $resta->id_producto]);

            if ($query_restar[0]->existencia >= 0) {
                $query = new static;
                $query = DB::UPDATE('UPDATE ldci.tb_entrada
                        SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_entrada=?', [$id_session, $id_entrada]);
                if (!$query) {
                    DB::rollBack();
                    return collect([
                        'mensaje' => 'Hubo un error al anular la entrada ',
                        'error' => true,
                    ]);
                } else {
                    $query_detalle_entrada = new static;
                    $query_detalle_entrada = DB::update('UPDATE ldci.tb_detalle_entrada
                            SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                            WHERE id_entrada=?', [$id_session, $id_entrada]);

                    if (!$query_detalle_entrada) {
                        DB::rollBack();
                        return collect([
                            'mensaje' => 'Hubo un error al anular la entrada ',
                            'error' => true,
                        ]);
                    } else {

                        DB::commit();
                        return collect([
                            'mensaje' => 'Entrada anulada con exito',
                            'error' => false,
                        ]);
                    }
                }
            } else {
                return collect([
                    'mensaje' => 'La Entrada No Puede Ser Anulada',
                    'error' => true,
                ]);
            }
        }
    }
}
