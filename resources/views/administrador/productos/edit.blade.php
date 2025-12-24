@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto space-y-6">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-green-600 transition-colors">Inicio</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('productos.index') }}" class="hover:text-green-600 transition-colors">Productos</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">Editar Producto</span>
        </nav>

        {{-- Mensajes de error y éxito --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-4">
                <div class="bg-red-100 p-2 rounded-lg text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-red-900">Error</h3>
                    <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-slate-900">Editar Producto</h1>
                    <p class="text-slate-500 mt-2">Modifique la información del producto.</p>
                </div>

                @if($ingreso)
                    <div class="mb-8 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-4">
                        <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-900">Producto asociado a lote</h3>
                            <p class="text-blue-700 text-sm mt-1">
                                Lote: <strong>{{ $ingreso->nombre_producto }}</strong> de <strong>{{ $ingreso->proveedor->nombre_empresa ?? 'Proveedor' }}</strong>.
                            </p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="productForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        <div class="col-span-2">
                            <label for="nombre" class="block text-sm font-medium text-slate-700 mb-2">
                                Nombre del Producto <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   value="{{ old('nombre', $producto->nombre) }}" 
                                   class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500"
                                   required>
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                         {{-- Código de Barras --}}
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-slate-700 mb-2">Código de Barras</label>
                            <input type="text" 
                                   name="codigo" 
                                   id="codigo" 
                                   value="{{ old('codigo', $producto->codigo) }}" 
                                   class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500"
                                   placeholder="Escanee o ingrese código">
                            @error('codigo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-slate-700 mb-2">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <select name="categoria_id" 
                                    id="categoria_id" 
                                    class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500"
                                    required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ (old('categoria_id', $producto->categoria_id) ?? $producto->subcategoria->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Subcategoría --}}
                        <div>
                            <label for="subcategoria_id" class="block text-sm font-medium text-slate-700 mb-2">
                                Subcategoría <span class="text-red-500">*</span>
                            </label>
                            <select name="subcategoria_id" 
                                    id="subcategoria_id" 
                                    class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500"
                                    required>
                                <option value="">Seleccione una subcategoría</option>
                                {{-- Las opciones se cargan vía JS, pero si falla o es inicial carga, podríamos poner las actuales si las tenemos a mano, 
                                     pero mejor confiar en el JS que disparará el change si hay valor --}}
                            </select>
                            @error('subcategoria_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Precio por Mayor (calculado) --}}
                        @if($ingreso)
                        <div>
                            <label for="precio_por_mayor" class="block text-sm font-medium text-slate-700 mb-2">Precio por Mayor (Bs)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Bs</span>
                                </div>
                                <input type="number" 
                                       step="0.01" 
                                       name="precio_por_mayor" 
                                       id="precio_por_mayor" 
                                       value="{{ number_format($ingreso->costo_total / $ingreso->cantidad_inicial, 2) }}" 
                                       class="pl-8 w-full rounded-lg border-slate-300 bg-slate-50 text-slate-600"
                                       placeholder="0.00"
                                       readonly>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Costo unitario del lote ({{ $ingreso->cantidad_inicial }} unidades)</p>
                        </div>
                        @endif

                        {{-- Precio de Venta --}}
                         <div>
                            <label for="precio_venta_unitario" class="block text-sm font-medium text-slate-700 mb-2">
                                Precio de Venta (Bs) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Bs</span>
                                </div>
                                <input type="number" 
                                       step="0.01" 
                                       name="precio_venta_unitario" 
                                       id="precio_venta_unitario" 
                                       value="{{ old('precio_venta_unitario', $producto->precio_venta_unitario) }}" 
                                       class="pl-8 w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @if($ingreso)
                            <p class="mt-1 text-xs text-slate-500">
                                Precio sugerido: <span class="font-semibold text-green-600">Bs {{ number_format(($ingreso->costo_total / $ingreso->cantidad_inicial) * 1.5, 2) }}</span> 
                                (50% de margen sobre el costo)
                            </p>
                            @endif
                            @error('precio_venta_unitario')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                         {{-- Imagen --}}
                        <div class="col-span-2">
                             <label class="block text-sm font-medium text-slate-700 mb-2">
                                Imagen del Producto
                            </label>

                            {{-- Input fuera del dropzone para mantener su referencia en el DOM al actualizar la vista previa --}}
                            <input id="imagen" name="imagen" type="file" class="sr-only" accept="image/*">

                             <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-green-500 transition-colors cursor-pointer" id="image-dropzone">
                                <div class="space-y-1 text-center" id="image-preview">
                                    @if($producto->imagen)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="mx-auto h-48 w-auto object-cover rounded-lg">
                                            <div class="mt-4">
                                                <p class="text-sm text-slate-600 font-medium">Imagen Actual</p>
                                                <div class="flex text-sm text-slate-600 justify-center mt-2">
                                                    <label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                        <span>Cambiar archivo</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Subir un archivo</span>
                                            </label>
                                            <p class="pl-1">o arrastrar y soltar</p>
                                        </div>
                                        <p class="text-xs text-slate-500">PNG, JPG, GIF hasta 10MB</p>
                                    @endif
                                </div>
                            </div>
                             @error('imagen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-slate-100">
                        <a href="{{ route('productos.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-all">
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el cambio de categoría para cargar subcategorías
    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');
    
    // Cargar subcategorías iniciales
    if (categoriaSelect.value) {
        // Pasamos el ID de la subcategoría actual para que se seleccione automáticamente
        const currentSubcategoriaId = {{ old('subcategoria_id', $producto->subcategoria_id) }};
        loadSubcategorias(categoriaSelect.value, currentSubcategoriaId);
    }
    
    categoriaSelect.addEventListener('change', function() {
        const categoriaId = this.value;
        
        if (categoriaId) {
            loadSubcategorias(categoriaId);
            subcategoriaSelect.disabled = false;
        } else {
            subcategoriaSelect.innerHTML = '<option value="">Seleccione primero una categoría</option>';
            subcategoriaSelect.disabled = true;
        }
    });
    
    function loadSubcategorias(categoriaId, selectedId = null) {
        fetch(`/categorias/${categoriaId}/subcategorias`)
            .then(response => response.json())
            .then(data => {
                subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
                
                data.forEach(subcategoria => {
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre;
                    
                    if (selectedId && subcategoria.id == selectedId) {
                        option.selected = true;
                    }
                    
                    subcategoriaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Previsualización de imagen (copiado de create.blade.php)
    const fileInput = document.getElementById('imagen');
    const dropzone = document.getElementById('image-dropzone');
    const imagePreview = document.getElementById('image-preview');
    
    // Arrastrar y soltar
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropzone.classList.add('border-green-500', 'bg-green-50');
    }
    
    function unhighlight() {
        dropzone.classList.remove('border-green-500', 'bg-green-50');
    }
    
    // Permitir clic en toda la zona
    dropzone.addEventListener('click', function(e) {
        // Evitar doble clic si se presiona el label
        if (e.target.tagName !== 'LABEL' && e.target.tagName !== 'SPAN') {
            fileInput.click();
        }
    });
    
    dropzone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    }
    
    fileInput.addEventListener('change', handleFileSelect);
    
    function handleFileSelect() {
        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            
            // Validar que sea una imagen
            if (!file.type.match('image.*')) {
                alert('El archivo seleccionado no es una imagen válida.');
                return;
            }
            
            // Validar tamaño (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('La imagen no puede ser mayor a 10MB.');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" alt="Vista previa" class="mx-auto h-48 w-auto object-cover rounded-lg">
                        <div class="mt-4">
                            <p class="text-sm text-slate-600 font-medium">${file.name}</p>
                            <p class="text-xs text-slate-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                            <div class="flex text-sm text-slate-600 justify-center mt-2">
                                <label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <span>Cambiar archivo</span>
                                </label>
                            </div>
                        </div>
                    </div>
                `;
            };
            
            reader.readAsDataURL(file);
        }
    }
    
    // Validación del formulario antes de enviar
    const form = document.getElementById('productForm');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (!categoriaSelect.value) isValid = false;
        if (!subcategoriaSelect.value) isValid = false;
        
        // Imagen NO es obligatoria en edición si ya existe
        // if (!fileInput.files || fileInput.files.length === 0) ... no chequeamos esto aquí
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
});
</script>
@endsection