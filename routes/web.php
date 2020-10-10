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
Route::post('inicioController/login','inicioController@login');
Route::get('/inicio','iniciocontroller@inicio')->name ('inicio');
Route::get('/login','iniciocontroller@loginOut')->name ('login');
Route::post('/datos/usuario','iniciocontroller@getUsuario');