{{-- resources/views/administrador/proveedores/productos/ver.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle del Lote: ' . $ingresoProducto->nombre_producto)

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('proveedores') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                Proveedores
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('proveedores.productos.index', $ingresoProducto->proveedor) }}" class="text-gray-500 hover:text-green-600 transition-colors">
                {{ $ingresoProducto->proveedor->nombre_empresa }}
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">Detalle del Lote</span>
        </nav>

        {{-- Cabecera con Acciones --}}
        <div class="card-elegant">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="header-icon bg-blue-600">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $ingresoProducto->nombre_producto }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            @if($ingresoProducto->codigo_lote)
                                <span class="badge-blue">Lote: {{ $ingresoProducto->codigo_lote }}</span>
                            @endif
                            <span class="badge-gray">{{ $ingresoProducto->unidad_medida }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('ingresos.edit', $ingresoProducto) }}" class="btn-action-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Columna Principal: Datos --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="detail-card">
                    <h3 class="detail-title">Estado de Inventario</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-4">
                        <div class="data-item">
                            <span class="data-label">Stock Inicial</span>
                            <span class="data-value">{{ number_format($ingresoProducto->cantidad_inicial, 0) }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Stock Restante</span>
                            <span class="data-value {{ $ingresoProducto->cantidad_restante <= $ingresoProducto->stock_minimo ? 'text-red-600' : 'text-green-600' }}">
                                {{ number_format($ingresoProducto->cantidad_restante, 0) }}
                            </span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Stock Mínimo</span>
                            <span class="data-value text-amber-600">{{ number_format($ingresoProducto->stock_minimo, 0) }}</span>
                        </div>
                    </div>
                    
                    @if($ingresoProducto->cantidad_restante <= $ingresoProducto->stock_minimo)
                        <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3">
                            <svg class="w-6 h-6 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-bold text-red-800">Alerta de Stock Bajo</p>
                                <p class="text-xs text-red-600">Este lote ha alcanzado el límite mínimo. Se recomienda reabastecer.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="detail-card">
                    <h3 class="detail-title">Información de Compra</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div class="data-item">
                            <span class="data-label">Costo Total</span>
                            <span class="data-value text-slate-900">{{ number_format($ingresoProducto->costo_total, 2) }} Bs.</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Costo Unitario (Apróx.)</span>
                            <span class="data-value">
                                {{ number_format($ingresoProducto->costo_total / $ingresoProducto->cantidad_inicial, 2) }} Bs.
                            </span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Número de Factura</span>
                            <span class="data-value">{{ $ingresoProducto->numero_factura ?? 'No registrada' }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Fecha de Ingreso</span>
                            <span class="data-value">{{ $ingresoProducto->fecha_ingreso->format('d/m/Y') }}</span>
                        </div>
                        @if($ingresoProducto->fecha_vencimiento_lote)
                            <div class="data-item">
                                <span class="data-label">Fecha de Vencimiento</span>
                                <span class="data-value {{ $ingresoProducto->fecha_vencimiento_lote->isPast() ? 'text-red-600' : '' }}">
                                    {{ $ingresoProducto->fecha_vencimiento_lote->format('d/m/Y') }}
                                    @if($ingresoProducto->fecha_vencimiento_lote->isPast())
                                        (Vencido)
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Historial de Lotes --}}
                <div class="detail-card">
                    <h3 class="detail-title mb-4">Historial de Lotes</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Código</th>
                                    <th class="px-4 py-3 text-center">Stock</th>
                                    <th class="px-4 py-3 text-center">Ingreso</th>
                                    <th class="px-4 py-3 text-center">Vence</th>
                                    <th class="px-4 py-3 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lotes as $lote)
                                    <tr class="border-b hover:bg-gray-50 {{ $lote->id === $ingresoProducto->id ? 'bg-blue-50/50' : '' }}">
                                        <td class="px-4 py-4 font-medium text-gray-900">
                                            {{ $lote->codigo_lote ?? 'S/C' }}
                                            @if($lote->id === $ingresoProducto->id)
                                                <span class="ml-1 text-[10px] bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded font-bold">ACTUAL</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="font-bold {{ $lote->cantidad_restante <= $lote->stock_minimo ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $lote->cantidad_restante }}
                                            </span>
                                            <span class="text-xs text-gray-400">/ {{ $lote->cantidad_inicial }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            {{ $lote->fecha_ingreso->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @if($lote->fecha_vencimiento_lote)
                                                <span class="{{ $lote->fecha_vencimiento_lote->isPast() ? 'text-red-500 font-bold' : '' }}">
                                                    {{ $lote->fecha_vencimiento_lote->format('d/m/Y') }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            @if($lote->id !== $ingresoProducto->id)
                                                <a href="{{ route('ingresos.show', $lote->id) }}" class="text-blue-600 hover:text-blue-800 font-bold">
                                                    Ver Lote
                                                </a>
                                            @else
                                                <span class="text-gray-400 font-bold">Viendo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Columna Lateral: Factura --}}
            <div class="lg:col-span-1">
                <div class="detail-card h-full flex flex-col">
                    <h3 class="detail-title mb-4">Evidencia (Factura)</h3>
                    @if($ingresoProducto->foto_factura)
                        <div class="flex-1 rounded-xl overflow-hidden border border-slate-200 relative group">
                            <img src="{{ asset('storage/' . $ingresoProducto->foto_factura) }}" 
                                 alt="Factura" 
                                 class="w-full h-full object-cover">
                            <a href="{{ asset('storage/' . $ingresoProducto->foto_factura) }}" 
                               target="_blank"
                               class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-bold gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Ampliar
                            </a>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center p-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-medium text-center">No se cargó ninguna foto de la factura</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-elegant {
        background: white;
        padding: 2rem;
        border-radius: 1.5rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .header-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-blue {
        padding: 0.25rem 0.75rem;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid #dbeafe;
    }

    .badge-gray {
        padding: 0.25rem 0.75rem;
        background: #f8fafc;
        color: #64748b;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid #e2e8f0;
    }

    .btn-action-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        color: #475569;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-action-outline:hover {
        border-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
    }

    .detail-card {
        background: white;
        padding: 2rem;
        border-radius: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .detail-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
    }

    .data-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .data-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .data-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #334155;
    }
</style>
@endsection
