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
Route::get('/inicio','InicioController@inicio')->name ('inicio');
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


//Rutas Tipo Mercancia
Route::post('/tipoMercancia/getAll', 'TipoMercanciaController@getTipoMercancia')->name('getAll');
Route::post('/tipoMercancia/guardar', 'TipoMercanciaController@guardar')->name('guardar');
Route::post('/tipoMercancia/eliminar', 'TipoMercanciaController@eliminar')->name('eliminar');
