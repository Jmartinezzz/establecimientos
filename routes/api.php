<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/establecimientos/','APIController@index');
Route::get('/establecimientos/{establecimiento}','APIController@show');

Route::get('/categorias','APIController@categorias')->name('categorias');
Route::get('/{categoria}','APIController@establecimientoscategoria');
Route::get('/categorias/{categoria}','APIController@categoria')->name('categoria')
	 ->whereAlpha('categoria');
