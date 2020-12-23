<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProveedorModel extends Model
{
    /** Funcion para cargar tabla proveedores*/
    public function getProveedores()
    {
        $table = "(select id_proveedor, nombre,correo,telefono_1
                    from ldci.tb_proveedor
                    where estado=1 order by id_proveedor asc) as tb ";
        $primaryKey = 'id_proveedor';
        $columns = [
            ['db' => 'id_proveedor', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1],
            ['db' => 'correo', 'dt' => 2],
            ['db' => 'telefono_1', 'dt' => 3]
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

    public function getPaises()
    {
        $query = new static;
        $query = DB::select('select id_pais, nombre from public.tb_paises order by nombre asc');
        return $query;
    }

    /** Funcion para guardar un proveedor */
    public function guardar($nombre, $correo, $direccion, $pais, $pagina_web, $telefono_1, $telefono_2, $iso, $iso2, $id_session)
    {
        DB::beginTransaction();
        $query_proveedor = new static;
        $query_proveedor = DB::select('INSERT INTO ldci.tb_proveedor(
        nombre, correo, direccion, id_pais, pagina_web,
        telefono_1, telefono_2, iso, iso_2 ,usuario_grabacion, fecha_grabacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', [$nombre, $correo, $direccion, $pais, $pagina_web, $telefono_1, $telefono_2, $iso, $iso2, $id_session]);
        if (empty($query_proveedor)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar el proveedor',
                'error' => true,
            ]);
        } else {
            DB::commit();
            return collect([
                'mensaje' => 'Proveedor guardado con exito',
                'error' => false,
            ]);
        }
    }

    public function getDatosProveedor($id_proveedor)
    {
        $query = new static;
        $query = DB::select('select nombre, correo,direccion,id_pais,pagina_web,
                                        telefono_1,telefono_2,iso,iso_2
                                        from ldci.tb_proveedor
                                        where  id_proveedor=? and estado=1', [$id_proveedor]);
        return $query;
    }

    /** Metodo para validar si existe un registro de cedula */
    public function existe($correo, $id_proveedor)
    {
        if (empty($id_proveedor))
            $id_proveedor = 0;

        $query = new static;
        $query = DB::select('select * from ldci.tb_proveedor
                    where upper(correo)=upper(?) and estado=1 and id_proveedor!=?', [$correo, $id_proveedor]);

        if (empty($query))
            return false;
        else
            return true;
    }

    /** Funcion para actualizar un proveedor */
    public function actualizar($id_proveedor, $nombre, $correo, $direccion, $pais, $pagina_web, $telefono_1, $telefono_2, $iso, $iso2, $id_session)
    {
        DB::beginTransaction();

        $query_proveedor = new static;
        $query_proveedor = DB::update('UPDATE  ldci.tb_proveedor
            SET nombre=?, correo=?, direccion=?, id_pais=?, pagina_web=?,
            telefono_1=?, telefono_2=?, iso=?, iso_2=?,
            usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_proveedor=? ', [$nombre, $correo, $direccion, $pais, $pagina_web, $telefono_1, $telefono_2, $iso, $iso2, $id_session, $id_proveedor]);

        if (!$query_proveedor) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al actualizar los datos del proveedor ',
                'error' => true,
            ]);
        } else {
            DB::commit();
            return collect([
                'mensaje' => 'proveedor actualizado con exito',
                'error' => false,
            ]);
        }
    }

    /** Funcion para eliminar(deshabilitar) un proveedor */
    public function eliminar($id_proveedor, $id_session)
    {
        DB::beginTransaction();

        $query_proveedor = new static;
        $query_proveedor = DB::update('UPDATE ldci.tb_proveedor
                        SET  estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_proveedor=?', [$id_session, $id_proveedor]);

        if (!$query_proveedor) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al eliminar el proveedor ',
                'error' => true,
            ]);
        } else {
            DB::commit();
            return collect([
                'mensaje' => 'proveedor eliminado con exito',
                'error' => false,
            ]);
        }
    }
}
