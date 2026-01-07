{{-- resources/views/administrador/proveedores/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Gestión de Proveedores')

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
        
        .provider-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .provider-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px -10px rgba(242, 135, 5, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #3B7312 0%, #6fb82f 100%);
        }
        
        .search-dropdown {
            animation: slideDown 0.2s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 min-h-screen">

    @php
        $isPaginated = method_exists($proveedores, 'hasPages')
            || $proveedores instanceof \Illuminate\Contracts\Pagination\Paginator
            || $proveedores instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;

        $total = ($isPaginated && method_exists($proveedores, 'total'))
            ? $proveedores->total()
            : $proveedores->count();
    @endphp

    <div class="min-h-screen p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-truck text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Gestión de Proveedores</h1>
                        <p class="text-gray-500 text-sm">Administra la información de tus proveedores</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-4">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-accent-50 to-accent-100 rounded-full border-2 border-accent-300">
                        <span class="w-2 h-2 bg-accent-500 rounded-full animate-pulse"></span>
                        <span class="text-sm font-bold text-accent-700">{{ $total }} {{ $total === 1 ? 'Proveedor' : 'Proveedores' }}</span>
                    </div>
                    
                    <a href="{{ route('proveedores.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                        <i class="fas fa-plus"></i>
                        Agregar Proveedor
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="glass-effect rounded-2xl p-6 shadow-lg">
                <div class="flex flex-col lg:flex-row gap-4">
                    
                    <!-- Search Input -->
                    <div class="flex-1 relative">
                        <form action="{{ route('proveedores') }}" method="GET" class="w-full">
                            <div class="relative glass-effect rounded-2xl shadow-lg overflow-hidden">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-6 pointer-events-none">
                                    <i class="fas fa-search text-primary-500 text-xl"></i>
                                </div>
                                <input type="text" 
                                       id="buscador" 
                                       name="search" 
                                       autocomplete="off" 
                                       value="{{ $search ?? '' }}"
                                       placeholder="Buscar por empresa, contacto, email o teléfono..."
                                       class="w-full pl-16 pr-6 py-5 text-lg bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-400">
                            </div>
                        </form>
                        <div id="resultados-busqueda" class="absolute w-full mt-2 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 search-dropdown hidden"></div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-3">
                        @if($search || $sort)
                            <a href="{{ route('proveedores') }}" 
                               class="inline-flex items-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl border-2 border-red-200 hover:bg-red-100 transition-all">
                                <i class="fas fa-times"></i>
                                Limpiar filtros
                            </a>
                        @endif

                        <a href="{{ route('proveedores', ['search' => $search, 'sort' => 'desc']) }}" 
                           class="inline-flex items-center gap-2 px-4 py-3 font-bold rounded-xl border-2 transition-all {{ $sort === 'desc' ? 'gradient-bg text-white border-primary-500 shadow-lg' : 'bg-white text-gray-700 border-gray-200 hover:border-primary-300' }}">
                            <i class="fas fa-sort-amount-down"></i>
                            Más Reciente
                        </a>

                        <a href="{{ route('proveedores', ['search' => $search, 'sort' => 'asc']) }}" 
                           class="inline-flex items-center gap-2 px-4 py-3 font-bold rounded-xl border-2 transition-all {{ $sort === 'asc' ? 'gradient-bg text-white border-primary-500 shadow-lg' : 'bg-white text-gray-700 border-gray-200 hover:border-primary-300' }}">
                            <i class="fas fa-sort-amount-up"></i>
                            Más Antiguo
                        </a>
                    </div>

                </div>
            </div>

            <!-- Providers List -->
            <div class="space-y-4">
                @forelse ($proveedores as $proveedor)
                    <div class="provider-card glass-effect rounded-2xl p-6 shadow-lg border border-primary-100">
                        <div class="flex flex-col lg:flex-row gap-6">
                            
                            <!-- Provider Info -->
                            <div class="flex-1">
                                <div class="pb-4 border-b border-gray-200 mb-4">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $proveedor->nombre_empresa }}</h3>
                                    <p class="text-sm text-gray-500 flex items-center gap-2">
                                        <i class="fas fa-calendar-alt"></i>
                                        Registrado: {{ $proveedor->created_at->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Contacto</p>
                                        <p class="text-base font-semibold text-gray-900">{{ $proveedor->nombre_contacto ?? '-' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Celular</p>
                                        <p class="text-base font-semibold text-gray-900">{{ $proveedor->celular ?? '-' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Email</p>
                                        <p class="text-base font-semibold text-gray-900 truncate">{{ $proveedor->email ?? '-' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Productos</p>
                                        <p class="text-base font-semibold text-primary-600">{{ $proveedor->productos_count }}</p>
                                    </div>
                                </div>

                                @if($proveedor->direccion)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Dirección</p>
                                        <p class="text-sm text-gray-700">{{ $proveedor->direccion }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col gap-3 lg:w-48 lg:border-l lg:border-gray-200 lg:pl-6">
                                <a href="{{ route('proveedores.productos.index', $proveedor) }}" 
                                   class="w-full py-3 px-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                    <i class="fas fa-box mr-2"></i>Ver productos
                                </a>

                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" 
                                   class="w-full py-3 px-4 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                    <i class="fas fa-edit mr-2"></i>Editar
                                </a>

                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="w-full"
                                    onsubmit="return confirm('¿Eliminar {{ $proveedor->nombre_empresa }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full py-3 px-4 bg-red-500 text-white font-bold rounded-xl shadow-lg hover:bg-red-600 hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                        <i class="fas fa-trash mr-2"></i>Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="glass-effect rounded-2xl p-16 text-center shadow-lg">
                        <div class="w-24 h-24 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-truck text-primary-500 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No se encontraron proveedores</h3>
                        <p class="text-gray-500 mb-6">
                            @if($search)
                                No hay resultados para tu búsqueda
                            @else
                                Comienza agregando tu primer proveedor
                            @endif
                        </p>

                        @if($search)
                            <a href="{{ route('proveedores') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                Limpiar búsqueda
                            </a>
                        @else
                            <a href="{{ route('proveedores.create') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                <i class="fas fa-plus"></i>
                                Agregar Primer Proveedor
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>

@endsection

<script>
document.getElementById("buscador").addEventListener("keyup", function () {
    let query = this.value.trim();

    if (query.length < 1) {
        document.getElementById("resultados-busqueda").classList.add("hidden");
        return;
    }

    fetch(`/proveedores/buscar/ajax?search=` + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            let box = document.getElementById("resultados-busqueda");
            box.innerHTML = "";

            if (data.length === 0) {
                box.innerHTML = `<div class="p-4 text-gray-500 text-center">Sin resultados...</div>`;
            } else {
                let html = '<div class="divide-y divide-gray-100">';
                data.forEach(item => {
                    html += `
                        <a href="/proveedores/${item.id}" 
                           class="block px-6 py-4 hover:bg-primary-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-truck text-primary-600"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">${item.nombre_empresa}</div>
                                    <div class="text-sm text-gray-600">${item.nombre_contacto ?? 'Sin contacto'}</div>
                                    <div class="text-xs text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i>${item.celular ?? 'Sin celular'}</div>
                                </div>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
                box.innerHTML = html;
            }

            box.classList.remove("hidden");
        })
        .catch(error => {
            console.error("Error en búsqueda:", error);
            document.getElementById("resultados-busqueda").classList.add("hidden");
        });
});

document.addEventListener("click", function (event) {
    let buscador = document.getElementById("buscador");
    let resultados = document.getElementById("resultados-busqueda");
    
    if (!buscador.contains(event.target) && !resultados.contains(event.target)) {
        resultados.classList.add("hidden");
    }
});

document.getElementById("buscador").addEventListener("focus", function () {
    if (this.value.trim().length > 0) {
        document.getElementById("resultados-busqueda").classList.remove("hidden");
    }
});
</script>