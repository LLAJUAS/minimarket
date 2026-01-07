{{-- resources/views/administrador/productos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Productos')

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
        
        .product-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card-hover:hover {
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
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary-600 transition-colors">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-medium">Productos</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-box text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Productos</h1>
                    <p class="text-gray-500 text-sm">Administra tus productos, categorías y lotes</p>
                </div>
            </div>
        </div>

        {{-- Action Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Manage Categories --}}
            <a href="{{ route('categorias.index') }}" 
               class="glass-effect rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-primary-100 group">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-tags text-primary-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Gestionar Categorías</h3>
                        <p class="text-sm text-gray-600">Crea, edita y organiza categorías y subcategorías para tus productos</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-xl group-hover:text-primary-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>
         

            {{-- Register Products --}}
            <a href="{{ route('productos.empresas') }}" 
               class="glass-effect rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all border border-accent-100 group">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-accent-100 to-accent-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus-circle text-accent-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Registrar Productos</h3>
                        <p class="text-sm text-gray-600">Crea nuevos productos asignándolos a categorías y lotes</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 text-xl group-hover:text-accent-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>
</div>
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Total Products --}}
            <a href="{{ route('productos.index', ['filtro_estado' => 'todos']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ $filtroEstado == 'todos' || !$filtroEstado ? 'ring-2 ring-primary-500' : '' }}">
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
            <a href="{{ route('productos.index', ['filtro_estado' => 'proximos_vencer']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ $filtroEstado == 'proximos_vencer' ? 'ring-2 ring-yellow-500' : '' }}">
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
            <a href="{{ route('productos.index', ['filtro_estado' => 'vencidos']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ $filtroEstado == 'vencidos' ? 'ring-2 ring-purple-500' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-purple-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Vencidos</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['vencidos'] }}</h4>
                    </div>
                </div>
            </a>

            {{-- Bajo Stock --}}
            <a href="{{ route('productos.index', ['filtro_estado' => 'bajo_stock']) }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all {{ $filtroEstado == 'bajo_stock' ? 'ring-2 ring-red-500' : '' }}">
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
            <a href="{{ route('productos.eliminados') }}" 
               class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trash text-gray-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Eliminados</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $stats['eliminados'] }}</h4>
                    </div>
                </div>
            </a>
        </div>

        {{-- Filters --}}
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <form action="{{ route('productos.index') }}" method="GET">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-filter mr-2"></i>Filtros de Búsqueda
                    </h3>
                    @if($search || $categoriaId || $subcategoriaId || $orden)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-accent-50 text-accent-700 font-bold rounded-full border-2 border-accent-300">
                            <i class="fas fa-check-circle"></i>
                            Filtros aplicados
                        </span>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @if($filtroEstado)
                        <input type="hidden" name="filtro_estado" value="{{ $filtroEstado }}">
                    @endif

                    {{-- Search --}}
                    <div class="lg:col-span-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-primary-500"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="Buscar por nombre o código..." 
                               class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                    </div>

                    {{-- Category --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-primary-500"></i>
                        </div>
                        <select name="categoria_id" id="filter_categoria_id" 
                                class="w-full pl-12 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                            <option value="">Todas las Categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ (isset($categoriaId) && $categoriaId == $categoria->id) ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>

                    {{-- Subcategory --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-tags text-primary-500"></i>
                        </div>
                        <select name="subcategoria_id" id="filter_subcategoria_id" 
                                class="w-full pl-12 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none {{ empty($subcategoriaId) && empty($categoriaId) ? 'bg-gray-50 cursor-not-allowed' : '' }}"
                                {{ empty($subcategoriaId) && empty($categoriaId) ? 'disabled' : '' }}>
                            <option value="">Todas las Subcategorías</option>
                            @foreach($subcategorias as $subcategoria)
                                <option value="{{ $subcategoria->id }}" {{ (isset($subcategoriaId) && $subcategoriaId == $subcategoria->id) ? 'selected' : '' }}>
                                    {{ $subcategoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>

                    {{-- Sort --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-sort text-primary-500"></i>
                        </div>
                        <select name="orden" 
                                class="w-full pl-12 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                            <option value="desc" {{ (isset($orden) && $orden == 'desc') ? 'selected' : '' }}>Más Recientes</option>
                            <option value="asc" {{ (isset($orden) && $orden == 'asc') ? 'selected' : '' }}>Más Antiguos</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 pt-5 border-t border-gray-200">
                    <a href="{{ route('productos.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                        <i class="fas fa-redo"></i>
                        Limpiar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                        <i class="fas fa-search"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        {{-- Products Grid --}}
        @if($productos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                <div class="product-card-hover glass-effect rounded-2xl overflow-hidden shadow-lg border border-primary-100">
                    {{-- Image --}}
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 relative overflow-hidden">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                 alt="{{ $producto->nombre }}" 
                                 class="w-full h-48 object-cover object-center group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 flex items-center justify-center text-gray-300">
                                <i class="fas fa-image text-6xl"></i>
                            </div>
                        @endif
                        
                        {{-- Stock Badge (Aggregated) --}}
                        <div class="absolute top-2 right-2">
                            <span class="bg-accent-600 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full font-bold shadow-lg">
                                <i class="fas fa-box mr-1"></i>Stock: {{ $producto->stock_total ?? 0 }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5">
                        <div class="mb-3">
                            <p class="text-xs font-bold text-primary-600 uppercase tracking-wide">
                                {{ $producto->subcategoria->categoria->nombre ?? 'Sin Categoría' }}
                            </p>
                            <h3 class="text-lg font-bold text-gray-900 line-clamp-1 mt-1" title="{{ $producto->nombre }}">
                                {{ $producto->nombre }}
                            </h3>
                            @if($producto->codigo)
                                <p class="text-xs text-gray-400 font-mono mt-1">
                                    Cód: {{ $producto->codigo }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-500 line-clamp-1 mt-1">
                                {{ $producto->subcategoria->nombre ?? 'Sin Subcategoría' }}
                            </p>
                            @if($producto->fecha_vencimiento_proxima)
                                <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1">
                                    <i class="fas fa-calendar-alt"></i>
                                    Vence pronto: {{ \Carbon\Carbon::parse($producto->fecha_vencimiento_proxima)->format('d/m/Y') }}
                                </p>
                            @endif

                            @if($producto->recomendar_cambio_precio)
                                <div class="mt-3 p-3 bg-amber-50 rounded-xl border border-amber-200">
                                    <p class="text-[10px] font-bold text-amber-700 uppercase leading-tight">
                                        <i class="fas fa-lightbulb mr-1"></i>Recomendación
                                    </p>
                                    <p class="text-xs text-amber-800 font-medium">
                                        Se recomienda cambiar el precio del producto (nuevo costo detectado).
                                    </p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-xs text-gray-500 block mb-1">Precio</span>
                                <span class="text-2xl font-bold text-accent-600">Bs {{ number_format($producto->precio_venta_unitario, 2) }}</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('productos.edit', $producto->id) }}" 
                                   class="w-10 h-10 flex items-center justify-center gradient-bg text-white rounded-xl hover:shadow-lg transition-all"
                                   title="Editar Producto">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" 
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded-xl hover:bg-red-600 hover:shadow-lg transition-all"
                                            title="Eliminar Producto">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $productos->links() }}
            </div>
        @else
            <div class="glass-effect rounded-2xl p-16 text-center shadow-lg">
                <div class="w-24 h-24 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-inbox text-primary-500 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No hay productos</h3>
                <p class="text-gray-500 mb-6">Comienza registrando productos desde la opción de proveedores.</p>
            </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('filter_categoria_id');
    const subcategoriaSelect = document.getElementById('filter_subcategoria_id');
    
    // If category already selected, load subcategories
    if (categoriaSelect.value) {
        loadSubcategorias(categoriaSelect.value);
        subcategoriaSelect.disabled = false;
        subcategoriaSelect.classList.remove('bg-gray-50', 'cursor-not-allowed');
    }
    
    categoriaSelect.addEventListener('change', function() {
        const categoriaId = this.value;
        
        if (categoriaId) {
            loadSubcategorias(categoriaId);
            subcategoriaSelect.disabled = false;
            subcategoriaSelect.classList.remove('bg-gray-50', 'cursor-not-allowed');
        } else {
            subcategoriaSelect.innerHTML = '<option value="">Todas las Subcategorías</option>';
            subcategoriaSelect.disabled = true;
            subcategoriaSelect.classList.add('bg-gray-50', 'cursor-not-allowed');
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

@endsection
