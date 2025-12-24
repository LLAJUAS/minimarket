<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngresoProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController; 


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas Protegidas
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth') // Asegura que el usuario esté logueado
    ->name('dashboard');

// Ruta para los proveedores
Route::get('/proveedores', [ProveedorController::class, 'index'])
    ->middleware('auth') // También la protegemos con el middleware 'auth'
    ->name('proveedores');

Route::get('/proveedores/agregar', [ProveedorController::class, 'create'])->middleware('auth')->name('proveedores.create');
Route::post('/proveedores', [ProveedorController::class, 'store'])->middleware('auth')->name('proveedores.store');

// Nuevas rutas para editar y eliminar
Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'edit'])->middleware('auth')->name('proveedores.edit');
Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->middleware('auth')->name('proveedores.update');
Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->middleware('auth')->name('proveedores.destroy');
Route::get('/proveedores/buscar/ajax', [ProveedorController::class, 'buscarAjax'])
    ->name('proveedores.buscar.ajax');




// Rutas para ver los productos de un proveedor específico
Route::middleware('auth')->group(function () {
    Route::get('/proveedores/{proveedor}/productos', [IngresoProductoController::class, 'index'])->name('proveedores.productos.index');
});

// Rutas para el CRUD general de ingresos de productos
Route::middleware('auth')->prefix('ingresos')->name('ingresos.')->group(function () {
    Route::get('/crear', [IngresoProductoController::class, 'create'])->name('create');
    Route::post('/', [IngresoProductoController::class, 'store'])->name('store');
    Route::get('/{ingresoProducto}/editar', [IngresoProductoController::class, 'edit'])->name('edit');
    Route::put('/{ingresoProducto}', [IngresoProductoController::class, 'update'])->name('update');
    Route::delete('/{ingresoProducto}', [IngresoProductoController::class, 'destroy'])->name('destroy');
});

// Rutas para Productos
Route::middleware('auth')->prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/crear', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
    Route::get('/empresas', [ProductoController::class, 'empresas'])->name('empresas');
    Route::get('/buscar/ajax', [ProductoController::class, 'buscarAjax'])->name('buscar.ajax');
});

// Rutas para Categorías
Route::middleware('auth')->prefix('categorias')->name('categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/crear', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{categoria}/editar', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
    
    // Rutas para Subcategorías
    Route::get('/{categoria}/subcategorias', [CategoriaController::class, 'getSubcategorias'])->name('subcategorias.index');
    Route::post('/{categoria}/subcategorias', [CategoriaController::class, 'storeSubcategoria'])->name('storeSubcategoria');
    Route::delete('/subcategorias/{subcategoria}', [CategoriaController::class, 'destroySubcategoria'])->name('destroySubcategoria');
});