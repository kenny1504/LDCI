<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoTransporteModel extends Model
{

    /** Funcion para cargar tabla Tipo Transporte*/
    public function getTipoTransporte()
    {
        $table = "(select id_tipo_transporte,nombre from ldci.tb_tipo_transporte
                where estado=1 order by id_tipo_transporte asc) as tb ";

        $primaryKey = 'id_tipo_transporte';
        $columns = [
            ['db' => 'id_tipo_transporte', 'dt' => 0],
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

    /** Metodo para guardar un nuevo registro de tipo transporte*/
    public function guardarTipoTransporte($id_TipoTransporte,$nombre,$id_session)
    {
        $query = new static;

        if (!empty($id_TipoTransporte)) // si existe un id, actualiza
        {
            $query= DB::UPDATE("UPDATE ldci.tb_tipo_transporte
                                    SET nombre=?, usuario_modificacion=?, fecha_modificacion=now()
                                    WHERE id_tipo_transporte=?",[$nombre,$id_session,$id_TipoTransporte]);
        }
         else
         {
             $query= DB::insert("INSERT INTO ldci.tb_tipo_transporte(
                                 nombre, usuario_grabacion, fecha_grabacion)
                                VALUES ( ?, ?, now())",[$nombre,$id_session]);
         }
        return $query;
    }

    /** Metodo para validar si existe el nombre tipo de transporte */
    public function existe($nombre)
    {
        $query = new static;
        $query = DB::select('select * from ldci.tb_tipo_transporte where upper(nombre)=upper(?) and estado=1' , [$nombre]);
        if(empty($query))
            return false;
        else
            return true;
    }

    /** Metodo para eliminar registro */
    public function eliminar($id_TipoTransporte,$id_session)
    {
        $query = new static;
        $query = DB::UPDATE('UPDATE ldci.tb_tipo_transporte
                                SET estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                                WHERE id_tipo_transporte=?', [$id_session,$id_TipoTransporte]);

        return $query;
    }

}
