{{-- resources/views/administrador/ventas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Historial de Ventas')

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
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px -10px rgba(242, 135, 5, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #3B7312 0%, #6fb82f 100%);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #F28705;
            border-radius: 10px;
        }

        @keyframes slideIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animate-slideIn {
            animation: slideIn 0.3s ease-out forwards;
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
            <span class="text-gray-900 font-medium">Historial de Ventas</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-history text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Historial de Ventas</h1>
                    <p class="text-gray-500 text-sm">Registro completo de todas las transacciones realizadas</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between mt-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-accent-50 to-accent-100 rounded-full border-2 border-accent-300">
                    <span class="w-2 h-2 bg-accent-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-bold text-accent-700">{{ $stats['transacciones'] }} Transacciones totales</span>
                </div>
                
                <a href="{{ route('venta.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                    <i class="fas fa-plus"></i>
                    Nueva Venta
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Today --}}
            <div class="glass-effect rounded-2xl p-6 shadow-lg border border-primary-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-day text-primary-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Ventas de Hoy</p>
                        <h4 class="text-2xl font-extrabold text-gray-900">Bs {{ number_format($stats['total_hoy'], 2) }}</h4>
                    </div>
                </div>
            </div>

            {{-- Week --}}
            <div class="glass-effect rounded-2xl p-6 shadow-lg border border-accent-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-accent-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-week text-accent-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Ventas de la Semana</p>
                        <h4 class="text-2xl font-extrabold text-gray-900">Bs {{ number_format($stats['total_semana'], 2) }}</h4>
                    </div>
                </div>
            </div>

            {{-- Month --}}
            <div class="glass-effect rounded-2xl p-6 shadow-lg border border-blue-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Ventas del Mes</p>
                        <h4 class="text-2xl font-extrabold text-gray-900">Bs {{ number_format($stats['total_mes'], 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <form action="{{ route('ventas.index') }}" method="GET" class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900"><i class="fas fa-filter mr-2"></i>Filtrar Ventas</h3>
                    @if(request('fecha_inicio') || request('fecha_fin') || request('search'))
                        <a href="{{ route('ventas.index') }}" class="text-sm font-bold text-red-500 hover:text-red-700">
                            <i class="fas fa-times-circle mr-1"></i>Limpiar filtros
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ordenar por</label>
                        <select name="orden" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none transition-all appearance-none cursor-pointer">
                            <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Más recientes primero</option>
                            <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Más antiguas primero</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-3 px-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                            <i class="fas fa-search mr-2"></i>Aplicar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Sales List --}}
        <div class="space-y-4">
            @forelse ($ventas as $venta)
                <div class="card-hover glass-effect rounded-2xl p-6 shadow-lg border border-primary-100">
                    <div class="flex flex-col lg:flex-row gap-6">
                        
                        {{-- Venta Basic Info --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-receipt text-primary-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Venta #{{ $venta->id }}</h3>
                                        <p class="text-xs text-gray-500 font-medium">
                                            <i class="fas fa-clock mr-1"></i>{{ $venta->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-extrabold text-accent-600 block">Bs {{ number_format($venta->total, 2) }}</span>
                                    <span class="text-[10px] font-bold uppercase py-1 px-2 rounded-full {{ $venta->metodo_pago == 'efectivo' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $venta->metodo_pago }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Cajero</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $venta->user->nombre }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Recibido</p>
                                    <p class="text-sm font-semibold text-gray-900">Bs {{ number_format($venta->monto_recibido, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Cambio</p>
                                    <p class="text-sm font-semibold text-gray-900">Bs {{ number_format($venta->vuelto, 2) }}</p>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-50">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 line-clamp-1">Productos ({{ $venta->detalles->count() }})</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($venta->detalles->take(3) as $detalle)
                                        <span class="text-[11px] bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">
                                            {{ $detalle->cantidad }}x {{ $detalle->producto->nombre }}
                                        </span>
                                    @endforeach
                                    @if($venta->detalles->count() > 3)
                                        <span class="text-[11px] bg-orange-100 text-orange-600 px-2 py-1 rounded-lg font-bold">
                                            +{{ $venta->detalles->count() - 3 }} más
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-3 lg:w-48 lg:border-l lg:border-gray-200 lg:pl-6 justify-center">
                            @if($venta->recibo && $venta->recibo->recibo_pdf)
                                <button onclick="viewReceipt('{{ $venta->recibo->recibo_pdf }}')" 
                                        class="w-full py-3 px-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                    <i class="fas fa-file-invoice mr-2"></i>Ver Recibo
                                </button>
                            @else
                                <div class="w-full py-3 px-4 bg-gray-100 text-gray-400 font-bold rounded-xl text-center cursor-not-allowed">
                                    <i class="fas fa-file-invoice mr-2"></i>Sin Recibo
                                </div>
                            @endif

                            <button onclick="viewDetails({{ $venta->id }})" 
                                   class="w-full py-3 px-4 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all text-center">
                                <i class="fas fa-eye mr-2"></i>Ver Detalles
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="glass-effect rounded-2xl p-16 text-center shadow-lg">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-receipt text-primary-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No se encontraron ventas</h3>
                    <p class="text-gray-500 mb-6">Parece que aún no hay registros de ventas que coincidan con los filtros.</p>
                    <a href="{{ route('ventas.index') }}" class="inline-flex items-center gap-2 px-6 py-3 gradient-bg text-white font-bold rounded-xl">
                        Ver todas las ventas
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $ventas->appends(request()->all())->links() }}
        </div>

    </div>
</div>

{{-- Details Modal --}}
<div id="details-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        
        <div class="relative glass-effect rounded-3xl shadow-2xl w-full max-w-2xl transform transition-all overflow-hidden border border-white/20 animate-slideIn">
            <div class="gradient-bg p-6 text-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h3 class="text-xl font-bold" id="modal-sale-id">Detalles de Venta</h3>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center hover:bg-white/20 rounded-full transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-8">
                {{-- Modal Content Placeholder --}}
                <div id="modal-content" class="space-y-6">
                    {{-- Skeleton loader or initial state --}}
                    <div class="animate-pulse flex space-y-4 flex-col">
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                        <div class="space-y-2">
                            <div class="h-10 bg-gray-100 rounded"></div>
                            <div class="h-10 bg-gray-100 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button onclick="closeModal()" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    function viewReceipt(base64) {
        const byteCharacters = atob(base64);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], {type: 'application/pdf'});
        const fileURL = URL.createObjectURL(blob);
        window.open(fileURL, '_blank');
    }

    function viewDetails(id) {
        const modal = $('#details-modal');
        const content = $('#modal-content');
        
        modal.removeClass('hidden');
        $('#modal-sale-id').text(`Venta #${id}`);
        
        content.html(`
            <div class="flex justify-center p-12">
                <div class="w-12 h-12 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin"></div>
            </div>
        `);

        $.get(`/ventas/${id}`, function(res) {
            if (res.success) {
                const venta = res.venta;
                let itemsHtml = '';
                
                venta.detalles.forEach(item => {
                    itemsHtml += `
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center overflow-hidden">
                                     <img src="${item.producto.imagen ? '/storage/' + item.producto.imagen : '/img/no-image.png'}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">${item.producto.nombre}</p>
                                    <p class="text-[10px] text-gray-500 uppercase">${item.cantidad} x Bs ${parseFloat(item.precio_unitario).toFixed(2)}</p>
                                </div>
                            </div>
                            <p class="font-bold text-gray-900">Bs ${parseFloat(item.subtotal).toFixed(2)}</p>
                        </div>
                    `;
                });

                content.html(`
                    <div class="grid grid-cols-2 gap-8 mb-6 pb-6 border-b border-gray-100">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Información de Pago</p>
                            <div class="space-y-1">
                                <p class="text-sm"><span class="text-gray-500">Método:</span> <span class="font-bold text-primary-600 uppercase">${venta.metodo_pago}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Recibido:</span> <span class="font-bold">Bs ${parseFloat(venta.monto_recibido).toFixed(2)}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Cambio:</span> <span class="font-bold">Bs ${parseFloat(venta.vuelto).toFixed(2)}</span></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Resumen</p>
                            <p class="text-xs text-gray-500">Total de la Venta</p>
                            <p class="text-4xl font-black text-accent-600">Bs ${parseFloat(venta.total).toFixed(2)}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Productos Detallados</p>
                        <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            ${itemsHtml}
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-orange-50 rounded-2xl border border-orange-100 mt-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-orange-400 uppercase">Cajero Responsable</p>
                            <p class="text-sm font-bold text-orange-800">${venta.user.nombre}</p>
                        </div>
                    </div>
                `);
            }
        });
    }

    function closeModal() {
        $('#details-modal').addClass('hidden');
    }
</script>

@endsection
