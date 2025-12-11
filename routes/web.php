<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngresoProductoController; 


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