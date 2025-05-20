<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación (acceso libre)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

// Rutas protegidas (sólo usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/products/crear', [ProductController::class, 'crear'])->name('products.crear');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/leer', [ProductController::class, 'leer'])->name('products.leer');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'eliminar'])->name('products.eliminar');
    Route::get('/products/editar/{id}', [ProductController::class, 'editar'])->name('products.editar');
});

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
