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
Route::post('/','TemplateController@template');

Route::post('/registro/usuario','InicioController@guardarUsuario')->name ('guardar_usuario');
Route::post('/datos/modificaUsuario','InicioController@editarUsuario')->name ('editar_usuario');
Route::post('/datos/usuario','InicioController@getUsuario');
Route::post('/login/in','InicioController@login')->name ('login-in');

// Rutas Get Unicas
Route::get('/registro/vericar/{code}', 'InicioController@verificar')->name ('Vericada'); //Ruta para verificar correo
Route::get('/usuarios', 'UsuarioController@index')->name('Usuarios');
Route::get('/registro','InicioController@registro')->name ('registro');
Route::get('/','InicioController@index');
Route::get('/login','InicioController@loginOut')->name ('login');
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

//Rutas Producto
Route::post('/producto/getAll', 'ProductoController@getProducto')->name('getAll');
Route::post('/producto/guardar', 'ProductoController@guardar')->name('guardarProducto');
Route::post('/producto/fotos', 'ProductoController@getImagen')->name('fotos');
Route::post('/producto/eliminarImagen', 'ProductoController@eliminarImagen')->name('eliminarImagen');
Route::post('/producto/eliminar', 'ProductoController@eliminar')->name('eliminar');

//Rutas producto Vista Usuario
Route::post('/producto/getProducto', 'ProductoController@getProductoUsario')->name('getProducto');
Route::post('/producto/getProductoImagenes', 'ProductoController@getProductoImagenes')->name('getProductoImagenes');


//Rutas cliente
Route::post('/cliente/guardar', 'ClienteController@guardar')->name('guardarCliente');
Route::post('/cliente/getAll', 'ClienteController@getClientes')->name('getAll');
Route::post('/cliente/datos', 'ClienteController@getDatosCliente')->name('cliente');
Route::post('/cliente/eliminar', 'ClienteController@eliminar')->name('eliminar');
