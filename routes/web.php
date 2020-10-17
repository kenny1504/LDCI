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

Route::get('/','inicioController@index');
Route::get('/inicio','iniciocontroller@inicio')->name ('inicio');
Route::get('/login','iniciocontroller@loginOut')->name ('login');
Route::get('/registro','iniciocontroller@registro')->name ('registro');
Route::post('/registro/usuario','iniciocontroller@guardarUsuario')->name ('guardar_usuario');
Route::post('/datos/usuario','iniciocontroller@getUsuario');

Route::post('/login/in','inicioController@login')->name ('login-in');

Route::get('/home', 'HomeController@index')->name('home');

// Confirmacion de email
Route::get('/registro/vericar/{code}', 'iniciocontroller@verificar')->name ('Vericada');
