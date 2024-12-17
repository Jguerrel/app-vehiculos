<?php

use App\Http\Controllers\RepairSubCategoryController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
  //repairsubcategory
  Route::resource('/repairsubcategories', RepairSubCategoryController::class)->middleware('is_superadmin');
});
