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
                    Registrar Nuevo Producto
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
</style>
@endsection