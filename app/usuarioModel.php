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
        $query= DB::select("select * from lcdi.tb_usuarios where pass=? and usuario=?",[$password,$user]);
        return $query;
    }

    /** Metodo para recuperar los datos de usuario logueado */
    public function GetDatosUsuario($id_usuario)
    {
        $query = new static;
        $query= DB::select("select usuario,nombre,telefono,pass from lcdi.tb_usuarios where id_usuario=?;",[$id_usuario]);
        return $query;
    }
   
}
