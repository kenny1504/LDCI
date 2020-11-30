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
                    p.correo
                from ldci.tb_cliente as c
                join ldci.tb_persona as p on c.id_persona=p.id_persona
                where c.estado=1 order by c.id_cliente desc) as tb ";

        $primaryKey = 'id_cliente';
        $columns = [
            ['db' => 'id_cliente', 'dt' => 0],
            ['db' => 'nombre', 'dt' => 1],
            ['db' => 'identificacion', 'dt' => 2],
            ['db' => 'correo', 'dt' => 3],
            ['db' => 'contacto', 'dt' => 4]
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

    /** Metodo para validar si existe un registro de cedula y/o Ruc */
    public function existe($cedula,$ruc,$id_cliente)
    {
        if (empty($id_cliente))
            $id_cliente=0;

        $query = new static;
        $query = DB::select('select * from ldci.tb_persona p
                    left join ldci.tb_cliente c on c.id_persona=p.id_persona
                     where (upper(p.cedula)=upper(?) or upper(c.ruc)=upper(?))  and c.estado=1 and c.id_cliente!=?', [$cedula,$ruc,$id_cliente]);

        if(empty($query))
            return false;
        else
            return true;
   }


    /** Funcion para guardar un cliente */
    public function guardar($giro_Negocio,$nombre_Empresa,$ruc,$nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$edad,$correo,$sexo,$tipo,$id_session)
    {
        DB::beginTransaction();

        $query_persona = new static;
        $query_persona = DB::select('INSERT INTO ldci.tb_persona(
        nombre, apellido1, apellido2, direccion, correo, edad,sexo, id_departamento,
        telefono_1, telefono_2, iso, iso_2, cedula,usuario_grabacion, fecha_grabacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, now()) RETURNING id_persona', [$nombres,$apellido1,$apellido2,$direccion,$correo,$edad,$sexo,$departamento,$telefono_1,$telefono_2,"ni","ni",$cedula,$id_session]);

        if (empty($query_persona))
        {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al guardar cliente',
                'error' => true,
            ]);
        }
        else
        {
            $query_cliente = new static;
            $query_cliente = DB::select('INSERT INTO ldci.tb_cliente(
            id_persona, nombre_empresa, giro_negocio, ruc, tipo,
             usuario_grabacion, fecha_grabacion)
            VALUES (?, ?, ?, ?, ?, ?, now())', [$query_persona[0]->id_persona,$nombre_Empresa,$giro_Negocio,$ruc,$tipo,$id_session]);

            if (empty($query_cliente))
            {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al guardar cliente',
                    'error' => true,
                ]);
            }
            else
            {
                DB::commit();
                return collect([
                    'mensaje' => 'cliente guardado con exito',
                    'error' => false,
                ]);
            }
        }
    }


    /** Funcion para actualizar un cliente */
    public function actualizar($id_cliente,$giro_Negocio,$nombre_Empresa,$ruc,$nombres,$apellido1,$apellido2,$cedula,$direccion,$departamento,$telefono_1,$telefono_2,$correo,$sexo,$tipo,$id_session)
    {
        DB::beginTransaction();

        $query_cliente = new static;
        $query_cliente = DB::update('UPDATE ldci.tb_cliente
                        SET  nombre_empresa=?, giro_negocio=?, ruc=?, tipo=?,
                        usuario_modificacion=?, fecha_modificacion=now()
                        WHERE id_cliente=?',[$nombre_Empresa,$giro_Negocio,$ruc,$tipo,$id_session,$id_cliente]);

        if (!$query_cliente)
        {
            DB::rollBack();
            return collect([
                'mensaje' => 'Hubo un error al actualizar cliente ',
                'error' => true,
            ]);
        }
        else
        {
            $query_persona = new static;
            $query_persona = DB::update('UPDATE  ldci.tb_persona p
            SET nombre=?, apellido1=?, apellido2=?, direccion=?, correo=?,
            id_departamento=?, telefono_1=?, telefono_2=?,
            cedula=?, sexo=?,usuario_modificacion=?, fecha_modificacion=now()
            WHERE id_persona=(select id_persona from ldci.tb_cliente where id_cliente=? limit 1)', [$nombres,$apellido1,$apellido2,$direccion,$correo,$departamento,$telefono_1,$telefono_2,$cedula,$sexo,$id_session,$id_empleado]);

            if (!$query_persona)
            {
                DB::rollBack();
                return collect([
                    'mensaje' => 'Hubo un error al actualizar cliente ',
                    'error' => true,
                ]);
            }
            else
            {
                DB::commit();
                return collect([
                    'mensaje' => 'cliente actualizado con exito',
                    'error' => false,
                ]);
            }

        }

    }
}
