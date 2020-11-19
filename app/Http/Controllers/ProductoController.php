<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoModel;

class ProductoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /** Funcion que recupera todos los registros de productos*/
    public function getProducto()
    {
        $datos= (new ProductoModel())->getProducto();
        return response()->json($datos);

    }

    /** Metodo para guardar o actualizar un producto*/
    function guardar(Request $request)
    {
        $id_Producto= $request->id_Producto;
        $nombre=$request->txt_nombre;
        $existencia=$request->txt_existencia;
        $precio=$request->txt_precio;
        $descripcion=$request->txt_descripcion;
        $image= $request->file('file'); //Se recuperan imagenes Byte
        $id_session = session('idUsuario');

        $existe=(new ProductoModel)->existe($nombre,$id_Producto);

        if(!$existe)
        {
            $guardar=(new ProductoModel)->guardarProducto($id_Producto,strtoupper($nombre),$existencia,$precio,strtoupper($descripcion),$id_session);
            if (!empty($guardar))
            {
                /** Recorre Arreglo de imagenes */
                foreach ($image as $imagen) {

                    $imageName=uniqid().'.'.$imagen->extension();
                    $url='/images/productos'; //Ruta donde guarda imagenes de productos
                    $imagen->move(public_path('images/productos'),$imageName,0777,true); //Guarda imagen en servidor

                    $guardarImagen=(new ProductoModel)->guardarImagenProducto($guardar[0]->id_producto,$url,$imageName,$id_session);

                }
                return collect([
                    'mensaje' => 'Registro guardado con exito!',
                    'error' => false,
                ]);
            }
            else
                return collect([
                    'mensaje' => 'Error al guardar imagen',
                    'error' => true,
                ]);
        }
        else
            return collect([
                'mensaje' => 'El Producto ya existe',
                'error' => true,
            ]);
    }

    /** Recupera imagenes de un producto */
    function  getImagen(Request $request)
    {
        $id_producto= $request->id_producto;

        $datos= (new ProductoModel)->getImagen($id_producto);
        return $datos;
    }

    /** Elimina imagen  */
    function  eliminarImagen(Request $request)
    {
        $imagen= $request->imagen;
        $existe=(new ProductoModel)->existeImagen($imagen);

        if($existe)
        {

            $eliminar=(new ProductoModel)->eliminarImagen($imagen);
            if ($eliminar)
            {
                /** Elimina imagen del servidor */
                unlink(public_path('images/productos/'.$imagen));

                return collect([
                    'mensaje' => 'Imagen eliminada con exito!',
                    'error' => false,
                ]);
            }
            else{
                return collect([
                    'mensaje' => 'Error al eliminar imagen',
                    'error' => true,
                ]);
            }
        }
        return collect([
            'mensaje' => '',
            'error' => false,
        ]);
    }

    /** Funcion para eliminar un producto */
    function  eliminar(Request $request)
    {

        $id_Producto= $request->id_Producto;
        $id_session = session('idUsuario');

        $eliminar=(new ProductoModel)->eliminar($id_Producto,$id_session);
        if ($eliminar)
        {
            $datos= (new ProductoModel)->getImagen($id_Producto);

            foreach ($datos as $imagen) {

                /** Elimina imagen de Base de datos */
                $eliminar=(new ProductoModel)->eliminarImagen($imagen->nombre);
                if ($eliminar)
                {
                    /** Elimina imagen del servidor */
                    unlink(public_path('images/productos/'.$imagen->nombre));

                }
                else
                    return collect([
                        'mensaje' => 'Hubo un error al elimina producto!',
                        'error' => true,
                    ]);

            }
            return collect([
                'mensaje' => 'Producto eliminado con exito!',
                'error' => false,
            ]);

        }
        else
        {
            return collect([
                'mensaje' => 'Hubo un error al elimina producto!',
                'error' => true,
            ]);
        }
    }

}
