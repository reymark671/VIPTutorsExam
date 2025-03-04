<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin; 

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(CheckAdmin::class)->group(function () { //implementation of checkadmin middleware
    Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin');
});
Route::get('/product_List', [ProductsController::class, 'index']) //route that does not use middleware
    ->name('product_List');
