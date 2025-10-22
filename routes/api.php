<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\MembresiaController;
use App\Http\Controllers\api\ProductoController;
use App\Http\Controllers\api\ServicioController;
use App\Http\Controllers\api\VentaController;

Route::apiResource('membresias', MembresiaController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::apiResource('productos', ProductoController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::apiResource('servicios', ServicioController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::apiResource('ventas', VentaController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

//Route::get('/user', function (Request $request) {
  //  return $request->user();
//})->middleware('auth:sanctum');
