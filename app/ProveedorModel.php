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
        $table = "(select pr.id_proveedor,CONCAT(p.nombre ,' ', p.apellido1 ,' ', p.apellido2) as nombre,
                    p.cedula,p.correo,p.telefono_1
                    from ldci.tb_proveedor as pr
                    join ldci.tb_persona as p on pr.id_persona=p.id_persona
                    where pr.estado=1 order by pr.id_proveedor asc) as tb ";
        $primaryKey = 'id_proveedor';
        $columns = [
            ['db' => 'id_proveedor', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1],
            ['db' => 'cedula', 'dt' => 2],
            ['db' => 'correo', 'dt' => 3],
            ['db' => 'telefono_1', 'dt' => 4]
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
    /** Metodo para validar si existe un registro de cedula */
    public function existe($cedula, $id_proveedor)
    {
        if (empty($id_proveedor))
            $id_proveedor = 0;
        $query = new static;
        $query = DB::select('select * from ldci.tb_persona p
                    left join ldci.tb_proveedor pr on pr.id_persona=p.id_persona
                    where upper(cedula)=upper(?) and pr.estado=1 and pr.id_proveedor!=?', [$cedula, $id_proveedor]);
        if (empty($query))
            return false;
        else
            return true;
    }

    /** Funcion para guardar un proveedor */
    public function guardar($nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $edad, $correo, $sexo, $iso, $iso2, $id_session)
    {
        DB::beginTransaction();
        $query_persona = new static;
        $query_persona = DB::select('INSERT INTO ldci.tb_persona(
        nombre, apellido1, apellido2, direccion, correo, edad, sexo, id_departamento,
        telefono_1, telefono_2, iso, iso_2, cedula,usuario_grabacion, fecha_grabacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, now()) RETURNING id_persona', [$nombres, $apellido1, $apellido2, $direccion, $correo, $edad, $sexo, $departamento, $telefono_1, $telefono_2, $iso, $iso2, $cedula, $id_session]);
        if (empty($query_persona)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar el proveedor',
                'error' => true,
            ]);
        } else {
            $query_proveedor = new static;
            $query_proveedor = DB::select('INSERT INTO ldci.tb_proveedor(
            id_persona, usuario_grabacion, fecha_grabacion)
            VALUES ( ?, ?, now()) RETURNING id_proveedor', [$query_persona[0]->id_persona, $id_session]);

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
    }

    public function getDatosProveedor($id_proveedor)
    {
        $query = new static;
        $query = DB::select('select p.nombre,p.apellido1,p.apellido2,edad,ltrim(p.sexo) as sexo,p.cedula,p.correo,
                                        p.iso,p.iso_2,p.direccion,p.id_departamento,p.telefono_1,p.telefono_2
                                        from ldci.tb_proveedor pr
                                        join ldci.tb_persona p on pr.id_persona=p.id_persona
                                        where  id_proveedor=? and pr.estado=1', [$id_proveedor]);
        return $query;
    }

    /** Funcion para actualizar un proveedor */
    public function actualizar($id_proveedor, $nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $edad, $correo, $sexo, $iso, $iso2, $id_session)
    {
        DB::beginTransaction();

        $query_persona = new static;
        $query_persona = DB::update('UPDATE  ldci.tb_persona p
            SET nombre=?, apellido1=?, apellido2=?, direccion=?, correo=?,
            id_departamento=?, telefono_1=?, telefono_2=?,edad=?,iso=?, iso_2=?,
            cedula=?, sexo=?,usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_persona=(select id_persona from ldci.tb_proveedor where id_proveedor=? limit 1)', [$nombres, $apellido1, $apellido2, $direccion, $correo, $departamento, $telefono_1, $telefono_2, $edad, $iso, $iso2, $cedula, $sexo, $id_session, $id_proveedor]);

        if (!$query_persona) {
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
            $query_persona = new static;
            $query_persona = DB::update('UPDATE ldci.tb_persona
                SET  estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                WHERE id_persona=(select id_persona from ldci.tb_proveedor where id_proveedor=? limit 1)', [$id_session, $id_proveedor]);
            if (!$query_persona) {
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
}
