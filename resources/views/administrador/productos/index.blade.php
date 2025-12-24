{{-- resources/views/administrador/productos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                Dashboard
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">Productos</span>
        </nav>

        {{-- Cabecera --}}
        <div class="card-elegant">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="icon-badge">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Gestión de Productos</h1>
                            <p class="text-gray-600 mt-1">Administra tus productos, categorías y lotes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Opciones Principales --}}
        <div class="options-grid">
            {{-- Opción: Categorías --}}
            <a href="{{ route('categorias.index') }}" class="option-card">
                <div class="option-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.972 1.972 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="option-content">
                    <h3 class="option-title">Gestionar Categorías</h3>
                    <p class="option-description">Crea, edita y organiza categorías y subcategorías para tus productos</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            {{-- Opción: Productos --}}
            <a href="{{ route('productos.empresas') }}" class="option-card">
                <div class="option-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="option-content">
                    <h3 class="option-title">Registrar Productos</h3>
                    <p class="option-description">Crea nuevos productos asignándolos a categorías y lotes</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

           
        </div>

        {{-- Lista de Productos --}}
        <div class="mt-12">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
               
                
                {{-- Filtros Avanzados --}}
<div class="w-full">
    <form action="{{ route('productos.index') }}" method="GET" class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl shadow-xl border border-gray-200 transition-all duration-300 hover:shadow-2xl">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtros de Búsqueda
            </h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
            {{-- Buscador --}}
            <div class="lg:col-span-2 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}"
                       placeholder="Buscar por nombre o código..." 
                       class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:border-gray-300 shadow-sm">
            </div>

            {{-- Categoría --}}
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <select name="categoria_id" id="filter_categoria_id" 
                        class="w-full pl-11 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:border-gray-300 cursor-pointer shadow-sm">
                    <option value="">Todas las Categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ (isset($categoriaId) && $categoriaId == $categoria->id) ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            {{-- Subcategoría --}}
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <select name="subcategoria_id" id="filter_subcategoria_id" 
                        class="w-full pl-11 pr-10 py-3 appearance-none rounded-xl border-2 transition-all duration-200 shadow-sm {{ empty($subcategoriaId) && empty($categoriaId) ? 'bg-gray-50 border-gray-200 text-gray-400 cursor-not-allowed' : 'bg-white border-gray-200 hover:border-gray-300 cursor-pointer focus:ring-2 focus:ring-blue-500 focus:border-blue-500' }}"
                        {{ empty($subcategoriaId) && empty($categoriaId) ? 'disabled' : '' }}>
                    <option value="">Todas las Subcategorías</option>
                    @foreach($subcategorias as $subcategoria)
                        <option value="{{ $subcategoria->id }}" {{ (isset($subcategoriaId) && $subcategoriaId == $subcategoria->id) ? 'selected' : '' }}>
                            {{ $subcategoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            {{-- Ordenar --}}
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                    </svg>
                </div>
                <select name="orden" 
                        class="w-full pl-11 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:border-gray-300 cursor-pointer shadow-sm">
                    <option value="desc" {{ (isset($orden) && $orden == 'desc') ? 'selected' : '' }}>Más Recientes</option>
                    <option value="asc" {{ (isset($orden) && $orden == 'asc') ? 'selected' : '' }}>Más Antiguos</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center mt-6 pt-5 border-t-2 border-gray-200 gap-4">
            <div class="text-sm text-gray-600">
                @if($search || $categoriaId || $subcategoriaId || $orden)
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Filtros aplicados</span>
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Sin filtros activos</span>
                    </span>
                @endif
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('productos.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Limpiar
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filtrar
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cargar subcategorías cuando se selecciona una categoría
    const categoriaSelect = document.getElementById('filter_categoria_id');
    const subcategoriaSelect = document.getElementById('filter_subcategoria_id');
    
    // Si ya hay una categoría seleccionada, cargar sus subcategorías
    if (categoriaSelect.value) {
        loadSubcategorias(categoriaSelect.value);
        subcategoriaSelect.disabled = false;
        subcategoriaSelect.classList.remove('bg-gray-100', 'text-gray-500');
    }
    
    categoriaSelect.addEventListener('change', function() {
        const categoriaId = this.value;
        
        if (categoriaId) {
            loadSubcategorias(categoriaId);
            subcategoriaSelect.disabled = false;
            subcategoriaSelect.classList.remove('bg-gray-100', 'text-gray-500');
        } else {
            subcategoriaSelect.innerHTML = '<option value="">Todas las Subcategorías</option>';
            subcategoriaSelect.disabled = true;
            subcategoriaSelect.classList.add('bg-gray-100', 'text-gray-500');
        }
    });
    
    function loadSubcategorias(categoriaId) {
        fetch(`/categorias/${categoriaId}/subcategorias`)
            .then(response => response.json())
            .then(data => {
                subcategoriaSelect.innerHTML = '<option value="">Todas las Subcategorías</option>';
                
                data.forEach(subcategoria => {
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre;
                    
                    // Mantener seleccionada la subcategoría si ya estaba seleccionada
                    @if(isset($subcategoriaId))
                        if (subcategoria.id == {{ $subcategoriaId }}) {
                            option.selected = true;
                        }
                    @endif
                    
                    subcategoriaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>
            </div>

            @if($productos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($productos as $producto)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 group">
                        {{-- Imagen --}}
                        <div class="aspect-w-16 aspect-h-9 bg-gray-100 relative overflow-hidden">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="w-full h-48 object-cover object-center group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Batch Badge --}}
                            @if($producto->ingresoProducto)
                                <div class="absolute top-2 right-2">
                                    <span class="bg-blue-600 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full">
                                        Stock: {{ $producto->ingresoProducto->cantidad_restante }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Contenido --}}
                        <div class="p-4">
                            <div class="mb-2">
                                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">
                                    {{ $producto->subcategoria->categoria->nombre ?? 'Sin Categoría' }}
                                </p>
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-1" title="{{ $producto->nombre }}">
                                    {{ $producto->nombre }}
                                </h3>
                                @if($producto->codigo)
                                    <p class="text-xs text-gray-400 font-mono mt-0.5">
                                        Cód: {{ $producto->codigo }}
                                    </p>
                                @endif
                                <p class="text-sm text-gray-500 line-clamp-1 mt-1">
                                    {{ $producto->subcategoria->nombre ?? 'Sin Subcategoría' }}
                                </p>
                                @if(isset($producto->ingresoProducto->fecha_vencimiento_lote))
                                    <p class="text-xs text-red-500 mt-1 font-medium">
                                        Vence: {{ \Carbon\Carbon::parse($producto->ingresoProducto->fecha_vencimiento_lote)->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-end mt-4">
                                <div>
                                    <span class="text-xs text-gray-500 block">Precio</span>
                                    <span class="text-xl font-bold text-green-600">Bs {{ number_format($producto->precio_venta_unitario, 2) }}</span>
                                </div>
                                <a href="{{ route('productos.edit', $producto->id) }}" class="p-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                <div class="mt-6">
                    {{ $productos->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <svg class="h-full w-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay productos</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza registrando productos desde la opción de proveedores.</p>
                </div>
            @endif
        </div>

<style>
    /* Estilos base */
    .card-elegant {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        padding: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .icon-badge {
        width: 3.5rem;
        height: 3.5rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(37, 99, 235);
    }

    /* Grid de Opciones */
    .options-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .options-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .options-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* Card de Opción */
    .option-card {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.75rem;
        background: white;
        border-radius: 1.25rem;
        border: 2px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        cursor: pointer;
        position: relative;
    }

    .option-card:not(.disabled):hover {
        border-color: rgb(59, 130, 246);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
        transform: translateY(-2px);
    }

    .option-card.disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background: rgba(249, 250, 251, 0.5);
    }

    .option-icon {
        width: 3.5rem;
        height: 3.5rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(37, 99, 235);
        flex-shrink: 0;
    }

    .option-card:hover .option-icon {
        background: rgba(59, 130, 246, 0.15);
    }

    .option-content {
        flex: 1;
        text-align: left;
    }

    .option-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
        margin: 0 0 0.5rem 0;
    }

    .option-description {
        font-size: 0.9375rem;
        color: rgb(107, 114, 128);
        margin: 0;
        line-height: 1.5;
    }

    .badge-soon {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: rgba(156, 163, 175, 0.1);
        color: rgb(107, 114, 128);
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 9999px;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    @media (max-width: 640px) {
        .option-card {
            flex-direction: column;
            text-align: center;
        }

        .option-content {
            text-align: center;
        }

        .option-card svg:last-child {
            display: none;
        }

        .badge-soon {
            justify-content: center;
            width: 100%;
        }
    }
</style>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('filter_categoria_id');
    const subcategoriaSelect = document.getElementById('filter_subcategoria_id');

    categoriaSelect.addEventListener('change', function() {
        const categoriaId = this.value;
        
        // Reset subcategory select
        subcategoriaSelect.innerHTML = '<option value="">Todas las Subcategorías</option>';
        
        if (categoriaId) {
            subcategoriaSelect.disabled = false;
            fetch(`/categorias/${categoriaId}/subcategorias`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcategoria => {
                        const option = document.createElement('option');
                        option.value = subcategoria.id;
                        option.textContent = subcategoria.nombre;
                        subcategoriaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        } else {
            subcategoriaSelect.disabled = true;
        }
    });
});
</script>
