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
        $table = "(select v.id_vendedor,p.nombre ||' '|| p.apellido1 ||' '|| COALESCE (upper(p.apellido2),'') as nombre,
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
            'host' => $_ENV['DB_HOST'],
            'db' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD']
        );
        return SSP::complex($_POST, $db, $table, $primaryKey, $columns);
    }

    /** Metodo para validar si existe un registro de cedula */
    public function existe($cedula, $id_empleado)
    {
        if (empty($id_empleado))
            $id_empleado = 0;

        $query = new static;
        $query = DB::select('select * from ldci.tb_persona p
                     left join ldci.tb_vendedor v on v.id_persona=p.id_persona
                     where upper(cedula)=upper(?) and v.estado=1 and v.id_vendedor!=?', [$cedula, $id_empleado]);

        if (empty($query))
            return false;
        else
            return true;
    }

    /** Funcion para guardar un vendedor */
    public function guardar($nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $nomb_notifica, $estado_civil, $telefono_not, $edad, $correo, $sexo, $id_session)
    {
        DB::beginTransaction();

        $query_persona = new static;
        $query_persona = DB::select('INSERT INTO ldci.tb_persona(
        nombre, apellido1, apellido2, direccion, correo, edad,sexo, id_departamento,
        telefono_1, telefono_2, iso, iso_2, cedula,usuario_grabacion, fecha_grabacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, now()) RETURNING id_persona', [$nombres, $apellido1, $apellido2, $direccion, $correo, $edad, $sexo, $departamento, $telefono_1, $telefono_2, "ni", "ni", $cedula, $id_session]);

        if (empty($query_persona)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar vendedor',
                'error' => true,
            ]);
        } else {
            $query_vendedor = new static;
            $query_vendedor = DB::select('INSERT INTO ldci.tb_vendedor(
            id_persona, estado_civil, contacto_emergencia,
            telefono_emergencia, usuario_grabacion, fecha_grabacion)
            VALUES ( ?, ?, ?, ?, ?, now()) RETURNING id_vendedor', [$query_persona[0]->id_persona, $estado_civil, $nomb_notifica, $telefono_not, $id_session]);

            if (empty($query_vendedor)) {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al guardar vendedor',
                    'error' => true,
                ]);
            } else {
                DB::commit();
                return collect([
                    'mensaje' => 'vendedor guardado con exito',
                    'error' => false,
                ]);
            }
        }
    }

    public function getDatosVendedor($id_vendedor)
    {

        $query = new static;
        $query = DB::select('select p.nombre,p.apellido1,upper(p.apellido2) as apellido2,ltrim(p.sexo) as sexo,v.estado_civil,p.cedula,p.correo,
                                        p.direccion,p.id_departamento,p.telefono_1,p.telefono_2,v.contacto_emergencia,v.telefono_emergencia,
                                        ((((SUBSTRING(cedula FROM 9 FOR 2)) :: integer)+1900)-(select extract(year from now())))*(-1) as edad
                                        from ldci.tb_vendedor v
                                        join ldci.tb_persona p on v.id_persona=p.id_persona
                                        where  id_vendedor=? and v.estado=1', [$id_vendedor]);

        return $query;
    }

    /** funcion para cargar tabla en reporte vendedores */
    public function getDatosVendedores()
    {

        $query = new static;
        $query = DB::select("select row_number() OVER (ORDER BY p.id_persona) AS no, (nombre ||' '|| apellido1 ||' '|| coalesce(upper(apellido2),'') ) as nombre,
                cedula,sexo, case when (SUBSTRING(cedula FROM 9 FOR 2)) :: integer>40 then
                       ((((SUBSTRING(cedula FROM 9 FOR 2)) :: integer)+1900)-(select extract(year from now())))*(-1)
                        else ((((SUBSTRING(cedula FROM 9 FOR 2)) :: integer)+2000)-(select extract(year from now())))*(-1)
                       end as edad,telefono_1,coalesce(telefono_2 ::varchar,' ') as telefono_2,direccion,correo
                from ldci.tb_vendedor v
                join ldci.tb_persona p on v.id_persona=p.id_persona where v.estado=1");

        return $query;
    }

    /** Funcion para actualizar un vendedor */
    public function actualizar($id_empleado, $nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $nomb_notifica, $estado_civil, $telefono_not, $edad, $correo, $sexo, $id_session)
    {
        if ($correo != null) {
            $query_correo = new static;
            $query_correo = DB::select('SELECT p.correo from ldci.tb_persona as p
                                JOIN ldci.tb_vendedor AS v ON v.id_persona=p.id_persona
                                WHERE v.id_vendedor= ?', [$id_empleado]);
            $query_update = new static;
            $query_update = DB::update('UPDATE ldci.tb_usuario
                        SET correo=?
                        WHERE correo=?', [$correo, $query_correo[0]->correo]);
        }
        DB::beginTransaction();

        $query_vendedor = new static;
        $query_vendedor = DB::update('UPDATE ldci.tb_vendedor
                        SET estado_civil=?, contacto_emergencia=?,
                        telefono_emergencia=?, usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_vendedor=?', [$estado_civil, $nomb_notifica, $telefono_not, $id_session, $id_empleado]);

        if (!$query_vendedor) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al actualizar vendedor ',
                'error' => true,
            ]);
        } else {
            $query_persona = new static;
            $query_persona = DB::update('UPDATE  ldci.tb_persona p
            SET nombre=?, apellido1=?, apellido2=?, direccion=?, correo=?,
            id_departamento=?, telefono_1=?, telefono_2=?,
            cedula=?, sexo=?,usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_persona=(select id_persona from ldci.tb_vendedor where id_vendedor=? limit 1)', [$nombres, $apellido1, $apellido2, $direccion, $correo, $departamento, $telefono_1, $telefono_2, $cedula, $sexo, $id_session, $id_empleado]);

            if (!$query_persona) {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al actualizar vendedor ',
                    'error' => true,
                ]);
            } else {
                DB::commit();
                return collect([
                    'mensaje' => 'vendedor actualizado con exito',
                    'error' => false,
                ]);
            }
        }
    }

    /** Funcion para eliminar un vendedor */
    public function eliminar($id_empleado, $id_session)
    {
        DB::beginTransaction();

        $query_vendedor = new static;
        $query_vendedor = DB::update('UPDATE ldci.tb_vendedor
                        SET  estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_vendedor=? AND
                        NOT EXISTS ( SELECT * FROM ldci.tb_usuario as u
                            JOIN ldci.tb_persona as p on p.correo=u.correo
                            JOIN ldci.tb_vendedor as v on v.id_persona= p.id_persona
                            JOIN ldci.tb_vendedor_cotizacion as vc on vc.id_usuario=u.id_usuario
                            WHERE v.id_vendedor=?)', [$id_session, $id_empleado, $id_empleado]);

        if (!$query_vendedor) {
            DB::rollBack();
            return collect([
                'mensaje' => 'El vendedor no puede ser Eliminado',
                'error' => true,
            ]);
        } else {
            $query_persona = new static;
            $query_persona = DB::update('UPDATE ldci.tb_persona
                SET  estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                WHERE id_persona=(select id_persona from ldci.tb_vendedor where id_vendedor=? limit 1)', [$id_session, $id_empleado]);

            if (!$query_persona) {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al eliminar vendedor ',
                    'error' => true,
                ]);
            } else {
                DB::commit();
                return collect([
                    'mensaje' => 'vendedor eliminado con exito',
                    'error' => false,
                ]);
            }
        }
    }

    /** funcion para validar correo de vendedor */
    public function correo($correo)
    {
        $query = new static;
        $query = DB::select('select  usuario,p.correo from ldci.tb_usuario u
                            left join ldci.tb_persona p on p.correo=u.correo and p.estado=1
                            left join ldci.tb_vendedor v on v.id_persona=p.id_persona
                            where u.correo=? and u.tipo=2', [$correo]);

        return $query;
    }
}
