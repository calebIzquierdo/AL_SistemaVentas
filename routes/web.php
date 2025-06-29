<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InicioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DatosContactoController;

// vista cliente
Route::get('/', [InicioController::class, 'index'])->name('inicio.index');
Route::get('/catalogo', [InicioController::class, 'mostrarCatalogo'])->name('catalogo.index');

//Registro de usuario
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');
// Ruta para mostrar el formulario de registro (GET)
Route::get('/registro', [RegistroController::class, 'showRegisterForm'])->name('registro.form');

///carrito
Route::get('/carrito', [CarritoController::class, 'verCarrito'])->name('carrito.ver');  // Ver el carrito
Route::post('/carrito/agregar', [CarritoController::class, 'agregarAlCarrito'])->name('carrito.agregar');  // Agregar producto al carrito
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizar');  // Actualizar cantidad del producto en carrito
Route::delete('/carrito/{productoId}', [CarritoController::class, 'quitarDelCarrito'])->name('carrito.quitar');  // Eliminar producto del carrito
Route::post('/carrito/finalizar', [CarritoController::class, 'finalizarCompra'])->name('carrito.finalizar');



// Rutas del ejemplo
Route::get('/products/crear', [ProductController::class, 'crear'])->name('products.crear');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/leer', [ProductController::class, 'leer'])->name('products.leer');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'eliminar'])->name('products.eliminar');
Route::get('/products/editar/{id}', [ProductController::class, 'editar'])->name('products.editar');

// Rutas para Categorías
Route::middleware('auth')->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/categorias/{id_categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{id_categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::get('/categorias/ajax/listar', [CategoriaController::class, 'ajaxListar'])->name('categorias.ajax.listar');
});

//Rutas para stock

// Rutas para Datos de Contacto
Route::middleware(['auth'])->group(function () {
    Route::get('/datos-contacto', [DatosContactoController::class, 'index'])->name('datos-contacto.index');
    
    
    Route::put('/datos-contacto/{id}', [DatosContactoController::class, 'update'])->name('datos_contacto.update');
    Route::delete('/datos-contacto/{id}', [DatosContactoController::class, 'destroy'])->name('datos_contacto.destroy');
    Route::get('/datos-contacto/ajax-listar', [DatosContactoController::class, 'ajaxListar'])->name('datos_contacto.ajax.listar');
});

//ruta para servicios
Route::get('/datos-contacto/servicio', [DatosContactoController::class, 'servicio'])->name('datos-contacto.servicio');
Route::post('/datos-contacto', [DatosContactoController::class, 'store'])->name('datos-contacto.store');

//Rutas para stock
Route::middleware('auth')->group(function () {
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
    Route::put('/stock/{id}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/stock/{id}', [StockController::class, 'destroy'])->name('stock.destroy');
    Route::get('/stock/ajax/listar', [StockController::class, 'ajaxListar'])->name('stock.ajax.listar');
    Route::get('/productos-disponibles', [StockController::class, 'getProductosDisponibles'])->name('productosDisponibles');
});


// Rutas para Usuarios
Route::middleware('auth')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id_usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id_usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/usuarios/ajax/listar', [UsuarioController::class, 'ajaxListar'])->name('usuarios.ajax.listar');
});

//Rutas Productos
Route::middleware('auth')->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/productos/{id_producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id_producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get('/productos/ajax/listar', [ProductoController::class, 'ajaxListar'])->name('productos.ajax.listar');
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

//// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Ruta protegida
Route::middleware('auth')->group(function () {

});
