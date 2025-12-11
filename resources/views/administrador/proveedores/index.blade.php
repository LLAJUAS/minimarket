{{-- resources/views/administrador/proveedores/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Gestión de Proveedores')

@section('content')
    @php
        $isPaginated = method_exists($proveedores, 'hasPages')
            || $proveedores instanceof \Illuminate\Contracts\Pagination\Paginator
            || $proveedores instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;

        $total = ($isPaginated && method_exists($proveedores, 'total'))
            ? $proveedores->total()
            : $proveedores->count();
    @endphp

    <div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- CABECERA --}}
            <div class="card-elegant">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="space-y-3">
                        <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Gestión de Proveedores</h1>
                        <p class="text-gray-600 text-base">Administra la información de tus proveedores</p>
                        <div class="flex items-center gap-2">
                            <span class="badge-count">
                                <span class="count-dot"></span>
                                {{ $total }} {{ $total === 1 ? 'Proveedor' : 'Proveedores' }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('proveedores.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Agregar Proveedor
                    </a>
                </div>
            </div>

            {{-- BUSCADOR Y FILTROS --}}
            <div class="card-elegant">
                <div class="flex flex-col lg:flex-row gap-4">

                    {{-- BUSCADOR --}}
                    <div class="flex-1 w-full relative">
                        <form action="{{ route('proveedores') }}" method="GET" class="w-full">
                            <div class="search-container">
                                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input 
                                    type="text" 
                                    id="buscador" 
                                    name="search" 
                                    autocomplete="off" 
                                    value="{{ $search ?? '' }}"
                                    placeholder="Buscar por empresa, contacto, email o teléfono..."
                                    class="search-input">
                            </div>
                        </form>
                        <div id="resultados-busqueda" class="search-results"></div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        {{-- BOTÓN BORRAR FILTROS --}}
                        @if($search || $sort)
                            <a href="{{ route('proveedores') }}" class="btn-clear">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Limpiar filtros
                            </a>
                        @endif

                        {{-- ORDENAR --}}
                        <a href="{{ route('proveedores', ['search' => $search, 'sort' => 'desc']) }}" 
                           class="btn-filter {{ $sort === 'desc' ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                            </svg>
                            Más Reciente
                        </a>

                        <a href="{{ route('proveedores', ['search' => $search, 'sort' => 'asc']) }}" 
                           class="btn-filter {{ $sort === 'asc' ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                            </svg>
                            Más Antiguo
                        </a>
                    </div>

                </div>
            </div>

            {{-- LISTA --}}
            <div class="space-y-4">
                @forelse ($proveedores as $proveedor)
                    <div class="provider-card">
                        <div class="provider-content">

                            {{-- INFO --}}
                            <div class="provider-info">
                                <div class="provider-header">
                                    <h3 class="provider-title">{{ $proveedor->nombre_empresa }}</h3>
                                    <p class="provider-date">
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Registrado: {{ $proveedor->created_at->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="provider-grid">
                                    <div class="info-item">
                                        <p class="info-label">Contacto</p>
                                        <p class="info-value">{{ $proveedor->nombre_contacto ?? '-' }}</p>
                                    </div>

                                    <div class="info-item">
                                        <p class="info-label">Celular</p>
                                        <p class="info-value">{{ $proveedor->celular ?? '-' }}</p>
                                    </div>

                                    <div class="info-item">
                                        <p class="info-label">Email</p>
                                        <p class="info-value">{{ $proveedor->email ?? '-' }}</p>
                                    </div>

                                    <div class="info-item">
    <p class="info-label">Productos</p>
    <p class="info-value">{{ $proveedor->productos_count }}</p>
</div>

                                    <div class="info-item">
                                        <p class="info-label">Dirección</p>
                                        <p class="info-value">{{ $proveedor->direccion ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- BOTONES --}}
                            <div class="provider-actions">
                                <a href="{{ route('proveedores.productos.index', $proveedor) }}" class="btn-action btn-green">
                                    Ver productos
                                </a>

                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn-action btn-orange">
                                    Editar
                                </a>

                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" class="w-full"
                                    onsubmit="return confirm('¿Eliminar {{ $proveedor->nombre_empresa }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-red">
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
                        <h3 class="empty-title">No se encontraron proveedores</h3>
                        <p class="empty-text">
                            @if($search)
                                No hay resultados para tu búsqueda
                            @else
                                Comienza agregando tu primer proveedor
                            @endif
                        </p>

                        @if($search)
                            <a href="{{ route('proveedores') }}" class="btn-primary mt-4">
                                Limpiar búsqueda
                            </a>
                        @else
                            <a href="{{ route('proveedores.create') }}" class="btn-primary mt-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Agregar Primer Proveedor
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <style>
        /* Cards y Contenedores */
        .card-elegant {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-elegant:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: rgba(203, 213, 225, 0.8);
        }

        /* Badge de Contador */
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

        /* Botones */
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

        .btn-clear {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.25rem;
            background: rgba(239, 68, 68, 0.08);
            color: rgb(185, 28, 28);
            font-weight: 600;
            border-radius: 0.875rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
            transition: all 0.2s ease;
        }

        .btn-clear:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.25rem;
            background: rgb(249, 250, 251);
            color: rgb(55, 65, 81);
            font-weight: 600;
            border-radius: 0.875rem;
            border: 1px solid rgb(229, 231, 235);
            transition: all 0.2s ease;
        }

        .btn-filter:hover {
            background: rgb(243, 244, 246);
            border-color: rgb(209, 213, 219);
        }

        .btn-filter.active {
            background: rgb(22, 163, 74);
            color: white;
            border-color: rgb(22, 163, 74);
            box-shadow: 0 1px 3px rgba(22, 163, 74, 0.3);
        }

        /* Buscador */
        .search-container {
            position: relative;
            width: 100%;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.25rem;
            height: 1.25rem;
            color: rgb(156, 163, 175);
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1px solid rgb(229, 231, 235);
            border-radius: 0.875rem;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .search-input:focus {
            border-color: rgb(22, 163, 74);
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }

        .search-input:focus ~ .search-icon {
            color: rgb(22, 163, 74);
        }

        .search-results {
            display: none;
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid rgb(226, 232, 240);
            border-radius: 0.875rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-height: 24rem;
            overflow-y: auto;
            z-index: 50;
        }

        .search-results:not(.hidden) {
            display: block;
        }

        /* Tarjetas de Proveedor */
        .provider-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .provider-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-color: rgba(203, 213, 225, 0.8);
            transform: translateY(-2px);
        }

        .provider-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        @media (min-width: 1280px) {
            .provider-content {
                flex-direction: row;
                justify-content: space-between;
            }
        }

        .provider-info {
            flex: 1;
        }

        .provider-header {
            padding-bottom: 1rem;
            border-bottom: 1px solid rgb(243, 244, 246);
            margin-bottom: 1.25rem;
        }

        .provider-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: rgb(17, 24, 39);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .provider-date {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.875rem;
            color: rgb(107, 114, 128);
        }

        .provider-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.25rem;
        }

        @media (min-width: 640px) {
            .provider-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .provider-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: rgb(107, 114, 128);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 0.9375rem;
            font-weight: 500;
            color: rgb(31, 41, 55);
        }

        /* Acciones */
        .provider-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
        }

        @media (min-width: 1280px) {
            .provider-actions {
                width: 11rem;
                border-left: 1px solid rgb(243, 244, 246);
                padding-left: 1.5rem;
            }
        }

        .btn-action {
            width: 100%;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-align: center;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-green {
            background: rgb(22, 163, 74);
            color: white;
            box-shadow: 0 1px 3px rgba(22, 163, 74, 0.3);
        }

        .btn-green:hover {
            background: rgb(21, 128, 61);
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.4);
            transform: translateY(-1px);
        }

        .btn-orange {
            background: rgb(249, 115, 22);
            color: white;
            box-shadow: 0 1px 3px rgba(249, 115, 22, 0.3);
        }

        .btn-orange:hover {
            background: rgb(234, 88, 12);
            box-shadow: 0 4px 10px rgba(249, 115, 22, 0.4);
            transform: translateY(-1px);
        }

        .btn-red {
            background: rgb(220, 38, 38);
            color: white;
            box-shadow: 0 1px 3px rgba(220, 38, 38, 0.3);
        }

        .btn-red:hover {
            background: rgb(185, 28, 28);
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
            transform: translateY(-1px);
        }

        /* Estado Vacío */
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
    </style>

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
                           class="block px-4 py-3 hover:bg-green-50 transition-colors">
                            <div class="font-semibold text-gray-900">${item.nombre_empresa}</div>
                            <div class="text-sm text-gray-600">${item.nombre_contacto ?? 'Sin contacto'}</div>
                            <div class="text-xs text-gray-500 mt-1">${item.celular ?? 'Sin celular'}</div>
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
</document_content>