<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para el controlador de productos
Route::get('/products/crear', [ProductController::class, 'crear'])->name('products.crear');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/leer', [ProductController::class, 'leer'])->name('products.leer');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'eliminar'])->name('products.eliminar');
Route::get('/products/editar/{id}', [ProductController::class, 'editar'])->name('products.editar');
