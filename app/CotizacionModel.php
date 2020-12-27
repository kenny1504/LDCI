<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CotizacionModel extends Model
{
    /** Funcion que recupera todos las ciudades*/
    function getCiudades()
    {
        $query = new static;
        $query = DB::select("select id_ciudad,(ciudad ||','||pais) as ciudad from ldci.vw_ciudades");
        return $query;
    }

    /** Funcion que recupera todos los tipos de transporte*/
    function getTrasnporte()
    {
        $query = new static;
        $query = DB::select('select id_tipo_transporte,nombre from ldci.tb_tipo_transporte where estado=1');
        return $query;
    }

    /** Funcion que recupera todos los modo transporte*/
    function getModoTransporte()
    {
        $query = new static;
        $query = DB::select('select id_tipo_modo_transporte,nombre from ldci.tb_tipo_modo_transporte where estado=1');
        return $query;
    }

    /** Funcion que recupera todos los tipos de mercancia*/
    function getTipoMercancia()
    {
        $query = new static;
        $query = DB::select('select id_tipo_mercancia,nombre from ldci.tb_tipo_mercancia where estado=1');
        return $query;
    }

    /** Funcion que recupera todos los servicios*/
    function getServicios()
    {
        $query = new static;
        $query = DB::select('select id_producto,nombre from ldci.tb_producto where tipo=2 and estado=1');
        return $query;
    }

    function getDatosCotizacion() // prueba para probar tabla en pdf
    {
        $query = new static;
        $query = DB::select("select row_number() OVER (ORDER BY id_producto) AS no, nombre as nombre_producto,
        case tipo when 1
        then 'Producto'
        else 'Servicio' end as tipo, existencia,
    '$' || precio as precio, descripcion
    from ldci.tb_producto where estado=1");

        return $query;
    }
}
