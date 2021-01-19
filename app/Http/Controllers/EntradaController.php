<?php

namespace App\Http\Controllers;

use App\EntradaModel;
use App\ProductoModel;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    /** Funcion que recupera todos los proveedores*/
    public function getProveedores()
    {
        $datos = (new EntradaModel)->getProveedores();
        return response()->json($datos);
    }

    /** Funcion que recupera todos los productos*/
    public function getProductos()
    {
        $datos = (new EntradaModel)->getProductos();
        return response()->json($datos);
    }

    /** Funcion que guardar una entrada*/
    public function guardarEntrada(Request $request)
    {
        $tblDetalleCarga = json_decode($request->tblEntrada);
        $fecha = $request->fecha;
        $proveedor = $request->proveedor;
        $monto = $request->monto;
        $id_session = session('idUsuario');

        $guardar = (new EntradaModel)->guardarEntrada($tblDetalleCarga, $monto, $fecha, $proveedor, $id_session);
        return $guardar;
    }

    /** Funcion para recuperar lista de entradas*/
    public function getEntradas(Request $request)
    {
        $datos = (new EntradaModel)->getEntradas();
        return response()->json($datos);
    }

    /**Funcion para recuperar la informacion de una entrada */
    function informacionEntrada(Request $request)
    {
        $id_entrada = $request->id_entrada;
        $datos = (new EntradaModel)->informacionEntrada($id_entrada);
        return response()->json($datos);
    }

    /** Funcion que recupera detalles de entrada*/
    public function getDetalleEntrada(Request $request)
    {
        $id_entrada = $request->id_entrada;
        $datos = (new EntradaModel)->getDetalleEntrada($id_entrada);
        return response()->json($datos);
    }

    //Funcion para anular una entrada
    public function anularEntrada(Request $request)
    {
        $id_entrada = $request->id_entrada;
        $id_session = session('idUsuario');
        $eliminar = (new EntradaModel)->anularEntrada($id_entrada, $id_session);
        return $eliminar;
    }

    //Funcion para agregar un producto desde entrada
    public function guardarProductoEntrada(Request $request)
    {
        if (isset($request->ck_iva))
            $iva = true;
        else
            $iva = false;
        $id_Producto = 0;
        $nombre = $request->txt_nombre_p_entrada;
        $precio = $request->txt_precio_p_entrada;
        $descripcion = $request->txt_descripcion_p_entrada;
        $existencia = 0;
        $tipo = 1;
        $image = $request->file('file'); //Se recuperan imagenes Byte
        $id_session = session('idUsuario');

        $existe = (new ProductoModel)->existe($nombre, $id_Producto);

        if (!$existe) {
            $guardar = (new ProductoModel)->guardarProducto($id_Producto, strtoupper($nombre), $existencia, $precio, strtoupper($descripcion), $tipo, $iva, $id_session);
            if (!empty($guardar)) {
                /** Recorre Arreglo de imagenes */
                foreach ($image as $imagen) {

                    $imageName = uniqid() . '.' . $imagen->extension();
                    $url = '/images/productos'; //Ruta donde guarda imagenes de productos
                    $imagen->move(public_path('images/productos'), $imageName, 0777, true); //Guarda imagen en servidor

                    $guardarImagen = (new ProductoModel)->guardarImagenProducto($guardar[0]->id_producto, $url, $imageName, $id_session);
                }
                return collect([
                    'mensaje' => 'Producto guardado con exito!',
                    'id_producto_nuevo_entrada' => $guardar,
                    'error' => false,
                ]);
            } else
                return collect([
                    'mensaje' => 'Error al guardar imagen',
                    'error' => true,
                ]);
        } else
            return collect([
                'mensaje' => 'El Producto ya existe',
                'error' => true,
            ]);
    }
}
