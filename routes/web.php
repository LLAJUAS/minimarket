<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngresoProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\VentaController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de Venta
Route::middleware('auth')->group(function () {
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('/venta', [VentaController::class, 'create'])->name('venta.index');
    Route::get('/venta/buscar-producto', [VentaController::class, 'buscarProducto'])->name('venta.buscar.producto');
    Route::get('/venta/buscar-cliente', [VentaController::class, 'buscarCliente'])->name('venta.buscar.cliente');
    Route::post('/venta/store', [VentaController::class, 'store'])->name('venta.store');
    Route::post('/venta/generar-recibo', [VentaController::class, 'generarRecibo'])->name('venta.generar.recibo');
    
    // Ruta de prueba (mantener por si acaso)
    Route::get('/administrador/ventas/prueba', function () {
        return view('administrador.ventas.prueba');
    })->name('venta.prueba');
});

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
    Route::get('/eliminados/{proveedor}', [IngresoProductoController::class, 'deleted'])->name('deleted');
    Route::post('/{id}/restaurar', [IngresoProductoController::class, 'restore'])->name('restore');
    Route::get('/{ingresoProducto}', [IngresoProductoController::class, 'show'])->name('show');
    Route::get('/{ingresoProducto}/editar', [IngresoProductoController::class, 'edit'])->name('edit');
    Route::put('/{ingresoProducto}', [IngresoProductoController::class, 'update'])->name('update');
    Route::delete('/{ingresoProducto}', [IngresoProductoController::class, 'destroy'])->name('destroy');
});

// Rutas para Productos
Route::middleware('auth')->prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/empresas', [ProductoController::class, 'empresas'])->name('empresas');
    Route::get('/buscar/ajax', [ProductoController::class, 'buscarAjax'])->name('buscar.ajax');
    
    // CRUD Rutas
    Route::get('/crear', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/eliminados', [ProductoController::class, 'eliminados'])->name('eliminados');
    Route::post('/{id}/restaurar', [ProductoController::class, 'restore'])->name('restore');
    Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
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
    Route::get('/{categoria}/subcategorias', [CategoriaController::class, 'getSubcategorias'])->name('subcategorias');
    Route::post('/{categoria}/subcategorias', [CategoriaController::class, 'storeSubcategoria'])->name('storeSubcategoria');
    Route::delete('/subcategorias/{subcategoria}', [CategoriaController::class, 'destroySubcategoria'])->name('destroySubcategoria');
});

// Rutas para Usuarios
Route::middleware('auth')->prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/{id}/update-role', [UserController::class, 'updateRole'])->name('update-role');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// Rutas para Roles
Route::middleware('auth')->prefix('roles')->name('roles.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::post('/', [RoleController::class, 'store'])->name('store');
    Route::put('/{role}', [RoleController::class, 'update'])->name('update');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
});