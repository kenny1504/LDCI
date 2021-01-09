<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TasaCambioModel extends Model
{
    /** Recupera la tasa de cambio del dia */
    function getTasacambio()
    {
        $query = new static;
        $query = DB::select("select monto from ldci.tb_tasa_cambio where fecha ::date=now()::date");
        return $query;
    }

    function setTasacambio($tasa_cambio,$id_session)
    {
        /** Si al tasa de cambio es distinta de 0, inserta */
        if ($tasa_cambio!=0)
        {
            $query = new static;
            $query = DB::select("INSERT INTO ldci.tb_tasa_cambio( monto, fecha, usuario_grabacion, fecha_grabacion)
	                                 VALUES ($tasa_cambio, now(), $id_session, now()) returning  monto");
            return $query;
        }
        else
        {
            $query = new static;
            $query = DB::select("select monto from ldci.tb_tasa_cambio order by id_tasa_cambio desc limit 1");
            return $query;
        }


    }
}
