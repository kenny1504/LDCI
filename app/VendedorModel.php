<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VendedorModel extends Model
{
    /** Recupera todos los departamentos de Nicaragua para cargar select */
    function getDepartamentos()
    {
        $query = new static;
        $query = DB::select('select id_ciudad, nombre from public.tb_ciudades where id_pais=78');
        return $query;
    }

    /** Funcion para cargar tabla vendedores*/
    public function getVendedores()
    {
        $table = "(select v.id_vendedor,p.nombre || p.apellido1 || p.apellido2 as nombre,
                    p.cedula,p.correo,p.telefono_1
                    from ldci.tb_vendedor as v
                    join ldci.tb_persona as p on v.id_persona=p.id_persona
                    where v.estado=1 order by v.id_vendedor asc) as tb ";

        $primaryKey = 'id_vendedor';
        $columns = [
            ['db' => 'id_vendedor', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1],
            ['db' => 'cedula', 'dt' => 2],
            ['db' => 'correo', 'dt' => 3],
            ['db' => 'telefono_1', 'dt' => 4]
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

}
