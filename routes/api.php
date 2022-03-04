<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\VentasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


 
Route::controller(ProductosController::class)->group(function () {
    Route::get('/productos/all', 'index');
    Route::post('/productos/add', 'store');
    Route::get('/productos/show/{id}', 'show');
    Route::post('/productos/update/{id}', 'update');
    Route::delete('/productos/delete/{id}','destroy');
});

Route::controller(VentasController::class)->group(function () {
    Route::get('/ventas/all', 'index');
    Route::post('/ventas/add', 'store');
    Route::get('/ventas/show/{id}', 'show');
    Route::post('/ventas/update/{id}', 'update');
    Route::delete('/ventas/delete/{id}','destroy');
});
