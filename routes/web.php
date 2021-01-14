<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** Ruta para retornar cualquier template */
Route::post('/', 'TemplateController@template');

Route::post('/registro/usuario', 'InicioController@guardarUsuario')->name('guardar_usuario');
Route::post('/datos/modificaUsuario', 'InicioController@editarUsuario')->name('editar_usuario');
Route::post('/datos/usuario', 'InicioController@getUsuario');
Route::post('/login/in', 'InicioController@login')->name('login-in');

// Rutas Get Unicas
Route::get('/registro/vericar/{code}', 'InicioController@verificar')->name('Vericada'); //Ruta para verificar correo
Route::get('/usuarios', 'UsuarioController@index')->name('Usuarios');
Route::get('/registro', 'InicioController@registro')->name('registro');
Route::get('/', 'InicioController@index');
Route::get('/login', 'InicioController@loginOut')->name('login');
Route::get('/home', 'HomeController@index')->name('home');

//Rutas Usuarios
Route::post('/usuarios/getAll', 'UsuarioController@getUsuarios')->name('getAll');
Route::post('/usuarios/estado', 'UsuarioController@cambiarEstado');
Route::post('/usuarios/guardar', 'UsuarioController@guardar');
Route::post('/usuario/resetpassword', 'UsuarioController@ressetpassword');


//Rutas Tipo Transporte
Route::post('/tipoTransporte/getAll', 'TipoTransporteController@getTipoTransporte')->name('getAll');
Route::post('/tipoTransporte/guardar', 'TipoTransporteController@guardar')->name('guardar');
Route::post('/tipoTransporte/eliminar', 'TipoTransporteController@eliminar')->name('eliminar');

//Rutas Tipo Modo Transporte
Route::post('/tipoModoTransporte/getAll', 'TipoModoTransporteController@getTipoModoTransporte')->name('getAll');
Route::post('/tipoModoTransporte/guardar', 'TipoModoTransporteController@guardar')->name('guardar');
Route::post('/tipoModoTransporte/eliminar', 'TipoModoTransporteController@eliminar')->name('eliminar');


//Rutas Tipo Mercancia
Route::post('/tipoMercancia/getAll', 'TipoMercanciaController@getTipoMercancia')->name('getAll');
Route::post('/tipoMercancia/guardar', 'TipoMercanciaController@guardar')->name('guardar');
Route::post('/tipoMercancia/eliminar', 'TipoMercanciaController@eliminar')->name('eliminar');

//Rutas Vendedor
Route::post('/departamentos/getAll', 'VendedorController@getDepartamentos')->name('getAll');
Route::post('/vendedor/getAll', 'VendedorController@getVendedores')->name('getAll');
Route::post('/vendedor/guardar', 'VendedorController@guardar')->name('guardar');
Route::post('/vendedor/datos', 'VendedorController@getDatosVendedor')->name('vendedor');
Route::post('/vendedor/eliminar', 'VendedorController@eliminar')->name('eliminar');
Route::post('/vendedor/correo', 'VendedorController@validacorreo')->name('validar');

//Rutas Producto
Route::post('/producto/getAll', 'ProductoController@getProducto')->name('getAll');
Route::post('/producto/guardar', 'ProductoController@guardar')->name('guardarProducto');
Route::post('/producto/fotos', 'ProductoController@getImagen')->name('fotos');
Route::post('/producto/eliminarImagen', 'ProductoController@eliminarImagen')->name('eliminarImagen');
Route::post('/producto/eliminar', 'ProductoController@eliminar')->name('eliminar');

//Rutas producto Vista Usuario
Route::post('/producto/getProducto', 'ProductoController@getProductoUsuario')->name('getProducto');
Route::post('/producto/getProductoImagenes', 'ProductoController@getProductoImagenes')->name('getProductoImagenes');

//Rutas Proveedor
Route::post('/paises/getAll', 'ProveedorController@getPaises')->name('getAll');
Route::post('/proveedor/getAll', 'ProveedorController@getProveedores')->name('getAll');
Route::post('/proveedor/guardar', 'ProveedorController@guardar')->name('guardar');
Route::post('/proveedor/datos', 'ProveedorController@getDatosProveedor')->name('proveedor');
Route::post('/proveedor/eliminar', 'ProveedorController@eliminar')->name('eliminar');

//Rutas cliente
Route::post('/cliente/guardar', 'ClienteController@guardar')->name('guardarCliente');
Route::post('/cliente/getAll', 'ClienteController@getClientes')->name('getAll');
Route::post('/cliente/datos', 'ClienteController@getDatosCliente')->name('cliente');
Route::post('/cliente/eliminar', 'ClienteController@eliminar')->name('eliminar');
Route::post('/cliente/correo', 'ClienteController@validacorreo')->name('validar');

