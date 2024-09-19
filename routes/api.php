<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// estado de la orden de compra
Route::post('reparaciones/consultaordencompra', [ApiController::class, 'getOrderStatus'])
    ->name('reparaciones.consultaordencompra');

// crear orden de compra
Route::post('reparaciones/crearordencompra', [ApiController::class, 'createPurchaseOrder'])
    ->name('reparaciones.createPurchaseOrder');
