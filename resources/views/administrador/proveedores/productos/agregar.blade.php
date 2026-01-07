{{-- resources/views/administrador/proveedores/productos/agregar.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Nuevo Ingreso')

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto space-y-6">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('proveedores') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                Proveedores
            </a>
            @if($selectedProveedor)
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('proveedores.productos.index', $selectedProveedor) }}" class="text-gray-500 hover:text-green-600 transition-colors">
                    {{ $selectedProveedor->nombre_empresa }}
                </a>
            @endif
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">Registrar Ingreso</span>
        </nav>

        {{-- Cabecera --}}
        <div class="card-elegant">
            <div class="flex items-start gap-4">
                <div class="header-icon">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">
                        Registrar Nuevo Ingreso
                    </h1>
                    <p class="text-gray-600">
                        @if($selectedProveedor)
                            Completa el formulario para registrar un nuevo lote para <span class="font-semibold text-gray-900">{{ $selectedProveedor->nombre_empresa }}</span>
                        @else
                            Completa el formulario para registrar un nuevo lote de producto
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Formulario --}}
        <div class="form-card">
            <form action="{{ route('ingresos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Mensaje de Éxito --}}
                @if(session('success'))
                    <div class="success-message">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="form-content">
                    {{-- Sección: Información del Ingreso --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon green">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h2 class="section-title">Información del Ingreso</h2>
                        </div>

                        <div class="form-grid">
                            {{-- Proveedor --}}
                            <div class="form-group full-width">
                                <label for="proveedor_id" class="form-label">
                                    Proveedor <span class="required">*</span>
                                </label>
                                @if($selectedProveedor)
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <input type="text" value="{{ $selectedProveedor->nombre_empresa }}" readonly class="form-input readonly">
                                        <input type="hidden" name="proveedor_id" value="{{ $selectedProveedor->id }}">
                                    </div>
                                @else
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <select id="proveedor_id" name="proveedor_id" required class="form-input form-select">
                                            <option value="">Selecciona un proveedor</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre_empresa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            {{-- Nombre del Producto --}}
                            <div class="form-group">
                                <label for="nombre_producto" class="form-label">
                                    Nombre del Producto <span class="required">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="nombre_producto" 
                                        name="nombre_producto" 
                                        value="{{ old('nombre_producto', $nombre_producto ?? '') }}" 
                                        required 
                                        placeholder="Ej: Gaseosa Cola 2L" 
                                        class="form-input @error('nombre_producto') error @enderror">
                                </div>
                                @error('nombre_producto')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Código de Lote --}}
                            <div class="form-group">
                                <label for="codigo_lote" class="form-label">
                                    Código de Lote
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="codigo_lote" 
                                        name="codigo_lote" 
                                        value="{{ old('codigo_lote') }}" 
                                        placeholder="Ej: LOT-2023-001" 
                                        class="form-input @error('codigo_lote') error @enderror">
                                </div>
                                @error('codigo_lote')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Unidad de Medida --}}
                            <div class="form-group">
                                <label for="unidad_medida" class="form-label">
                                    Unidad de Medida <span class="required">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 12h12l3-12H3z"></path>
                                        </svg>
                                    </div>
                                    <select id="unidad_medida" name="unidad_medida" required class="form-input form-select">
                                        <option value="Unidad" {{ old('unidad_medida') == 'Unidad' ? 'selected' : '' }}>Unidad (pieza)</option>
                                        <option value="Kilogramos" {{ old('unidad_medida') == 'Kilogramos' ? 'selected' : '' }}>Kilogramos (Kg)</option>
                                        <option value="Gramos" {{ old('unidad_medida') == 'Gramos' ? 'selected' : '' }}>Gramos (g)</option>
                                        <option value="Litros" {{ old('unidad_medida') == 'Litros' ? 'selected' : '' }}>Litros (L)</option>
                                    </select>
                                </div>
                                @error('unidad_medida')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stock Inicial --}}
                            <div class="form-group">
                                <label for="cantidad_inicial" class="form-label">
                                    Stock inicial (total) <span class="required">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="number" 
                                        id="cantidad_inicial" 
                                        name="cantidad_inicial" 
                                        value="{{ old('cantidad_inicial') }}" 
                                        required 
                                        min="1" 
                                        placeholder="Ej: 300" 
                                        class="form-input @error('cantidad_inicial') error @enderror">
                                </div>
                                @error('cantidad_inicial')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stock Mínimo --}}
                            <div class="form-group">
                                <label for="stock_minimo" class="form-label flex items-center gap-2">
                                    Stock mínimo <span class="required">*</span>
                                    <div class="relative group cursor-help">
                                        <svg class="w-4 h-4 text-gray-400 hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-20 text-center shadow-xl">
                                            Colocar la cantidad minima del producto para alertar que se requiere reestockear
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="number" 
                                        id="stock_minimo" 
                                        name="stock_minimo" 
                                        value="{{ old('stock_minimo', 0) }}" 
                                        required 
                                        min="0" 
                                        placeholder="Ej: 10" 
                                        class="form-input @error('stock_minimo') error @enderror">
                                </div>
                                @error('stock_minimo')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Costo Total --}}
                            <div class="form-group">
                                <label for="costo_total" class="form-label">
                                    Costo Total (Bs.) <span class="required">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="number" 
                                        id="costo_total" 
                                        name="costo_total" 
                                        value="{{ old('costo_total') }}" 
                                        required 
                                        min="0" 
                                        step="0.01" 
                                        placeholder="Ej: 2500.50" 
                                        class="form-input @error('costo_total') error @enderror">
                                </div>
                                @error('costo_total')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Detalles Adicionales --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon blue">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="section-title">Detalles Adicionales</h2>
                        </div>

                        <div class="form-grid">
                            {{-- Fecha de Ingreso --}}
                            <div class="form-group">
                                <label for="fecha_ingreso" class="form-label">
                                    Fecha de Ingreso <span class="required">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="date" 
                                        id="fecha_ingreso" 
                                        name="fecha_ingreso" 
                                        value="{{ old('fecha_ingreso') ?? now()->format('Y-m-d') }}" 
                                        required 
                                        class="form-input @error('fecha_ingreso') error @enderror">
                                </div>
                                @error('fecha_ingreso')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Fecha Vencimiento Lote --}}
                            <div class="form-group">
                                <label for="fecha_vencimiento_lote" class="form-label">
                                    Fecha Vencimiento Lote
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="date" 
                                        id="fecha_vencimiento_lote" 
                                        name="fecha_vencimiento_lote" 
                                        value="{{ old('fecha_vencimiento_lote') }}" 
                                        class="form-input @error('fecha_vencimiento_lote') error @enderror">
                                </div>
                                @error('fecha_vencimiento_lote')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Número de Factura --}}
                            <div class="form-group">
                                <label for="numero_factura" class="form-label">
                                    Número de Factura
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="numero_factura" 
                                        name="numero_factura" 
                                        value="{{ old('numero_factura') }}" 
                                        placeholder="Ej: F-001-2023" 
                                        class="form-input @error('numero_factura') error @enderror">
                                </div>
                                @error('numero_factura')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Foto de la Factura --}}
                            <div class="form-group">
                                <label for="foto_factura" class="form-label">
                                    Foto de la Factura
                                </label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        type="file" 
                                        id="foto_factura" 
                                        name="foto_factura" 
                                        accept="image/*"
                                        class="form-input @error('foto_factura') error @enderror">
                                </div>
                                @error('foto_factura')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Nota Informativa --}}
                    <div class="info-box">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-medium">Los campos marcados con <span class="required">*</span> son obligatorios</p>
                            <p class="text-sm mt-1">Asegúrate de completar toda la información requerida antes de enviar el formulario</p>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="form-footer">
                    <a href="{{ url()->previous() }}" class="btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Registrar Ingreso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Cards Base */
    .card-elegant {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        padding: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .header-icon {
        width: 3.5rem;
        height: 3.5rem;
        background: rgb(22, 163, 74);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }

    /* Formulario */
    .form-card {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
    }

    .form-content {
        padding: 2rem;
    }

    @media (min-width: 768px) {
        .form-content {
            padding: 2.5rem;
        }
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
        margin-bottom: 2rem;
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

    /* Secciones del Formulario */
    .form-section {
        margin-bottom: 2.5rem;
    }

    .form-section:last-of-type {
        margin-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }

    .section-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-icon.green {
        background: rgba(34, 197, 94, 0.1);
        color: rgb(22, 163, 74);
    }

    .section-icon.blue {
        background: rgba(59, 130, 246, 0.1);
        color: rgb(37, 99, 235);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
        letter-spacing: -0.025em;
    }

    /* Grid del Formulario */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: rgb(55, 65, 81);
        margin-bottom: 0.5rem;
    }

    .required {
        color: rgb(220, 38, 38);
        font-weight: 700;
    }

    /* Inputs */
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        display: flex;
        align-items: center;
        pointer-events: none;
        color: rgb(156, 163, 175);
        z-index: 10;
        transition: color 0.2s ease;
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 1px solid rgb(229, 231, 235);
        border-radius: 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
        outline: none;
        background: white;
    }

    .form-input:focus {
        border-color: rgb(22, 163, 74);
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    .form-input:focus ~ .input-icon,
    .form-input:focus + .input-icon {
        color: rgb(22, 163, 74);
    }

    .form-input.readonly {
        background: rgb(249, 250, 251);
        color: rgb(75, 85, 99);
        cursor: not-allowed;
    }

    .form-input.error {
        border-color: rgb(220, 38, 38);
    }

    .form-input.error:focus {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.25rem;
        padding-right: 3rem;
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: rgb(220, 38, 38);
    }

    /* Info Box */
    .info-box {
        display: flex;
        align-items: start;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: rgba(59, 130, 246, 0.08);
        color: rgb(30, 64, 175);
        border-radius: 0.875rem;
        border: 1px solid rgba(59, 130, 246, 0.2);
        margin-top: 2rem;
    }

    /* Footer */
    .form-footer {
        display: flex;
        flex-direction: column-reverse;
        gap: 0.75rem;
        padding: 1.5rem 2rem;
        background: rgb(249, 250, 251);
        border-top: 1px solid rgb(229, 231, 235);
    }

    @media (min-width: 640px) {
        .form-footer {
            flex-direction: row;
            justify-content: flex-end;
        }
    }

    /* Botones */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        background: rgb(22, 163, 74);
        color: white;
        font-weight: 600;
        border-radius: 0.875rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(22, 163, 74, 0.3);
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: rgb(21, 128, 61);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4);
        transform: translateY(-1px);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        background: white;
        color: rgb(55, 65, 81);
        font-weight: 600;
        border-radius: 0.875rem;
        transition: all 0.2s ease;
        border: 2px solid rgb(229, 231, 235);
    }

    .btn-secondary:hover {
        background: rgb(249, 250, 251);
        border-color: rgb(209, 213, 219);
    }
</style>
@endsection