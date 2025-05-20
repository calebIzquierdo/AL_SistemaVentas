<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;

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

// Autenticación
Route::get('/login', function () { return view('auth.login');})->name('login');
Route::get('/register', function () { return view('auth.register');})->name('register');

// Perfil del usuario
Route::get('/perfil', [PerfilController::class, 'mostrar'])->name('perfil');
Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
// Ruta para cerrar sesión (corrección final)
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
