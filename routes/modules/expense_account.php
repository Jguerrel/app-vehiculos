<?php

use App\Http\Controllers\AdditionalExpenseAccountController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix vehicles
Route::middleware(['auth', 'is_superadmin'])
    ->prefix('expense_account')
    ->name('expense_account.')
    ->group(function () {

        // listar registros
        Route::get('index', [AdditionalExpenseAccountController::class, 'index'])
            ->name('index');

        // guardar registro
        Route::post('store', [AdditionalExpenseAccountController::class, 'store'])
            ->name('store');

        // actualizar registro
        Route::post('update/{account}', [AdditionalExpenseAccountController::class, 'update'])
            ->name('update');

        // eliminar registro
        Route::delete('destroy/{account}', [AdditionalExpenseAccountController::class, 'destroy'])
            ->name('destroy');
    });
