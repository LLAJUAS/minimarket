@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Breadcrumb Mejorado --}}
        <nav class="flex items-center space-x-2 text-sm mb-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-1 text-gray-600 hover:text-green-600 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Inicio
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('productos.index') }}" class="text-gray-600 hover:text-green-600 transition-colors font-medium">Productos</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-semibold">Editar Producto</span>
        </nav>

        {{-- Mensajes de error --}}
        @if(session('error'))
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-xl p-5 shadow-sm flex items-start gap-4 animate-slideIn">
                <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-red-900 text-lg">¡Ups! Algo salió mal</h3>
                    <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            {{-- Header con gradiente --}}
            <div class="bg-blue-600 p-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Editar Producto</h1>
                        <p class="text-blue-100 mt-1">Actualice la información del producto seleccionado</p>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10">
                {{-- Info del Lote --}}
                @if($ingreso)
                    <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-blue-900 text-lg mb-1">📦 Producto asociado a lote</h3>
                                <p class="text-blue-700">
                                    Este producto pertenece al lote <span class="font-bold">{{ $ingreso->nombre_producto }}</span> de <span class="font-bold">{{ $ingreso->proveedor->nombre_empresa ?? 'Proveedor' }}</span>
                                </p>
                                <div class="mt-3 flex items-center gap-4 text-sm">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">
                                        Lote: {{ $ingreso->codigo_lote ?? 'N/A' }}
                                    </span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">
                                        Stock Inicial: {{ number_format($ingreso->cantidad_inicial, 0, ',', '.') }} {{ $ingreso->unidad_medida }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="productForm">
                    @csrf
                    @method('PUT')
                    
                    {{-- Sección: Información Básica --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 pb-3 border-b-2 border-gray-200">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Información Básica</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nombre --}}
                            <div class="col-span-2">
                                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Nombre del Producto <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nombre" 
                                       id="nombre" 
                                       value="{{ old('nombre', $producto->nombre) }}" 
                                       class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200"
                                       required>
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Código de Barras --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    Código de Barras
                                </label>
                                <input type="text" 
                                       name="codigo" 
                                       id="codigo" 
                                       value="{{ old('codigo', $producto->codigo) }}" 
                                       class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200"
                                       placeholder="Escanee o ingrese código">
                                @error('codigo')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Categorización --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 pb-3 border-b-2 border-gray-200">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Categorización</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Categoría --}}
                            <div>
                                <label for="categoria_id" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Categoría <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="categoria_id" 
                                            id="categoria_id" 
                                            class="appearance-none w-full px-4 py-3 pr-10 rounded-xl border-2 border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                                            required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ (old('categoria_id', $producto->categoria_id) ?? $producto->subcategoria->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Subcategoría --}}
                            <div>
                                <label for="subcategoria_id" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Subcategoría <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="subcategoria_id" 
                                            id="subcategoria_id" 
                                            class="appearance-none w-full px-4 py-3 pr-10 rounded-xl border-2 border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 disabled:bg-gray-50 disabled:text-gray-400"
                                            required>
                                        <option value="">Seleccione primero una categoría</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Precios --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 pb-3 border-b-2 border-gray-200">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Información de Precios</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Precio por Mayor --}}
                            @if($ingreso)
                            <div>
                                <label for="precio_por_mayor" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Precio por Mayor
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-semibold">Bs</span>
                                    </div>
                                    <input type="number" 
                                           step="0.01" 
                                           name="precio_por_mayor" 
                                           id="precio_por_mayor" 
                                           value="{{ number_format($ingreso->costo_total / $ingreso->cantidad_inicial, 2, '.', '') }}" 
                                           class="pl-12 w-full px-4 py-3 rounded-xl border-2 border-slate-300 bg-slate-50 text-slate-600 font-semibold"
                                           readonly>
                                </div>
                                <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Costo unitario del lote ({{ number_format($ingreso->cantidad_inicial, 0, ',', '.') }} unidades)
                                </p>
                            </div>
                            @endif

                            {{-- Precio de Venta --}}
                            <div>
                                <label for="precio_venta_unitario" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Precio de Venta <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-semibold">Bs</span>
                                    </div>
                                    <input type="number" 
                                           step="0.01" 
                                           name="precio_venta_unitario" 
                                           id="precio_venta_unitario" 
                                           value="{{ old('precio_venta_unitario', $producto->precio_venta_unitario) }}" 
                                           class="pl-12 w-full px-4 py-3 rounded-xl border-2 border-slate-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 font-semibold"
                                           placeholder="0.00"
                                           required>
                                </div>
                                @if($recomendacion)
                                <div class="mt-4 p-4 bg-amber-50 border-l-4 border-amber-400 rounded-lg shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                                            <i class="fas fa-lightbulb text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-amber-900">Se recomienda cambiar el precio</p>
                                            <p class="text-xs text-amber-800">
                                                El último stock ingresado tiene un costo de <span class="font-bold">Bs {{ number_format($recomendacion['costo'], 2) }}</span>. 
                                                Se sugiere un precio de venta de <span class="font-bold">Bs {{ number_format($recomendacion['precio_sugerido'], 2) }}</span>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($ingreso)
                                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-xs text-green-700 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">Margen sobre costo actual:</span> 
                                        <span class="font-bold text-green-800">Bs {{ number_format(($ingreso->costo_total / $ingreso->cantidad_inicial) * 1.5, 2) }}</span> 
                                        <span class="text-green-600">(50% de margen)</span>
                                    </p>
                                </div>
                                @endif
                                @error('precio_venta_unitario')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Imagen --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 pb-3 border-b-2 border-gray-200">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Imagen del Producto</h2>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Fotografía del producto
                            </label>

                            <input id="imagen" name="imagen" type="file" class="sr-only" accept="image/*">

                            <div class="relative mt-1 flex justify-center px-6 pt-8 pb-8 border-3 border-dashed border-gray-300 rounded-2xl hover:border-blue-500 hover:bg-blue-50/50 transition-all duration-300 cursor-pointer bg-gradient-to-br from-gray-50 to-slate-50" id="image-dropzone">
                                <div class="space-y-2 text-center" id="image-preview">
                                    @if($producto->imagen)
                                        <div class="relative inline-block">
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="mx-auto h-56 w-auto object-cover rounded-xl shadow-lg border-4 border-white">
                                            <label for="imagen" class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-colors cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                </svg>
                                            </label>
                                        </div>
                                    @else
                                        <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center items-center gap-1">
                                            <label for="imagen" class="relative cursor-pointer bg-white rounded-lg px-3 py-1 font-semibold text-blue-600 hover:text-blue-500 hover:bg-blue-50 transition-all duration-200">
                                                <span>Subir archivo</span>
                                            </label>
                                            <p>o arrastrar y soltar aquí</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @error('imagen')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex items-center justify-between gap-4 pt-8 mt-8 border-t-2 border-gray-200">
                        <a href="{{ route('productos.index') }}" class="flex items-center gap-2 px-6 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="flex items-center gap-2 px-8 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideIn {
    animation: slideIn 0.3s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');
    
    // Cargar subcategorías iniciales
    if (categoriaSelect.value) {
        const currentSubcategoriaId = {{ old('subcategoria_id', $producto->subcategoria_id) }};
        loadSubcategorias(categoriaSelect.value, currentSubcategoriaId);
    }
    
    categoriaSelect.addEventListener('change', function() {
        const categoriaId = this.value;
        
        if (categoriaId) {
            loadSubcategorias(categoriaId);
            subcategoriaSelect.disabled = false;
        } else {
            subcategoriaSelect.innerHTML = '<option value="">Seleccione primero una categoría</option>';
            subcategoriaSelect.disabled = true;
        }
    });
    
    function loadSubcategorias(categoriaId, selectedId = null) {
        fetch(`/categorias/${categoriaId}/subcategorias`)
            .then(response => response.json())
            .then(data => {
                subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
                
                data.forEach(subcategoria => {
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre;
                    
                    if (selectedId && subcategoria.id == selectedId) {
                        option.selected = true;
                    }
                    
                    subcategoriaSelect.appendChild(option);
                });
                subcategoriaSelect.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    }
    
    const fileInput = document.getElementById('imagen');
    const dropzone = document.getElementById('image-dropzone');
    const imagePreview = document.getElementById('image-preview');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    function unhighlight() {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    }

    dropzone.addEventListener('click', function(e) {
        if (e.target.tagName !== 'LABEL' && e.target.tagName !== 'SPAN' && e.target.tagName !== 'svg' && e.target.tagName !== 'path') {
            fileInput.click();
        }
    });
    
    dropzone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    }
    
    fileInput.addEventListener('change', handleFileSelect);
    
    function handleFileSelect() {
        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            
            if (!file.type.match('image.*')) {
                alert('El archivo seleccionado no es una imagen válida.');
                return;
            }
            
            if (file.size > 10 * 1024 * 1024) {
                alert('La imagen no puede ser mayor a 10MB.');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <div class="relative">
                        <div class="relative inline-block">
                            <img src="${e.target.result}" alt="Vista previa" class="mx-auto h-56 w-auto object-cover rounded-xl shadow-lg border-4 border-white">
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                            <p class="text-sm text-gray-800 font-semibold truncate">${file.name}</p>
                            <p class="text-xs text-gray-500 mt-1">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                            <div class="flex justify-center mt-3">
                                <label for="imagen" class="cursor-pointer px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <span>Cambiar imagen</span>
                                </label>
                            </div>
                        </div>
                    </div>
                `;
            };
            
            reader.readAsDataURL(file);
        }
    }
    
    const form = document.getElementById('productForm');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (!categoriaSelect.value) {
            isValid = false;
        }
        
        if (!subcategoriaSelect.value) {
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
});
</script>
@endsection