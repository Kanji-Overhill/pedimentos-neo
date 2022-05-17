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

Route::get('/', function () {
    return view('home');
});
Route::get('/items','App\Http\Controllers\ItemsController@indexItems')->name('index-items');
Route::get('/orden-venta','App\Http\Controllers\ItemsController@facturaItems')->name('orden-venta');
Route::post('/update-items','App\Http\Controllers\ItemsController@updateItems')->name('update-items');
Route::post('/obtener-datos','App\Http\Controllers\ItemsController@obtenerDatos')->name('obtener-datos');
Route::post('/verificar-item','App\Http\Controllers\ItemsController@verificarItem')->name('verificar-item');



Route::post('/get-item','App\Http\Controllers\ItemsController@getItem')->name('get-item');
Route::post('/get-items','App\Http\Controllers\ItemsController@getItems')->name('get-items');
Route::post('/send-factura','App\Http\Controllers\ItemsController@sendFactura')->name('sendFactura');
Route::post('/get-pedimento','App\Http\Controllers\ItemsController@getPedimento')->name('getPedimento');
