<?php

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

Route::get('/','InicioController@index');
Route::get('/inicio','InicioController@inicio')->name ('inicio');
Route::get('/login','InicioController@loginOut')->name ('login');
Route::get('/registro', 'InicioController@registro' )->name ('registro');
Route::post('/registro/usuario','InicioController@guardarUsuario')->name ('guardar_usuario');
Route::get('/registro','InicioController@registro')->name ('registro');
Route::post('/registro/usuario','InicioController@guardarUsuario')->name ('guardar_usuario');
Route::post('/datos/modificaUsuario','InicioController@editarUsuario')->name ('editar_usuario');
Route::post('/datos/usuario','InicioController@getUsuario');
Route::post('/login/in','InicioController@login')->name ('login-in');
Route::get('/home', 'HomeController@index')->name('home');

// Confirmacion de email
Route::get('/registro/vericar/{code}', 'InicioController@verificar')->name ('Vericada');


//Rutas Usuarios
Route::get('/usuarios', 'UsuarioController@index')->name('Usuarios');
Route::post('/usuarios/getAll', 'UsuarioController@getUsuarios')->name('getAll');

