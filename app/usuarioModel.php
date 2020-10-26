<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ssp\SSP; /** Libreria para cargar Datatables */

class usuarioModel extends Model
{
   
    /** Metodo para buscar un usario- login */
    public function GetUsuario($password,$user)
    {
        $query = new static;
        $query= DB::select("select * from ldci.tb_usuario where password=? and usuario=?",[$password,$user]);
        return $query;
    }

    /** Metodo para recuperar los datos de usuario logueado */
    public function GetDatosUsuario($id_usuario)
    {
        $query = new static;
        $query= DB::select("select usuario,telefono,correo from ldci.tb_usuario where id_usuario=?;",[$id_usuario]);
        return $query;
    }
    // Este metodo sirve para verificar que no exista
    // otro usuario con el correo solicitado.
    // Return true, si el correo esta disponible; false 
    // si esta ocupado por otro usuario.
    public function ValidaCorreoDuplicado($correo, $usuario)
    {
        $query = new static;
        $query = DB::select('select id_usuario from ldci.tb_usuario where correo = ? and id_usuario != ?', [$correo, $usuario]);
        if(!empty($query))
        {
            // Correo ya esta tomado. Mostramos un mensaje
            return false;
        }
        return true;
    }

    public function ValidaUsuarioDuplicado($usuario)
    {
        $query = new static;
        $query = DB::select('select * from ldci.tb_usuario where usuario = ? ',[$usuario]);
        if(!empty($query))
        {
            // Usuario ya esta tomado. Mostramos un mensaje
            return false;
        }
        return true;
    }

    
    /** Metodo para guardar un nuevo usuario*/
    public function registrarUsuario($password,$user,$correo,$telefono,$codigo_confirmacion)
    {
        $query = new static;
        $query= DB::select("INSERT INTO ldci.tb_usuario(
            usuario, tipo, password,fecha_grabacion,  usuario_grabacion, telefono,codigo_confirmacion, correo)
           VALUES ( ?, ?, ?, now(), ?, ?, ?, ?)",[$user,3,$password,0,$telefono,$codigo_confirmacion,$correo]);
        return $query;
    }

    public function validarcontrasena($id_usuario,$passwordActual)
    {
        $query =  DB::select("SELECT * FROM ldci.tb_usuario WHERE id_usuario = ?", [$id_usuario]);
        if($query[0]->password !== $passwordActual)
           return false;
        return true;
    }

    public function actualizarUsuario($id_usuario, $password,$user,$correo,$telefono,$fecha,$usuario_modifica, $passwordActual, $codigo,$confirmado)
    {
        $query = new static;
        // SI password es vacio 
        if( empty($password))
            $password = $passwordActual;

        $query= DB::statement(
         "UPDATE ldci.tb_usuario 
          SET usuario=?, password=?, telefono=?, 
              correo=?, usuario_modificacion=?, fecha_modificacion=?,
              confirmado=?, codigo_confirmacion=?
          WHERE id_usuario=?",
         [$user, $password, $telefono, $correo, $usuario_modifica,$fecha,$confirmado, $codigo, $id_usuario ]);
        return $query > 0;
        
    }

    public function GetIdByUser($username)
    {
        $query =  DB::select("SELECT id_usuario FROM ldci.tb_usuario WHERE usuario = ?", [$username]);
        return $query[0]->id_usuario;
    }
    
    /** Metodo para verificar correo */
    public function verificarCorreo($codigo_confirmacion)
    {
        $query = new static;
        $query= DB::select("select * from ldci.tb_usuario where codigo_confirmacion=?",[$codigo_confirmacion]);
        return $query;
    }

     /** Metodo para actualizar estado de cuenta de email */
    public function actualizarEstado($id_usuario)
    {
         $query = new static;
         $query= DB::select("UPDATE ldci.tb_usuario
                            SET  fecha_modificacion=now(), usuario_modificacion=0,  confirmado=true, codigo_confirmacion=null
                            WHERE id_usuario=?",[$id_usuario]);
         return $query;
    }

    /** Funcion para cargar tabla usuarios */
    public function getUsuarios()
    {
        $table = "(select id_usuario,usuario,telefono,
                        case confirmado when true then 'Confirmar'
                            else 'Sin confirmar' end as estado_correo
                        ,correo,tipo,
                        case tipo when 1 then 'Admin'
                                    when 2 then 'Vendedor'
                                    when 3 then 'Cliente'
                                    end as tipo_usuario,estado,
                        case estado when 1 then 'Activo'
                                    when -1 then 'Desactivado'
                                end as estado_usuario
                    from ldci.tb_usuario) as tb ";

        $primaryKey = 'id_usuario';
        $columns = [
        ['db' => 'id_usuario', 'dt' => 0],
        ['db' => 'usuario', 'dt' => 1],
        ['db' => 'telefono', 'dt' => 2],
        ['db' => 'estado_correo', 'dt' => 3],
        ['db' => 'correo', 'dt' => 4],
        ['db' => 'tipo', 'dt' => 5],
        ['db' => 'tipo_usuario', 'dt' => 6],
        ['db' => 'estado', 'dt' => 7],
        ['db' => 'estado_usuario', 'dt' => 8]
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