//Rutas cotizacion
Route::post('/ciudades/getAll', 'CotizacionController@getCiudades')->name('getAll');
Route::post('/transporte/getAll', 'CotizacionController@getTransporte')->name('getAll');
Route::post('/mercancia/getAll', 'CotizacionController@getTipoMercancia')->name('getAll');
Route::post('/modoTransporte/getAll', 'CotizacionController@getModoTransporte')->name('getAll');
Route::post('/servicios/getAll', 'CotizacionController@getServicios')->name('getAll');
Route::post('/guardarCotizacion', 'CotizacionController@guardarCotizacion')->name('guardar');
Route::post('/cotizaciones/getAll', 'CotizacionController@getCotizaciones')->name('getAll');
Route::post('/vendedores/getAll', 'CotizacionController@getVendedores')->name('getVendedores');
Route::post('/Asignarvendedor', 'CotizacionController@setcotizacion')->name('setcotizacion');
Route::post('/Asignacion', 'CotizacionController@getAsignacion')->name('Asignacion');
Route::post('/getEncabezado/cotizacion', 'CotizacionController@getEncabezado')->name('Cotizacion');
Route::post('/getDetalleCarga/cotizacion', 'CotizacionController@getDetalleCarga')->name('Cotizacion');
Route::post('/getDetalleServicio/cotizacion', 'CotizacionController@getDetalleServicio')->name('Cotizacion');
Route::post('/actualizarCotizacion', 'CotizacionController@ActualizarCotizacion')->name('Actualizar');
Route::post('/EstadoCotizacion', 'CotizacionController@RechazarCotizacion')->name('Estado');

//Rutas flete
Route::post('/guardarFlete', 'FleteController@guardarFlete')->name('Guardar');
Route::post('/getFlete', 'FleteController@getFlete')->name('Flete');
Route::post('/getConsignatario', 'FleteController@getConsignatario')->name('Consignatario');
Route::post('/setEstado', 'FleteController@cambiarEstadoFlete')->name('Estado');

//Rutas Reportes
Route::post('/vendedores', 'ReporteController@downloadVendedores')->name('LDCI');
Route::post('/clientes', 'ReporteController@downloadClientes')->name('LDCI');
Route::post('/productos', 'ReporteController@downloadProductos')->name('LDCI');
Route::post('/cotizaciones/datos', 'ReporteController@downloadCotizacion')->name('LDCI');
Route::post('/cotizaciones/factura', 'ReporteController@downloadFacturaCotizacion')->name('LDCI');

//Rutas Entradas
Route::post('/proveedores/getAll', 'EntradaController@getProveedores')->name('LDCI');
Route::post('/productos/getAll', 'EntradaController@getProductos')->name('LDCI');
Route::post('/guardarEntrada', 'EntradaController@guardarEntrada')->name('LDCI');
Route::post('/entrada/getAll', 'EntradaController@getEntradas')->name('getAll');
Route::post('/informacion/entrada', 'EntradaController@informacionEntrada')->name('infEntrada');
Route::post('/getDetalleEntrada/entrada', 'EntradaController@getDetalleEntrada')->name('detalleEntrada');
Route::post('/entrada/anular', 'EntradaController@anularEntrada')->name('anularEntrada');
Route::post('/entrada/producto/guardar', 'EntradaController@guardarProductoEntrada')->name('guardarProductoEntrada');


//Rutas Factura
Route::post('/factura/cotizaciones', 'FacturaController@getCotizaciones')->name('getAll');
Route::post('/factura/EncabezadoCotizaciones', 'FacturaController@getEncabezadoCotizacion')->name('getEncabezado');
Route::post('/Generarfactura/cotizacion', 'FacturaController@generarFacturaCotizacion')->name('generar');
Route::post('/getNoFactura', 'FacturaController@validaNoFactura')->name('factura');
Route::post('/getFacturas', 'FacturaController@getFacturas')->name('facturas');
Route::post('/getProductos', 'FacturaController@getProductos')->name('productos');
Route::post('/getClientes', 'FacturaController@getClientes')->name('clientes');
Route::post('/getVentas', 'FacturaController@getVentas')->name('Ventas');
Route::post('/producto/precio', 'FacturaController@getPrecio')->name('Precio');
Route::post('/facturaCotizacion/anular', 'FacturaController@anularFacturaCotizacion')->name('Anular');

//Rutas Rastreo
Route::post('/rastreo/getAllCotizaciones', 'RastreoController@getCotizaciones')->name('getAllCotizaciones');
Route::post('/getDetalle/rastreo', 'RastreoController@getDetalleSeguimiento')->name('getDetalle');
Route::post('/rastreo/guardar', 'RastreoController@guardarRastreo')->name('guardarRastreo');
Route::post('/rastreo/fotos', 'RastreoController@getImagen')->name('fotos');
Route::post('/rastreo/eliminarImagen', 'RastreoController@eliminarImagen')->name('eliminarImagen');
Route::post('/rastreoEvento/anular', 'RastreoController@eliminarEvento')->name('eliminarEvento');

Route::post('/rastreo/getRastreoImagenes', 'RastreoController@getRastreoImagenes')->name('getRastreoImagenes');
