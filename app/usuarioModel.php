<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class usuarioModel extends Model
{

    

    public function GetUsuario($password,$user)
    {
        $query = new static;
        $query= DB::select("select * from lcdi.tb_usuarios where pass=? and usuario=?",[$password,$user]);
        return $query;
    }
   
}
