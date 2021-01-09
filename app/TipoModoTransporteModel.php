<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoModoTransporteModel extends Model
{
    public function getTipoModoTransporte()
    {
        $table = "(select id_tipo_modo_transporte,nombre from ldci.tb_tipo_modo_transporte
                where estado=1 order by id_tipo_modo_transporte asc) as tb ";

        $primaryKey = 'id_tipo_modo_transporte';
        $columns = [
            ['db' => 'id_tipo_modo_transporte', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1]
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

    /** Metodo para guardar un nuevo registro de tipo modo de transporte*/
    public function guardarTipoModoTransporte($id_TipoModoTransporte, $nombre, $id_session)
    {
        $query = new static;

        if (!empty($id_TipoModoTransporte)) // si existe un id, actualiza
        {
            $query = DB::UPDATE("UPDATE ldci.tb_tipo_modo_transporte
                                    SET nombre=?, usuario_modificacion=?, fecha_modificacion=now()
                                    WHERE id_tipo_modo_transporte=?", [$nombre, $id_session, $id_TipoModoTransporte]);
        } else {
            $query = DB::insert("INSERT INTO ldci.tb_tipo_modo_transporte(
                                 nombre, usuario_grabacion, fecha_grabacion)
                                VALUES ( ?, ?, now())", [$nombre, $id_session]);
        }
        return $query;
    }

    /** Metodo para validar si existe el nombre tipo modo transporte */
    public function existe($nombre)
    {
        $query = new static;
        $query = DB::select('select * from ldci.tb_tipo_modo_transporte where upper(nombre)=upper(?)', [$nombre]);
        if (empty($query))
            return false;
        else
            return true;
    }

    /**Metodo para eliminar */
    public function eliminar($id_TipoModoTransporte, $id_session)
    {
        $query = new static;
        $query = DB::UPDATE('UPDATE ldci.tb_tipo_modo_transporte
                                SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                                WHERE id_tipo_modo_transporte=? AND
                                NOT EXISTS (SELECT dc.id_tipo_modo_transporte FROM ldci.tb_detalle_cotizacion AS dc
                                WHERE dc.id_tipo_modo_transporte=?)', [$id_session, $id_TipoModoTransporte, $id_TipoModoTransporte]);

        return $query;
    }
}
