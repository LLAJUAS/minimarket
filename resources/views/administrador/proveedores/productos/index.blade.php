{{-- resources/views/administrador/proveedores/productos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Productos de ' . $proveedor->nombre_empresa)

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('proveedores') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                Proveedores
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">{{ $proveedor->nombre_empresa }}</span>
        </nav>

        {{-- Cabecera --}}
        <div class="card-elegant">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="provider-badge">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">{{ $proveedor->nombre_empresa }}</h1>
                            <p class="text-gray-600 mt-1">Gestiona los ingresos y lotes de este proveedor</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="badge-count">
                            <span class="count-dot"></span>
                            {{ $ingresos->count() }} {{ $ingresos->count() === 1 ? 'Producto' : 'Productos' }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('ingresos.create') }}?proveedor_id={{ $proveedor->id }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Registrar nuevo lote
                </a>
            </div>
        </div>

        {{-- Mensaje de Éxito --}}
        @if(session('success'))
            <div class="success-message">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

     {{-- Filtros de Búsqueda --}}
<div class="filters-card">
    <form method="GET" action="{{ route('proveedores.productos.index', $proveedor->id) }}" class="space-y-4">
        <div class="filters-header">
            <h3 class="filters-title">Filtrar lotes</h3>
            <a href="{{ route('proveedores.productos.index', $proveedor->id) }}" class="btn-reset-filters">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Limpiar Filtros
            </a>
        </div>

        <div class="filters-grid">
            {{-- Búsqueda por nombre --}}
            <div class="filter-group">
                <label class="filter-label">Nombre del lote</label>
                <input 
                    type="text" 
                    name="nombre_producto" 
                    value="{{ request('nombre_producto') }}"
                    placeholder="Buscar por nombre..."
                    class="filter-input"
                >
            </div>

            {{-- Filtro por período --}}
            <div class="filter-group">
                <label class="filter-label">Período</label>
                <select name="filtro_periodo" class="filter-select">
                    <option value="">Todos los períodos</option>
                    <option value="esta_semana" {{ request('filtro_periodo') === 'esta_semana' ? 'selected' : '' }}>Esta Semana</option>
                    <option value="este_mes" {{ request('filtro_periodo') === 'este_mes' ? 'selected' : '' }}>Este Mes</option>
                    <option value="hace_2_meses" {{ request('filtro_periodo') === 'hace_2_meses' ? 'selected' : '' }}>Últimos 2 Meses</option>
                    <option value="hace_3_meses" {{ request('filtro_periodo') === 'hace_3_meses' ? 'selected' : '' }}>Últimos 3 Meses</option>
                    <option value="hace_1_año" {{ request('filtro_periodo') === 'hace_1_año' ? 'selected' : '' }}>Último Año</option>
                </select>
            </div>

            {{-- Separador --}}
            <div class="col-span-full">
                <p class="filter-label">Buscar por rango de ingreso</p>
                <hr>
            </div>

            {{-- Rango de fechas --}}
            <div class="filter-group">
                <label class="filter-label">Fecha Inicio</label>
                <input 
                    type="date" 
                    name="fecha_inicio" 
                    value="{{ request('fecha_inicio') }}"
                    class="filter-input"
                >
            </div>

            <div class="filter-group">
                <label class="filter-label">Fecha Fin</label>
                <input 
                    type="date" 
                    name="fecha_fin" 
                    value="{{ request('fecha_fin') }}"
                    class="filter-input"
                >
            </div>

            {{-- Botón de búsqueda --}}
            <div class="filter-group flex items-end">
                <button type="submit" class="btn-filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                        </path>
                    </svg>
                    Filtrar
                </button>
            </div>
        </div>
    </form>
</div>

        {{-- Lista de Productos --}}
        <div class="space-y-4">
            @forelse ($ingresos as $ingreso)
                <div class="product-card">
                    <div class="product-content">
                        
                        {{-- Información del Producto --}}
                        <div class="product-info">
                            <div class="product-header">
                                <div class="product-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h3 class="product-title">{{ $ingreso->nombre_producto }}</h3>
                            </div>

                            <div class="product-grid">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Cantidad Inicial</p>
                                        <p class="info-value">{{ number_format($ingreso->cantidad_inicial, 0, ',', '.') }} unid.</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon stock-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Cantidad Restante</p>
                                        <p class="info-value stock-value">{{ number_format($ingreso->cantidad_restante, 0, ',', '.') }} unid.</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon cost-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Costo Total</p>
                                        <p class="info-value">Bs {{ number_format($ingreso->costo_total, 2, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon date-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Fecha Ingreso</p>
                                        <p class="info-value">{{ $ingreso->fecha_ingreso->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon date-icon">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Fecha Vencimiento Lote</p>
                                        <p class="info-value">
                                            @if($ingreso->fecha_vencimiento_lote)
                                                {{ $ingreso->fecha_vencimiento_lote->format('d/m/Y') }}
                                            @else
                                                <span class="text-gray-400">Sin especificar</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="product-actions">
                            <a href="{{ route('ingresos.edit', $ingreso->id) }}" class="btn-action btn-edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </a>
                            @if($ingreso->productoDetalle)
                                <button type="button" 
                                        class="btn-action btn-view"
                                        onclick="openProductModal('{{ $ingreso->productoDetalle->id }}',
                                                                '{{ $ingreso->productoDetalle->nombre }}', 
                                                                '{{ $ingreso->productoDetalle->codigo ?? 'Sin código' }}',
                                                                '{{ $ingreso->productoDetalle->categoria->nombre ?? 'N/A' }}',
                                                                '{{ $ingreso->productoDetalle->subcategoria->nombre ?? 'N/A' }}',
                                                                '{{ number_format($ingreso->productoDetalle->precio_venta_unitario, 2) }}',
                                                                '{{ $ingreso->productoDetalle->imagen ? asset('storage/' . $ingreso->productoDetalle->imagen) : '' }}')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver Producto
                                </button>
                            @else
                                <a href="{{ route('productos.create', ['ingreso_id' => $ingreso->id]) }}" class="btn-action btn-edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Crear producto nuevo
                                </a>
                            @endif
                            <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST" class="w-full" 
                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este ingreso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="empty-title">No hay productos registrados</h3>
                    <p class="empty-text">Este proveedor aún no tiene ingresos de productos</p>
                    <a href="{{ route('ingresos.create') }}?proveedor_id={{ $proveedor->id }}" class="btn-primary mt-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Registrar Primer Producto
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</div>

{{-- Product View Modal --}}
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        {{-- Background overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeProductModal()"></div>

        {{-- Modal panel --}}
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Detalle del Producto
                            </h3>
                            <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            {{-- Image Container --}}
                            <div class="flex justify-center mb-6">
                                <div id="modal-image-container" class="relative w-48 h-48 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                    <img id="modal-image" src="" alt="Producto" class="w-full h-full object-cover">
                                    <div id="modal-no-image" class="absolute inset-0 flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Details Grid --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nombre</p>
                                    <p id="modal-nombre" class="mt-1 text-sm text-gray-900 font-semibold"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Código</p>
                                    <p id="modal-codigo" class="mt-1 text-sm text-gray-900 font-mono"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Categoría</p>
                                    <p id="modal-categoria" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Subcategoría</p>
                                    <p id="modal-subcategoria" class="mt-1 text-sm text-gray-900"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Precio de Venta</p>
                                    <p id="modal-precio" class="mt-1 text-xl text-green-600 font-bold"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <button type="button" 
                        class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-slate-600 text-base font-medium text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:w-auto sm:text-sm"
                        onclick="closeProductModal()">
                    Cerrar
                </button>
                <a id="modal-edit-btn" href="#"
                   class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function openProductModal(id, nombre, codigo, categoria, subcategoria, precio, imageUrl) {
        // Update edit button link
        const editBtn = document.getElementById('modal-edit-btn');
        editBtn.href = `/productos/${id}/editar`;
        document.getElementById('modal-nombre').textContent = nombre;
        document.getElementById('modal-codigo').textContent = codigo;
        document.getElementById('modal-categoria').textContent = categoria;
        document.getElementById('modal-subcategoria').textContent = subcategoria;
        document.getElementById('modal-precio').textContent = 'Bs ' + precio;
        
        // Handle image
        const imgElement = document.getElementById('modal-image');
        const noImageElement = document.getElementById('modal-no-image');
        
        if (imageUrl) {
            imgElement.src = imageUrl;
            imgElement.classList.remove('hidden');
            noImageElement.classList.add('hidden');
        } else {
            imgElement.classList.add('hidden');
            noImageElement.classList.remove('hidden');
        }
        
        // Show modal
        const modal = document.getElementById('productModal');
        modal.classList.remove('hidden');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProductModal();
        }
    });
</script>

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

    .provider-badge {
        width: 3.5rem;
        height: 3.5rem;
        background: rgba(34, 197, 94, 0.1);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(22, 163, 74);
    }

    .badge-count {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(34, 197, 94, 0.08);
        color: rgb(21, 128, 61);
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 9999px;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .count-dot {
        width: 0.5rem;
        height: 0.5rem;
        background: rgb(34, 197, 94);
        border-radius: 9999px;
        animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        background: rgb(22, 163, 74);
        color: white;
        font-weight: 600;
        border-radius: 0.875rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(22, 163, 74, 0.3);
    }

    .btn-primary:hover {
        background: rgb(21, 128, 61);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4);
        transform: translateY(-1px);
    }

    /* Mensaje de éxito */
    .success-message {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: rgba(34, 197, 94, 0.08);
        color: rgb(21, 128, 61);
        border-left: 4px solid rgb(34, 197, 94);
        border-radius: 0.875rem;
        font-weight: 500;
        animation: slide-in 0.3s ease-out;
    }

    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tarjetas de productos */
    .product-card {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .product-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: rgba(203, 213, 225, 0.8);
        transform: translateY(-2px);
    }

    .product-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.5rem;
    }

    @media (min-width: 1280px) {
        .product-content {
            flex-direction: row;
            justify-content: space-between;
        }
    }

    .product-info {
        flex: 1;
    }

    .product-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgb(243, 244, 246);
        margin-bottom: 1.25rem;
    }

    .product-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(37, 99, 235);
        flex-shrink: 0;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
        letter-spacing: -0.025em;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.25rem;
    }

    @media (min-width: 640px) {
        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    .info-item {
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .info-icon {
        width: 2.25rem;
        height: 2.25rem;
        background: rgb(249, 250, 251);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(107, 114, 128);
        flex-shrink: 0;
    }

    .stock-icon {
        background: rgba(34, 197, 94, 0.1);
        color: rgb(22, 163, 74);
    }

    .cost-icon {
        background: rgba(59, 130, 246, 0.1);
        color: rgb(37, 99, 235);
    }

    .date-icon {
        background: rgba(168, 85, 247, 0.1);
        color: rgb(147, 51, 234);
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: rgb(107, 114, 128);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 0.9375rem;
        font-weight: 600;
        color: rgb(31, 41, 55);
    }

    .stock-value {
        color: rgb(22, 163, 74);
    }

    /* Acciones */
    .product-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        width: 100%;
    }

    @media (min-width: 1280px) {
        .product-actions {
            width: 10rem;
            border-left: 1px solid rgb(243, 244, 246);
            padding-left: 1.5rem;
        }
    }

    .btn-action {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: rgb(249, 115, 22);
        color: white;
        box-shadow: 0 1px 3px rgba(249, 115, 22, 0.3);
    }

    .btn-edit:hover {
        background: rgb(234, 88, 12);
        box-shadow: 0 4px 10px rgba(249, 115, 22, 0.4);
        transform: translateY(-1px);
    }

    .btn-view {
        background: rgb(59, 130, 246);
        color: white;
        box-shadow: 0 1px 3px rgba(59, 130, 246, 0.3);
    }

    .btn-view:hover {
        background: rgb(37, 99, 235);
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: rgb(220, 38, 38);
        color: white;
        box-shadow: 0 1px 3px rgba(220, 38, 38, 0.3);
    }

    .btn-delete:hover {
        background: rgb(185, 28, 28);
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
        transform: translateY(-1px);
    }

    /* Estado vacío */
    .empty-state {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-icon {
        width: 5rem;
        height: 5rem;
        background: rgb(249, 250, 251);
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: rgb(156, 163, 175);
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
        margin-bottom: 0.75rem;
    }

    .empty-text {
        color: rgb(107, 114, 128);
        margin-bottom: 1.5rem;
    }

    /* Filtros */
    .filters-card {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgb(243, 244, 246);
    }

    .filters-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
    }

    .btn-reset-filters {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgb(241, 245, 249);
        color: rgb(51, 65, 85);
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 0.625rem;
        transition: all 0.2s ease;
        border: 1px solid rgb(226, 232, 240);
        cursor: pointer;
        text-decoration: none;
    }

    .btn-reset-filters:hover {
        background: rgb(226, 232, 240);
        border-color: rgb(203, 213, 225);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .filters-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .filters-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
        }
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: rgb(55, 65, 81);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .filter-input,
    .filter-select {
        padding: 0.75rem 1rem;
        background: rgb(249, 250, 251);
        border: 1px solid rgb(226, 232, 240);
        border-radius: 0.625rem;
        font-size: 0.9375rem;
        color: rgb(31, 41, 55);
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        background: white;
        border-color: rgb(59, 130, 246);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-input::placeholder {
        color: rgb(156, 163, 175);
    }

    .btn-filter {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: rgb(59, 130, 246);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        border-radius: 0.625rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(59, 130, 246, 0.3);
    }

    .btn-filter:hover {
        background: rgb(37, 99, 235);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        transform: translateY(-1px);
    }

    .btn-filter:active {
        transform: translateY(0);
    }
</style>
@endsection