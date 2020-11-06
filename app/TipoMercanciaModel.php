<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoMercanciaModel extends Model
{
    public function getTipoMercancia()
    {
        $table = "(select id_tipo_mercancia,nombre from ldci.tb_tipo_mercancia
                where estado=1 order by id_tipo_mercancia asc) as tb ";

        $primaryKey = 'id_tipo_mercancia';
        $columns = [
            ['db' => 'id_tipo_mercancia', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1]
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
    /** Metodo para guardar un nuevo registro de tipo mercancia*/
    public function guardarTipoMercancia($id_TipoMercancia,$nombre,$id_session)
    {
        $query = new static;

        if (!empty($id_TipoMercancia)) // si existe un id, actualiza
        {
            $query= DB::UPDATE("UPDATE ldci.tb_tipo_mercancia
                                    SET nombre=?, usuario_modificacion=?, fecha_modificacion=now()
                                    WHERE id_tipo_mercancia=?",[$nombre,$id_session,$id_TipoMercancia]);
        }
         else
         {
             $query= DB::insert("INSERT INTO ldci.tb_tipo_mercancia(
                                 nombre, usuario_grabacion, fecha_grabacion)
                                VALUES ( ?, ?, now())",[$nombre,$id_session]);
         }
        return $query;
    }

    /** Metodo para validar si existe el nombre tipo de mercancia */
    public function existe($nombre)
    {
        $query = new static;
        $query = DB::select('select * from ldci.tb_tipo_mercancia where upper(nombre)=upper(?)', [$nombre]);
        if(empty($query))
            return false;
        else
            return true;
    }

    /** Metodo para eliminar registro */
    public function eliminar($id_TipoMercancia,$id_session)
    {
        $query = new static;
        $query = DB::UPDATE('UPDATE ldci.tb_tipo_mercancia
                                SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                                WHERE id_tipo_mercancia=?', [$id_session,$id_TipoMercancia]);

        return $query;
    }
}
