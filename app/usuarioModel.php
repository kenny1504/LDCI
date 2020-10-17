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
        $query= DB::select("select * from ldci.tb_usuarios where pass=? and usuario=?",[$password,$user]);
        return $query;
    }

    /** Metodo para recuperar los datos de usuario logueado */
    public function GetDatosUsuario($id_usuario)
    {
        $query = new static;
        $query= DB::select("select usuario,telefono,pass from ldci.tb_usuarios where id_usuario=?;",[$id_usuario]);
        return $query;
    }

    /** Metodo para guardar un nuevo usuario*/
    public function registrarUsuario($password,$user,$correo,$telefono,$codigo_confirmacion)
    {
        $query = new static;
        $query= DB::select("INSERT INTO ldci.tb_usuarios(
            usuario, tipo, pass,fecha_grabacion,  usuario_grabacion, telefono,codigo_confirmacion, correo)
           VALUES ( ?, ?, ?, now(), ?, ?, ?, ?)",[$user,3,$password,0,$telefono,$codigo_confirmacion,$correo]);
        return $query;
    }
    
    /** Metodo para verificar correo */
    public function verificarCorreo($codigo_confirmacion)
    {
        $query = new static;
        $query= DB::select("select * from ldci.tb_usuarios where codigo_confirmacion=?",[$codigo_confirmacion]);
        return $query;
    }

     /** Metodo para actualizar estado de cuenta de email */
     public function actualizarEstado($id_usuario)
     {
         $query = new static;
         $query= DB::select("UPDATE ldci.tb_usuarios
                            SET  fecha_modificacion=now(), usuario_modifica=0,  confirmado=true, codigo_confirmacion=null
                            WHERE id_usuario=?",[$id_usuario]);
         return $query;
     }

}
