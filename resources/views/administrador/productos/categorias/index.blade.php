{{-- resources/views/administrador/productos/categorias/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Categorías')

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-green-600 transition-colors">
                Dashboard
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">Categorías</span>
        </nav>

        {{-- Cabecera --}}
        <div class="card-elegant">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="icon-badge">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.972 1.972 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Gestión de Categorías</h1>
                            <p class="text-gray-600 mt-1">Organiza tus productos por categorías y subcategorías</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="badge-count">
                            <span class="count-dot"></span>
                            {{ $categorias->count() }} {{ $categorias->count() === 1 ? 'Categoría' : 'Categorías' }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('categorias.create') }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Categoría
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

        {{-- Lista de Categorías --}}
        <div class="space-y-4">
            @forelse ($categorias as $categoria)
                <div class="category-card">
                    <div class="category-header">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="category-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="category-title">{{ $categoria->nombre }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $categoria->subcategorias->count() }} 
                                    {{ $categoria->subcategorias->count() === 1 ? 'Subcategoría' : 'Subcategorías' }}
                                </p>
                            </div>
                        </div>
                        <div class="category-actions">
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn-action btn-edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="w-full"
                                  onsubmit="return confirm('¿Estás seguro? Se eliminarán también todas las subcategorías.');">
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

                    {{-- Subcategorías --}}
                    @if($categoria->subcategorias->count() > 0)
                        <div class="subcategories-section">
                            <div class="subcategories-header">
                                <h4 class="subcategories-title">Subcategorías</h4>
                            </div>
                            <div class="subcategories-list">
                                @foreach($categoria->subcategorias as $subcategoria)
                                    <div class="subcategory-item">
                                        <div class="flex items-center gap-2 flex-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <span class="subcategory-name">{{ $subcategoria->nombre }}</span>
                                        </div>
                                        <form action="{{ route('categorias.destroySubcategoria', $subcategoria->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Eliminar esta subcategoría?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors text-sm font-medium">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="empty-title">No hay categorías registradas</h3>
                    <p class="empty-text">Comienza creando tu primera categoría</p>
                    <a href="{{ route('categorias.create') }}" class="btn-primary mt-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Crear Primera Categoría
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

    .icon-badge {
        width: 3.5rem;
        height: 3.5rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgb(37, 99, 235);
    }

    .badge-count {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(59, 130, 246, 0.08);
        color: rgb(37, 99, 235);
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 9999px;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .count-dot {
        width: 0.5rem;
        height: 0.5rem;
        background: rgb(59, 130, 246);
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
        background: rgb(59, 130, 246);
        color: white;
        font-weight: 600;
        border-radius: 0.875rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(59, 130, 246, 0.3);
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: rgb(37, 99, 235);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
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

    /* Tarjetas de categorías */
    .category-card {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .category-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-color: rgba(203, 213, 225, 0.8);
        transform: translateY(-2px);
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        border-bottom: 1px solid rgb(243, 244, 246);
    }

    .category-icon {
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

    .category-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: rgb(17, 24, 39);
        margin: 0;
    }

    .category-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .btn-action {
        display: inline-flex;
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
        text-decoration: none;
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

    /* Subcategorías */
    .subcategories-section {
        padding: 1.5rem;
        background: rgb(249, 250, 251);
    }

    .subcategories-header {
        margin-bottom: 1rem;
    }

    .subcategories-title {
        font-size: 0.9375rem;
        font-weight: 700;
        color: rgb(55, 65, 81);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0;
    }

    .subcategories-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .subcategory-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem;
        background: white;
        border-radius: 0.625rem;
        border: 1px solid rgba(226, 232, 240, 0.6);
    }

    .subcategory-name {
        font-size: 0.9375rem;
        font-weight: 500;
        color: rgb(55, 65, 81);
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

    @media (max-width: 768px) {
        .category-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .category-actions {
            width: 100%;
        }

        .btn-action {
            flex: 1;
        }
    }
</style>
@endsection
