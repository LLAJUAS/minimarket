@extends('layouts.app')

@section('content')
<div class="py-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Lotes Eliminados - {{ $proveedor->nombre_empresa }}
            </h2>
            <p class="text-gray-600 mt-1">Recupera productos eliminados o vencidos.</p>
        </div>
        <a href="{{ route('proveedores.productos.index', $proveedor->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al listado
        </a>
    </div>

    {{-- Mensaje de Éxito --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Lista de Eliminados --}}
    <div class="space-y-4">
        @forelse ($eliminados as $ingreso)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 opacity-75 hover:opacity-100 transition-opacity">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                             <div class="bg-gray-100 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $ingreso->nombre_producto }}</h3>
                                <p class="text-sm text-gray-500">Lote: {{ $ingreso->codigo_lote ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm text-gray-600">
                            <div>
                                <p class="font-medium text-gray-500">Eliminado</p>
                                <p>{{ $ingreso->deleted_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-500">Vencimiento</p>
                                <p class="{{ $ingreso->fecha_vencimiento_lote && $ingreso->fecha_vencimiento_lote->isPast() ? 'text-red-600 font-bold' : '' }}">
                                    {{ $ingreso->fecha_vencimiento_lote ? $ingreso->fecha_vencimiento_lote->format('d/m/Y') : 'N/A' }}
                                </p>
                            </div>
                             <div>
                                <p class="font-medium text-gray-500">Cantidad</p>
                                <p>{{ $ingreso->cantidad_restante }} {{ $ingreso->unidad_medida }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('ingresos.restore', $ingreso->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg transition-colors font-medium text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Restaurar Lote
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Papelera vacía</h3>
                <p class="text-gray-500">No hay productos eliminados recientemente.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
