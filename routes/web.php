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

Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('welcome');
});

Route::get('', 'InicioController')->name('inicio');

Route::group(['middleware' => ['auth', 'verified']], function(){
	Route::resource('establecimiento', 'EstablecimientoController')->except(['index']);

	Route::post('imagenes/store', 'ImagenController@store')->name('imagenes.store');
	Route::post('imagenes/destroy', 'ImagenController@destroy')->name('imagenes.destroy');
});

Route::get('/home', 'HomeController@index')->name('home');
