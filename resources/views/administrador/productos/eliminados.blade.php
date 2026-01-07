@extends('layouts.app')

@section('title', 'Productos Eliminados')

@section('content')
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

<div class="min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary-600 transition-colors">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('productos.index') }}" class="text-gray-500 hover:text-primary-600 transition-colors">
                Productos
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-medium">Eliminados</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 bg-gray-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-trash-restore text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Productos Eliminados</h1>
                    <p class="text-gray-500 text-sm">Gestiona y restaura productos que han sido eliminados del sistema</p>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-accent-50 border-l-4 border-accent-500 rounded-xl shadow-sm">
                <i class="fas fa-check-circle text-accent-600 text-xl"></i>
                <p class="text-accent-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Product List --}}
        <div class="space-y-4">
            @forelse ($eliminados as $producto)
                <div class="product-card glass-effect rounded-2xl p-6 shadow-lg border border-gray-200">
                    <div class="flex flex-col lg:flex-row gap-6">
                        
                        {{-- Product Content --}}
                        <div class="flex-1 flex gap-6">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm"
                                     alt="{{ $producto->nombre }}">
                            @else
                                <div class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                                    <i class="fas fa-image text-3xl"></i>
                                </div>
                            @endif

                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-primary-600 uppercase">{{ $producto->subcategoria->categoria->nombre ?? 'N/A' }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span class="text-xs font-medium text-gray-500">{{ $producto->subcategoria->nombre ?? 'N/A' }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $producto->nombre }}</h3>
                                <p class="text-sm text-gray-500 mb-2">Código: {{ $producto->codigo ?? 'S/N' }}</p>
                                
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="font-bold text-accent-600">Bs {{ number_format($producto->precio_venta_unitario, 2) }}</span>
                                    @if($producto->ingresoProducto)
                                        <span class="text-gray-400">|</span>
                                        <span class="text-gray-600">Stock restante: {{ $producto->ingresoProducto->cantidad_restante }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3">
                            <form action="{{ route('productos.restore', $producto->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                    <i class="fas fa-undo"></i>
                                    Restaurar Producto
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-effect rounded-2xl p-16 text-center shadow-lg">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-trash text-primary-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No hay productos eliminados</h3>
                    <p class="text-gray-500">No se encontraron productos en la papelera de reciclaje.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
