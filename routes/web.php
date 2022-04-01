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

use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductosController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\InventarioController::class, 'index'])->name('home');

Route::resource('products', ProductosController::class)->middleware('auth');
Route::resource('inventory', InventarioController::class)->middleware('auth');

Route::get('/products/{id}/delete', [ProductosController::class, 'deleteProduct'])->middleware('auth');

Route::post('/products/discount', [ProductosController::class, 'discountProduct'])->middleware('auth');


Route::post('products/obtenerDatosProductos', [ProductosController::class, 'obtenerDatosProductos'])->middleware('auth');
Route::post('products/calcular', [ProductosController::class, 'calcularProductos'])->middleware('auth');
Route::post('products/valida-codigo', [ProductosController::class, 'validarCodigo'])->middleware('auth');
Route::post('products/queryProducts', [ProductosController::class, 'queryProducts'])->middleware('auth');



Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [InventarioController::class, 'index'])->name('home');
});