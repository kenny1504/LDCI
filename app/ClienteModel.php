<?php

namespace App;

use App\ssp\SSP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClienteModel extends Model
{

    /** Funcion para cargar tabla clientes*/
    public function getClientes()
    {
        $table = "(select c.id_cliente, case c.tipo when 1
                    then p.nombre ||' '|| p.apellido1 ||' '|| COALESCE (p.apellido2,'')
                    else c.nombre_empresa end as nombre,
                    case c.tipo when 1
                    then p.cedula
                    else c.ruc end as identificacion,
                    case c.tipo when 1
                    then p.telefono_2
                    else p.telefono_1 end as contacto,
                    p.correo,c.tipo
                from ldci.tb_cliente as c
                join ldci.tb_persona as p on c.id_persona=p.id_persona
                where c.estado=1 order by c.id_cliente desc) as tb ";

        $primaryKey = 'id_cliente';
        $columns = [
            ['db' => 'id_cliente', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1],
            ['db' => 'identificacion', 'dt' => 2],
            ['db' => 'correo', 'dt' => 3],
            ['db' => 'contacto', 'dt' => 4],
            ['db' => 'tipo', 'dt' => 5]
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

    public function getDatosCliente($id_cliente)
    {

        $query = new static;
        $query = DB::select('select p.id_persona, p.nombre,p.apellido1,p.apellido2,p.cedula,p.correo,p.id_departamento,
                                       p.iso,p.iso_2,p.sexo,p.direccion,p.telefono_1,p.telefono_2,c.ruc,c.nombre_empresa
                                       ,c.giro_negocio,c.tipo,c.extranjero,
                                       ((((SUBSTRING(cedula FROM 9 FOR 2)) :: integer)+1900)-(select extract(year from now())))*(-1) as edad
                                from ldci.tb_cliente as c
                                join ldci.tb_persona as p on c.id_persona=p.id_persona
                                where c.estado=1 and id_cliente=?', [$id_cliente]);

        return $query;
    }

    /** Metodo para validar si existe un registro de cedula y/o Ruc */
    public function existe($cedula, $ruc, $id_cliente)
    {
        if (empty($id_cliente))
            $id_cliente = 0;

        $query = new static;
        $query = DB::select('select * from ldci.tb_persona p
                    left join ldci.tb_cliente c on c.id_persona=p.id_persona
                     where (upper(p.cedula)=upper(?) or upper(c.ruc)=upper(?))  and c.estado=1 and c.id_cliente!=?', [$cedula, $ruc, $id_cliente]);

        if (empty($query))
            return false;
        else
            return true;
    }

    /** Funcion para guardar un cliente */
    public function guardar($giro_Negocio, $nombre_Empresa, $ruc, $nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $edad, $correo, $sexo, $tipo, $id_session, $iso2, $iso, $extranjero)
    {
        DB::beginTransaction();

        $query_persona = new static;
        $query_persona = DB::select('INSERT INTO ldci.tb_persona(
        nombre, apellido1, apellido2, direccion, correo, edad,sexo, id_departamento,
        telefono_1, telefono_2, iso, iso_2, cedula,usuario_grabacion, fecha_grabacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, now()) RETURNING id_persona', [$nombres, $apellido1, $apellido2, $direccion, $correo, $edad, $sexo, $departamento, $telefono_1, $telefono_2, $iso, $iso2, $cedula, $id_session]);

        if (empty($query_persona)) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar cliente',
                'error' => true,
            ]);
        } else {
            $query_cliente = new static;
            $query_cliente = DB::select('INSERT INTO ldci.tb_cliente(
            id_persona, nombre_empresa, giro_negocio, ruc, tipo, extranjero,
             usuario_grabacion, fecha_grabacion)
            VALUES (?, ?, ?, ?, ?, ?,?, now())', [$query_persona[0]->id_persona, $nombre_Empresa, $giro_Negocio, $ruc, $tipo, $extranjero, $id_session]);

            if (empty($query_cliente)) {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al guardar cliente',
                    'error' => true,
                ]);
            } else {
                DB::commit();
                return collect([
                    'mensaje' => 'cliente guardado con exito',
                    'error' => false,
                ]);
            }
        }
    }

    /** Funcion para actualizar un cliente */
    public function actualizar($id_cliente, $giro_Negocio, $nombre_Empresa, $ruc, $nombres, $apellido1, $apellido2, $cedula, $direccion, $departamento, $telefono_1, $telefono_2, $sexo, $tipo, $id_session, $iso2, $iso, $extranjero)
    {
        DB::beginTransaction();

        $query_cliente = new static;
        $query_cliente = DB::update('UPDATE ldci.tb_cliente
                        SET  nombre_empresa=?, giro_negocio=?, ruc=?, tipo=?, extranjero=?,
                        usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_cliente=?', [$nombre_Empresa, $giro_Negocio, $ruc, $tipo, $extranjero, $id_session, $id_cliente]);

        if (!$query_cliente) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al actualizar cliente ',
                'error' => true,
            ]);
        } else {
            $query_persona = new static;
            $query_persona = DB::update('UPDATE  ldci.tb_persona p
            SET nombre=?, apellido1=?, apellido2=?, direccion=?,
            id_departamento=?, telefono_1=?, telefono_2=?,iso=?,iso_2=?,
            cedula=?, sexo=?,usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_persona=(select id_persona from ldci.tb_cliente where id_cliente=? limit 1)', [$nombres, $apellido1, $apellido2, $direccion, $departamento, $telefono_1, $telefono_2, $iso, $iso2, $cedula, $sexo, $id_session, $id_cliente]);

            if (!$query_persona) {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al actualizar cliente ',
                    'error' => true,
                ]);
            } else {
                DB::commit();
                return collect([
                    'mensaje' => 'cliente actualizado con exito',
                    'error' => false,
                ]);
            }
        }
    }

    /** Funcion para eliminar un cliente */
    public function eliminar($id_cliente, $id_session)
    {
        DB::beginTransaction();

        $query_vendedor = new static;
        $query_vendedor = DB::update('UPDATE ldci.tb_cliente
                        SET  estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_cliente=?', [$id_session, $id_cliente]);

        if (!$query_vendedor) {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al eliminar cliente ',
                'error' => true,
            ]);
        } else {
            $query_persona = new static;
            $query_persona = DB::update('UPDATE ldci.tb_persona
                SET  estado=-1, usuario_modificacion=?, fecha_modificacion=now()
                WHERE id_persona=(select id_persona from ldci.tb_cliente where id_cliente=? limit 1)', [$id_session, $id_cliente]);

            if (!$query_persona) {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al eliminar cliente ',
                    'error' => true,
                ]);
            } else {
                DB::commit();
                return collect([
                    'mensaje' => 'cliente eliminado con exito',
                    'error' => false,
                ]);
            }
        }
    }

    /** Funcion para validar el correo asociado a un usuario*/
    public function correo($correo)
    {

        $query = new static;
        $query = DB::select('select  usuario,p.correo from ldci.tb_usuario u
                            left join ldci.tb_persona p on p.correo=u.correo and p.estado=1
                            left join ldci.tb_cliente c on c.id_persona=p.id_persona
                            where u.correo=? and u.tipo=3', [$correo]);

        return $query;
    }

    /** funcion para cargar tabla en reporte clientes */
    public function getDatosClientes()
    {

        $query = new static;
        $query = DB::select("select row_number() OVER (ORDER BY p.id_persona) AS no, case c.tipo when 1
        then p.nombre ||' '|| p.apellido1 ||' '|| COALESCE (p.apellido2,'')
        else c.nombre_empresa end as nombre,
        case c.tipo when 1
        then p.cedula
        else c.ruc end as identificacion,
        case c.tipo when 1
        then 'Natural'
        else 'Juridico' end as Tipo,
        case c.extranjero when TRUE
        then 'Extranjero'
        else 'Nacional' end as Ciudadania,
        case c.tipo when 2
        then p.telefono_1 end as Telefono_Empresarial,
    telefono_2 as telefono_contacto,giro_negocio,correo
    from ldci.tb_cliente c
    join ldci.tb_persona p on c.id_persona=p.id_persona where c.estado=1");

        return $query;
    }
}
