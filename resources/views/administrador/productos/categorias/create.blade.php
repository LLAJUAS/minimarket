{{-- resources/views/administrador/productos/categorias/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nueva Categoría')

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-2xl mx-auto">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm mb-6">
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
            <span class="text-gray-900 font-medium">Nueva Categoría</span>
        </nav>

        {{-- Card Principal --}}
        <div class="form-card">
            <div class="form-header">
                <div class="flex items-center gap-3">
                    <div class="form-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="form-title">Crear Nueva Categoría</h1>
                        <p class="form-subtitle">Agrega una nueva categoría a tu tienda</p>
                    </div>
                </div>
            </div>

            {{-- Formulario --}}
            <form action="{{ route('categorias.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre de la Categoría</label>
                    <input 
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre') }}"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Crear Categoría
                    </button>
                </div>
            </form>
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
        font-size: 1.5rem;
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
</style>
@endsection
