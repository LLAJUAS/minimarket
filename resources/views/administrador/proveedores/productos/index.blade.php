{{-- resources/views/administrador/proveedores/productos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Productos de ' . $proveedor->nombre_empresa)

@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef7ec',
                            100: '#fdecd3',
                            200: '#fbd6a5',
                            300: '#f9ba6d',
                            400: '#F2A922',
                            500: '#F28705',
                            600: '#d96d04',
                            700: '#b45107',
                            800: '#92400d',
                            900: '#78350f',
                        },
                        accent: {
                            50: '#f0f9e8',
                            100: '#ddf2c7',
                            200: '#bfe592',
                            300: '#9dd458',
                            400: '#6fb82f',
                            500: '#3B7312',
                            600: '#2f5d0d',
                            700: '#254809',
                            800: '#1d3607',
                            900: '#162d05',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px -10px rgba(242, 135, 5, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #3B7312 0%, #6fb82f 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 min-h-screen">

<div class="min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('proveedores') }}" class="text-gray-500 hover:text-primary-600 transition-colors">
                <i class="fas fa-truck mr-1"></i> Proveedores
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-medium">{{ $proveedor->nombre_empresa }}</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $proveedor->nombre_empresa }}</h1>
                    <p class="text-gray-500 text-sm">Gestiona los ingresos y lotes de este proveedor</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between mt-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-accent-50 to-accent-100 rounded-full border-2 border-accent-300">
                    <span class="w-2 h-2 bg-accent-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-bold text-accent-700">{{ $ingresos->count() }} {{ $ingresos->count() === 1 ? 'Producto' : 'Productos' }}</span>
                </div>
                
                <a href="{{ route('ingresos.create') }}?proveedor_id={{ $proveedor->id }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                    <i class="fas fa-plus"></i>
                    Registrar nuevo lote
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-accent-50 border-l-4 border-accent-500 rounded-xl shadow-sm">
                <i class="fas fa-check-circle text-accent-600 text-xl"></i>
                <p class="text-accent-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Total Products --}}
            <a href="{{ route('proveedores.productos.index', ['proveedor' => $proveedor->id, 'filtro_estado' => 'todos']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ request('filtro_estado') == 'todos' || !request('filtro_estado') ? 'ring-2 ring-primary-500' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cubes text-primary-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Total Productos</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['total_productos'] }}</h4>
                    </div>
                </div>
            </a>

            {{-- Próximos a Vencer --}}
            <a href="{{ route('proveedores.productos.index', ['proveedor' => $proveedor->id, 'filtro_estado' => 'proximos_vencer']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ request('filtro_estado') == 'proximos_vencer' ? 'ring-2 ring-yellow-500' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Próximos a Vencer</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['proximos_vencer'] }}</h4>
                    </div>
                </div>
            </a>

            {{-- Vencidos --}}
            <a href="{{ route('proveedores.productos.index', ['proveedor' => $proveedor->id, 'filtro_estado' => 'vencidos']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ request('filtro_estado') == 'vencidos' ? 'ring-2 ring-purple-500' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-purple-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Vencidos</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['vencidos'] ?? 0 }}</h4>
                    </div>
                </div>
            </a>

            {{-- Bajo Stock --}}
            <a href="{{ route('proveedores.productos.index', ['proveedor' => $proveedor->id, 'filtro_estado' => 'bajo_stock']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ request('filtro_estado') == 'bajo_stock' ? 'ring-2 ring-red-500' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-arrow-down text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Bajo Stock</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['bajo_stock'] }}</h4>
                    </div>
                </div>
            </a>

            {{-- Eliminados --}}
            <a href="{{ route('ingresos.deleted', $proveedor->id) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trash text-gray-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Eliminados</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['eliminados'] ?? 0 }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Filters --}}
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <form method="GET" action="{{ route('proveedores.productos.index', $proveedor->id) }}" class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900"><i class="fas fa-filter mr-2"></i>Filtrar lotes</h3>
                    <a href="{{ route('proveedores.productos.index', $proveedor->id) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 font-bold rounded-xl border-2 border-red-200 hover:bg-red-100 transition-all">
                        <i class="fas fa-redo"></i>
                        Limpiar Filtros
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if(request('filtro_estado'))
                        <input type="hidden" name="filtro_estado" value="{{ request('filtro_estado') }}">
                    @endif

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del lote</label>
                        <input type="text" 
                               name="nombre_producto" 
                               value="{{ request('nombre_producto') }}"
                               placeholder="Buscar por nombre..."
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Código de Lote</label>
                        <input type="text" 
                               name="codigo_lote" 
                               value="{{ request('codigo_lote') }}"
                               placeholder="Ej: LOTE-001"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Período</label>
                        <select name="filtro_periodo" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                            <option value="">Todos los períodos</option>
                            <option value="esta_semana" {{ request('filtro_periodo') === 'esta_semana' ? 'selected' : '' }}>Esta Semana</option>
                            <option value="este_mes" {{ request('filtro_periodo') === 'este_mes' ? 'selected' : '' }}>Este Mes</option>
                            <option value="hace_2_meses" {{ request('filtro_periodo') === 'hace_2_meses' ? 'selected' : '' }}>Últimos 2 Meses</option>
                            <option value="hace_3_meses" {{ request('filtro_periodo') === 'hace_3_meses' ? 'selected' : '' }}>Últimos 3 Meses</option>
                            <option value="hace_1_año" {{ request('filtro_periodo') === 'hace_1_año' ? 'selected' : '' }}>Último Año</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" 
                               name="fecha_inicio" 
                               value="{{ request('fecha_inicio') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" 
                               name="fecha_fin" 
                               value="{{ request('fecha_fin') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-3 px-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                            <i class="fas fa-search mr-2"></i>Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Product List --}}
        <div class="space-y-4">
            @forelse ($ingresos as $ingreso)
                <div class="product-card glass-effect rounded-2xl p-6 shadow-lg border border-primary-100">
                    <div class="flex flex-col lg:flex-row gap-6">
                        
                        {{-- Product Info --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 pb-4 border-b border-gray-200 mb-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-box text-primary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $ingreso->nombre_producto }}</h3>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded-lg">
                                            <i class="fas fa-layer-group mr-1"></i>{{ $ingreso->total_lotes }} {{ $ingreso->total_lotes === 1 ? 'Lote' : 'Lotes' }}
                                        </span>
                                        @if($ingreso->reabastecido)
                                            <span class="text-xs font-bold bg-accent-100 text-accent-700 px-2 py-1 rounded-lg">
                                                <i class="fas fa-sync-alt mr-1"></i>Reabastecido
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Stock Inicial</p>
                                    <p class="text-base font-semibold text-gray-900">{{ number_format($ingreso->cantidad_inicial, 0, ',', '.') }} {{ $ingreso->unidad_medida }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Stock Total</p>
                                    <p class="text-base font-semibold {{ $ingreso->tiene_bajo_stock ? 'text-red-600' : 'text-accent-600' }}">
                                        {{ number_format($ingreso->cantidad_restante, 0, ',', '.') }} {{ $ingreso->unidad_medida }}
                                        @if($ingreso->tiene_bajo_stock)
                                            <span class="ml-2 px-2 py-0.5 text-[10px] bg-red-100 text-red-600 rounded-full font-bold uppercase animate-pulse">Atención</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Costo Total</p>
                                    <p class="text-base font-semibold text-gray-900">Bs {{ number_format($ingreso->costo_total, 2, ',', '.') }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Stock Mínimo</p>
                                    <p class="text-base font-semibold text-yellow-600">{{ number_format($ingreso->stock_minimo, 0, ',', '.') }} {{ $ingreso->unidad_medida }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Fecha Ingreso</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $ingreso->fecha_ingreso->format('d/m/Y') }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Fecha Vencimiento</p>
                                    <p class="text-base font-semibold text-gray-900">
                                        @if($ingreso->fecha_vencimiento_lote)
                                            {{ $ingreso->fecha_vencimiento_lote->format('d/m/Y') }}
                                        @else
                                            <span class="text-gray-400">Sin especificar</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($ingreso->tiene_bajo_stock)
                                <div class="mt-4 flex flex-col sm:flex-row items-center justify-between p-4 bg-red-50 rounded-2xl border border-red-100 gap-4">
                                    <div class="flex items-center gap-3 text-red-700">
                                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                            <i class="fas fa-exclamation-triangle text-2xl animate-pulse"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">¡Atención! Este producto necesita reabastecimiento</p>
                                            <p class="text-xs opacity-80">El stock actual ha alcanzado o superado el límite mínimo.</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('ingresos.create', ['proveedor_id' => $proveedor->id, 'nombre_producto' => $ingreso->nombre_producto]) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-bold rounded-xl shadow-lg hover:bg-red-700 hover:shadow-xl transition-all">
                                        <i class="fas fa-plus"></i>
                                        Agregar nuevo stock
                                    </a>
                                </div>
                            @endif

                            @if($ingreso->recomendar_cambio_precio)
                                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                        <i class="fas fa-lightbulb text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-amber-800">Recomendación de Precio</p>
                                        <p class="text-xs text-amber-700">Se recomienda modificar el precio de venta (Costo del último stock: Bs {{ number_format($ingreso->costo_reabastecimiento, 2) }})</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-3 lg:w-48 lg:border-l lg:border-gray-200 lg:pl-6">
                            <a href="{{ route('ingresos.edit', $ingreso->id) }}" 
                               class="w-full py-3 px-4 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>

                            <a href="{{ route('ingresos.show', $ingreso->id) }}" 
                               class="w-full py-3 px-4 bg-blue-500 text-white font-bold rounded-xl shadow-lg hover:bg-blue-600 hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                <i class="fas fa-layer-group mr-2"></i>Ver Lotes
                            </a>

                            @if($ingreso->productoDetalle)
                                <button type="button" 
                                        class="w-full py-3 px-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all"
                                        onclick="openProductModal('{{ $ingreso->productoDetalle->id }}',
                                                                '{{ $ingreso->productoDetalle->nombre }}', 
                                                                '{{ $ingreso->productoDetalle->codigo ?? 'Sin código' }}',
                                                                '{{ $ingreso->productoDetalle->categoria->nombre ?? 'N/A' }}',
                                                                '{{ $ingreso->productoDetalle->subcategoria->nombre ?? 'N/A' }}',
                                                                '{{ number_format($ingreso->productoDetalle->precio_venta_unitario, 2) }}',
                                                                '{{ $ingreso->productoDetalle->imagen ? asset('storage/' . $ingreso->productoDetalle->imagen) : '' }}')">
                                    <i class="fas fa-eye mr-2"></i>Ver Producto
                                </button>
                            @else
                                <a href="{{ route('productos.create', ['ingreso_id' => $ingreso->id]) }}" 
                                   class="w-full py-3 px-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                    <i class="fas fa-plus mr-2"></i>Crear producto
                                </a>
                            @endif
                        
                            <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST" class="w-full" 
                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este ingreso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-3 px-4 bg-red-500 text-white font-bold rounded-xl shadow-lg hover:bg-red-600 hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                    <i class="fas fa-trash mr-2"></i>Eliminar
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="glass-effect rounded-2xl p-16 text-center shadow-lg">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-primary-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No hay productos registrados</h3>
                    <p class="text-gray-500 mb-6">Este proveedor aún no tiene ingresos de productos</p>
                    <a href="{{ route('ingresos.create') }}?proveedor_id={{ $proveedor->id }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                        <i class="fas fa-plus"></i>
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
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeProductModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Detalle del Producto
                            </h3>
                            <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex justify-center mb-6">
                                <div id="modal-image-container" class="relative w-48 h-48 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                    <img id="modal-image" src="" alt="Producto" class="w-full h-full object-cover">
                                    <div id="modal-no-image" class="absolute inset-0 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-6xl"></i>
                                    </div>
                                </div>
                            </div>

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
                                    <p id="modal-precio" class="mt-1 text-xl text-accent-600 font-bold"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <button type="button" 
                        class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none sm:w-auto sm:text-sm"
                        onclick="closeProductModal()">
                    Cerrar
                </button>
                <a id="modal-edit-btn" href="#"
                   class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none sm:w-auto sm:text-sm">
                   <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function openProductModal(id, nombre, codigo, categoria, subcategoria, precio, imageUrl) {
        const editBtn = document.getElementById('modal-edit-btn');
        editBtn.href = `/productos/${id}/editar`;
        document.getElementById('modal-nombre').textContent = nombre;
        document.getElementById('modal-codigo').textContent = codigo;
        document.getElementById('modal-categoria').textContent = categoria;
        document.getElementById('modal-subcategoria').textContent = subcategoria;
        document.getElementById('modal-precio').textContent = 'Bs ' + precio;
        
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
        
        const modal = document.getElementById('productModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProductModal();
        }
    });
</script>

@endsection