{{-- resources/views/administrador/productos/categorias/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar ' . $categoria->nombre)

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                Dashboard
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('categorias.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                Categorías
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">{{ $categoria->nombre }}</span>
        </nav>

        {{-- Card Editar Categoría --}}
        <div class="form-card">
            <div class="form-header">
                <div class="flex items-center gap-3">
                    <div class="form-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="form-title">Editar Categoría</h1>
                        <p class="form-subtitle">Actualiza los datos de la categoría</p>
                    </div>
                </div>
            </div>

            {{-- Formulario de Categoría --}}
            <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre de la Categoría</label>
                    <input 
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre', $categoria->nombre) }}"
                        placeholder="Ej: Electrónica, Ropa, Alimentos..."
                        class="form-input @error('nombre') input-error @enderror"
                        required
                    >
                    @error('nombre')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones de Acción --}}
                <div class="form-actions">
                    <a href="{{ route('categorias.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- Card Subcategorías --}}
        <div class="form-card">
            <div class="form-header">
                <div class="flex items-center gap-3">
                    <div class="form-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="form-title">Subcategorías</h2>
                        <p class="form-subtitle">Gestiona las subcategorías de esta categoría</p>
                    </div>
                </div>
            </div>

            {{-- Formulario Agregar Subcategoría --}}
            <form action="{{ route('categorias.storeSubcategoria', $categoria->id) }}" method="POST" class="space-y-6">
                @csrf

                <div class="form-group">
                    <label for="subcategoria_nombre" class="form-label">Nueva Subcategoría</label>
                    <div class="flex gap-2">
                        <input 
                            type="text"
                            id="subcategoria_nombre"
                            name="nombre"
                            placeholder="Ej: Laptops, Smartphones..."
                            class="form-input flex-1"
                            required
                        >
                        <button type="submit" class="btn-add">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Agregar
                        </button>
                    </div>
                </div>
            </form>

            {{-- Lista de Subcategorías --}}
            @if($categoria->subcategorias->count() > 0)
                <div class="subcategories-list">
                    @foreach($categoria->subcategorias as $subcategoria)
                        <div class="subcategory-item">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="subcategory-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <span class="subcategory-name">{{ $subcategoria->nombre }}</span>
                            </div>
                            <form action="{{ route('categorias.destroySubcategoria', $subcategoria->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar esta subcategoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-small">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-message">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p>No hay subcategorías. Agrega una nueva arriba.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<style>
    .form-card {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
    }

    .form-header {
        padding: 2rem;
        border-bottom: 1px solid rgb(243, 244, 246);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(59, 130, 246, 0.02) 100%);
    }

    .form-icon {
        width: 3rem;
        height: 3rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(37, 99, 235);
        flex-shrink: 0;
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
        margin: 0;
    }

    .form-subtitle {
        font-size: 0.9375rem;
        color: rgb(107, 114, 128);
        margin: 0.25rem 0 0 0;
    }

    .form-group {
        padding: 0 2rem;
    }

    .form-group:first-of-type {
        padding-top: 2rem;
    }

    .form-label {
        display: block;
        font-size: 0.9375rem;
        font-weight: 600;
        color: rgb(55, 65, 81);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        color: rgb(31, 41, 55);
        background: rgb(249, 250, 251);
        border: 1px solid rgb(226, 232, 240);
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        background: white;
        border-color: rgb(59, 130, 246);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input::placeholder {
        color: rgb(156, 163, 175);
    }

    .input-error {
        border-color: rgb(220, 38, 38);
        background: rgba(220, 38, 38, 0.02);
    }

    .input-error:focus {
        border-color: rgb(220, 38, 38);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .form-error {
        font-size: 0.875rem;
        color: rgb(220, 38, 38);
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        padding: 2rem;
        border-top: 1px solid rgb(243, 244, 246);
        background: rgb(249, 250, 251);
    }

    .btn-primary,
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        font-weight: 600;
        border-radius: 0.875rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 1rem;
    }

    .btn-primary {
        background: rgb(59, 130, 246);
        color: white;
        box-shadow: 0 1px 3px rgba(59, 130, 246, 0.3);
        flex: 1;
    }

    .btn-primary:hover {
        background: rgb(37, 99, 235);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: white;
        color: rgb(55, 65, 81);
        border: 1px solid rgb(226, 232, 240);
        flex: 1;
    }

    .btn-secondary:hover {
        background: rgb(249, 250, 251);
        border-color: rgb(203, 213, 225);
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        background: rgb(34, 197, 94);
        color: white;
        font-weight: 600;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: rgb(22, 163, 74);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
        transform: translateY(-1px);
    }

    /* Subcategorías */
    .subcategories-list {
        padding: 2rem;
        border-top: 1px solid rgb(243, 244, 246);
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .subcategory-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: rgb(249, 250, 251);
        border: 1px solid rgb(226, 232, 240);
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }

    .subcategory-item:hover {
        background: white;
        border-color: rgb(203, 213, 225);
    }

    .subcategory-icon {
        width: 1.75rem;
        height: 1.75rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(37, 99, 235);
        flex-shrink: 0;
    }

    .subcategory-name {
        font-size: 0.9375rem;
        font-weight: 500;
        color: rgb(55, 65, 81);
    }

    .btn-delete-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.5rem 0.875rem;
        background: rgb(220, 38, 38);
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-delete-small:hover {
        background: rgb(185, 28, 28);
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        transform: translateY(-1px);
    }

    .empty-message {
        padding: 2rem;
        border-top: 1px solid rgb(243, 244, 246);
        text-align: center;
        color: rgb(107, 114, 128);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .empty-message svg {
        color: rgb(156, 163, 175);
    }

    .empty-message p {
        margin: 0;
        font-size: 0.9375rem;
    }
</style>
@endsection
