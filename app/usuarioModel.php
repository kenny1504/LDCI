<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $query= DB::select("select usuario,telefono,password,correo from ldci.tb_usuario where id_usuario=?;",[$id_usuario]);
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
    /** Metodo para guardar un nuevo usuario*/
    public function registrarUsuario($password,$user,$correo,$telefono,$codigo_confirmacion)
    {
        $query = new static;
        $query= DB::select("INSERT INTO ldci.tb_usuario(
            usuario, tipo, password,fecha_grabacion,  usuario_grabacion, telefono,codigo_confirmacion, correo)
           VALUES ( ?, ?, ?, now(), ?, ?, ?, ?)",[$user,3,$password,0,$telefono,$codigo_confirmacion,$correo]);
        return $query;
    }

    public function actualizarUsuario($id_usuario, $password,$user,$correo,$telefono,$fecha,$usuario_modifica,$passwordViejo)
    {
        $q =  DB::select("SELECT * FROM ldci.tb_usuario WHERE id_usuario = ?", [$id_usuario]);
        error_log("Ventana: ".$passwordViejo);
        error_log("DB: ".$q[0]->password);

        if($q[0]->password !== $passwordViejo)
        {
            return collect([
                'mensaje' => 'Contraseñas diferentes',
                'error' => true,
            ]);
        }

        $query = new static;
        $query= DB::statement(
         "UPDATE ldci.tb_usuario 
          SET usuario=?, password=?, telefono=?, 
              correo=?, usuario_modificacion=?, fecha_modificacion=?
          WHERE id_usuario=?",
         [$user, $password, $telefono, $correo, $usuario_modifica,$fecha, $id_usuario]);
        if($query > 0 ) // Guardado
           return DB::select("select usuario,telefono,password,correo from ldci.tb_usuario where id_usuario=?;",[$id_usuario]);
        return collect([
            'mensaje' => 'Error al actualizar',
            'error' => true,
        ]);
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

}
