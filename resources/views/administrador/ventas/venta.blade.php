@extends('layouts.app')

@section('title', 'Venta de Productos')

   


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
        
        .cart-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .cart-item:hover {
            transform: translateX(-4px);
            box-shadow: 0 10px 30px -10px rgba(242, 135, 5, 0.2);
        }
        
        .qty-btn {
            transition: all 0.2s ease;
        }
        
        .qty-btn:hover {
            transform: scale(1.1);
        }
        
        .qty-btn:active {
            transform: scale(0.95);
        }
        
        .payment-btn {
            transition: all 0.3s ease;
        }
        
        .payment-btn:hover {
            transform: translateY(-2px);
        }
        
        .search-dropdown {
            animation: slideDown 0.2s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
        }
        
        .total-display {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .accent-gradient {
            background: linear-gradient(135deg, #3B7312 0%, #6fb82f 100%);
        }
    </style>
</head>
<body class="min-h-screen">

<div class="flex h-screen overflow-hidden">
    <!-- Panel Izquierdo: Buscador y Carrito -->
    <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-cash-register text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Venta de productos</h1>
                        <p class="text-gray-500 text-sm">Escanea código de barras o ingresa el código manualmente del producto</p>
                    </div>
                </div>
            </div>

            <!-- Buscador -->
            <div class="relative mb-8">
                <div class="relative glass-effect rounded-2xl shadow-lg overflow-hidden">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-6 pointer-events-none">
                        <i class="fas fa-barcode text-primary-500 text-xl"></i>
                    </div>
                    <input type="text" 
                           id="buscador" 
                           class="w-full pl-16 pr-6 py-5 text-lg bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-400" 
                           placeholder="Escanea código de barras o busca por nombre del producto..." 
                           autofocus 
                           autocomplete="off">
                </div>
                <div id="search-results" class="absolute w-full mt-2 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 search-dropdown hidden"></div>
            </div>

            <!-- Listado de Carrito -->
            <div id="carrito-items" class="space-y-4">
                <div class="text-center py-20" id="cart-empty-msg">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-cart text-primary-500 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Carrito vacío</h3>
                    <p class="text-gray-500">Escanea productos para comenzar una nueva venta</p>
                </div>
            </div>

            <!-- Total -->
            <div class="mt-8 glass-effect rounded-2xl p-6 shadow-lg border-2 border-primary-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide font-medium mb-1">Total a Pagar</p>
                        <p id="cart-total" class="text-5xl font-bold total-display">Bs 0.00</p>
                    </div>
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-receipt text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Datos de Recibo -->
            <div id="section-recibo" class="mt-6 glass-effect rounded-2xl p-6 shadow-lg border-2 border-accent-200 hidden">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-accent-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-invoice text-accent-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Datos del Recibo</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">CI/NIT</label>
                        <input type="text" 
                               id="recibo_ci_nit" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none" 
                               placeholder="Ej: 1234567"
                               autocomplete="off">
                        <!-- Contenedor de Sugerencias -->
                        <div id="clientes-suggestions" class="hidden absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">
                            <!-- Los resultados se cargarán aquí -->
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Complemento (opcional)</label>
                        <input type="text" 
                               id="recibo_complemento" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none" 
                               placeholder="Ej: 1A">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                        <select id="recibo_tipo_doc" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                            <option value="CI">CI - Cédula de Identidad</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Razón Social</label>
                        <input type="text" 
                               id="recibo_razon_social" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none" 
                               placeholder="Ej: Juan Perez">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Derecho: Pago -->
    <div class="w-[450px] bg-white border-l border-gray-200 shadow-2xl overflow-y-auto">
        <div class="p-8">
            <div class="mb-8 p-4 bg-primary-50 rounded-2xl border border-primary-100 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-primary-400 uppercase tracking-widest leading-tight">Cajero Responsable</p>
                    <p class="text-sm font-bold text-primary-700">{{ Auth::user()->nombre }}</p>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-8">Información de Pago</h2>
            
            <!-- Método de Pago -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-4">Método de Pago</label>
                <div class="grid grid-cols-2 gap-4">
                    <div class="payment-method-btn payment-btn active cursor-pointer" data-method="efectivo">
                        <div class="p-5 rounded-2xl border-2 border-primary-500 bg-gradient-to-br from-primary-50 to-primary-100 text-center">
                            <i class="fas fa-money-bill-wave text-3xl text-primary-600 mb-2"></i>
                            <p class="font-bold text-primary-700">EFECTIVO</p>
                        </div>
                    </div>
                    <div class="payment-method-btn payment-btn cursor-pointer" data-method="qr">
                        <div class="p-5 rounded-2xl border-2 border-gray-200 bg-white text-center hover:border-primary-500 hover:bg-gradient-to-br hover:from-primary-50 hover:to-primary-100 transition-all">
                            <i class="fas fa-qrcode text-3xl text-gray-400 mb-2"></i>
                            <p class="font-bold text-gray-600">QR</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monto Recibido -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Monto Recibido (Bs)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary-500 font-medium text-lg">Bs</span>
                    <input type="number" 
                           id="monto_recibido" 
                           class="w-full pl-14 pr-4 py-4 text-2xl font-bold rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all outline-none" 
                           step="0.10" 
                           placeholder="0.00">
                </div>
            </div>

            <!-- Cambio -->
            <div class="mb-8 p-6 bg-gradient-to-br from-accent-50 to-accent-100 rounded-2xl border-2 border-accent-300">
                <p class="text-sm text-accent-700 mb-2 font-medium">Cambio a Entregar</p>
                <p id="vuelto" class="text-5xl font-bold text-accent-600">Bs 0.00</p>
                <div id="pago-status" class="mt-3"></div>
            </div>

            <!-- Botones -->
            <div class="space-y-3">
                <button id="btn-procesar" 
                        class="w-full py-4 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" 
                        disabled>
                    <i class="fas fa-check-circle mr-2"></i>
                    PROCESAR VENTA
                </button>
                
                <button id="btn-generar-recibo" 
                        class="w-full py-4 accent-gradient text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" 
                        disabled>
                    <i class="fas fa-file-invoice mr-2"></i>
                    GENERAR RECIBO
                </button>
                
                <button id="btn-limpiar" 
                        class="w-full py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                    <i class="fas fa-trash mr-2"></i>
                    Limpiar Carrito
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación / Notificación -->
<div id="modal-container" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-content">
            <div class="p-8 text-center" id="modal-body-container">
                <div id="modal-icon" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-question text-3xl"></i>
                </div>
                <h3 id="modal-title" class="text-2xl font-bold text-gray-900 mb-2"></h3>
                <p id="modal-message" class="text-gray-500 mb-8"></p>
                
                <div class="flex flex-col gap-3" id="modal-actions">
                    <!-- Botones dinámicos -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-show {
        display: block !important;
    }
    .modal-animate-in {
        scale: 1 !important;
        opacity: 1 !important;
    }
</style>


<script>
$(document).ready(function() {
    let carrito = [];
    let metodo_pago = 'efectivo';
    let venta_actual_id = null;

    // Escáner de código de barras: detecta entrada rápida
    let barcodeBuffer = "";
    let lastKeyTime = Date.now();

    document.addEventListener('keydown', function(e) {
        // Ignorar si el foco está en un input que no sea el buscador (excepto si el buffer ya tiene algo)
        if (document.activeElement.tagName === 'INPUT' && document.activeElement.id !== 'buscador' && barcodeBuffer.length === 0) {
            return;
        }

        const currentTime = Date.now();
        if (currentTime - lastKeyTime > 50) {
            barcodeBuffer = "";
        }
        
        if (e.key !== 'Enter') {
            if (e.key.length === 1) barcodeBuffer += e.key;
        } else {
            if (barcodeBuffer.length >= 5) {
                buscarYAgregar(barcodeBuffer);
                barcodeBuffer = "";
                e.preventDefault();
            }
        }
        lastKeyTime = currentTime;
    });

    // Búsqueda en vivo
    $('#buscador').on('input', function() {
        const term = $(this).val().trim();
        if (term.length < 2) {
            $('#search-results').addClass('hidden');
            return;
        }

        $.get("{{ route('venta.buscar.producto') }}", { term }, function(res) {
            let html = '';
            res.forEach(p => {
                html += `
                    <div class="search-result-item p-4 hover:bg-primary-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors" 
                         data-product='${JSON.stringify(p).replace(/'/g, "&apos;")}'>
                        <div class="flex items-center gap-4">
                            <img src="${p.imagen}" class="w-14 h-14 object-cover rounded-xl shadow-sm">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">${p.nombre}</p>
                                <p class="text-sm text-gray-500 mt-1">${p.codigo} • Bs ${p.precio} • Stock: ${p.stock}</p>
                            </div>
                            <i class="fas fa-plus-circle text-primary-500 text-xl"></i>
                        </div>
                    </div>
                `;
            });
            $('#search-results').html(html).removeClass('hidden');
        }).fail(function() {
            console.error("Error al buscar productos");
        });
    });

    // Delegación de eventos para resultados de búsqueda
    $(document).on('click', '.search-result-item', function() {
        const productData = $(this).data('product');
        agregarAlCarrito(productData);
    });

    // Enter en buscador
    $('#buscador').on('keypress', function(e) {
        if (e.which == 13) {
            const term = $(this).val().trim();
            if (term) {
                buscarYAgregar(term);
                $(this).val('');
                $('#search-results').addClass('hidden');
            }
        }
    });

    // Cerrar resultados al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#buscador, #search-results').length) {
            $('#search-results').addClass('hidden');
        }
    });

    function buscarYAgregar(term) {
        $.get("{{ route('venta.buscar.producto') }}", { term }, function(res) {
            if (res.length > 0) {
                // Priorizar coincidencia exacta de código
                const filtered = res.find(item => item.codigo === term);
                const p = filtered || res[0];
                agregarAlCarrito(p);
            } else {
                showModal({
                    title: 'Producto no encontrado',
                    message: `No se encontró ningún producto con el código o nombre: ${term}`,
                    type: 'error'
                });
            }
        });
    }

    function agregarAlCarrito(producto) {
        $('#search-results').addClass('hidden');
        $('#buscador').val('').focus();

        const index = carrito.findIndex(item => item.id === producto.id);
        if (index > -1) {
            if (carrito[index].cantidad + 1 > producto.stock) {
                showModal({
                    title: 'Stock insuficiente',
                    message: 'No puedes agregar más unidades de las disponibles en stock.',
                    type: 'error'
                });
                return;
            }
            carrito[index].cantidad++;
            carrito[index].subtotal = carrito[index].cantidad * carrito[index].precio;
        } else {
            if (producto.stock < 1) {
                showModal({
                    title: 'Sin stock',
                    message: 'Este producto no tiene stock disponible.',
                    type: 'error'
                });
                return;
            }
            carrito.push({
                id: producto.id,
                nombre: producto.nombre,
                codigo: producto.codigo,
                precio: parseFloat(producto.precio),
                imagen: producto.imagen,
                cantidad: 1,
                subtotal: parseFloat(producto.precio),
                stock: producto.stock,
                unidad_medida: producto.unidad_medida
            });
        }
        renderCarrito();
    }

    // Funciones globales expuestas para los onclick del renderCarrito
    window.updateQty = function(id, delta) {
        const index = carrito.findIndex(item => item.id === id);
        if (index > -1) {
            const newQty = carrito[index].cantidad + delta;
            
            if (newQty < 0.01) {
                eliminarItem(id);
                return;
            }
            
            if (newQty > carrito[index].stock) {
                showModal({
                    title: 'Límite de stock',
                    message: 'Has alcanzado la cantidad máxima disponible.',
                    type: 'error'
                });
                return;
            }

            carrito[index].cantidad = newQty;
            carrito[index].subtotal = carrito[index].cantidad * carrito[index].precio;
        }
        renderCarrito();
    };

    window.updateExactQty = function(id, val) {
        const index = carrito.findIndex(item => item.id === id);
        if (index > -1) {
            const newQty = parseFloat(val) || 0;
            
            if (newQty <= 0) {
                eliminarItem(id);
                return;
            }
            
            if (newQty > carrito[index].stock) {
                showModal({
                    title: 'Límite de stock',
                    message: 'La cantidad ingresada supera el stock disponible (' + carrito[index].stock + ')',
                    type: 'error'
                });
                carrito[index].cantidad = carrito[index].stock;
            } else {
                carrito[index].cantidad = newQty;
            }
            
            carrito[index].subtotal = carrito[index].cantidad * carrito[index].precio;
        }
        renderCarrito();
    };

    window.eliminarItem = function(id) {
        carrito = carrito.filter(item => item.id !== id);
        renderCarrito();
    };

    function renderCarrito() {
        const emptyMsg = $('#cart-empty-msg');
        if (carrito.length === 0) {
            emptyMsg.show();
            $('#carrito-items').empty().append(emptyMsg);
            $('#cart-total').text('Bs 0.00');
        } else {
            emptyMsg.hide();
            let html = '';
            let total = 0;
            carrito.forEach(item => {
                total += item.subtotal;
                const isWeighted = ['Kilogramos', 'Gramos', 'Litros', 'Kilo', 'Gramo', 'Litro'].some(u => item.unidad_medida.includes(u));
                
                html += `
                    <div class="cart-item glass-effect rounded-2xl p-5 shadow-md border border-primary-100">
                        <div class="flex items-center gap-4">
                            <img src="${item.imagen}" class="w-20 h-20 object-cover rounded-xl shadow-sm border-2 border-primary-200">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg mb-1">${item.nombre}</h3>
                                <p class="text-sm text-gray-500 mb-2">Código: ${item.codigo}</p>
                                <p class="text-primary-600 font-bold">Bs ${item.precio.toFixed(2)} <span class="text-gray-400 font-normal">por ${item.unidad_medida}</span></p>
                            </div>
                            <div class="flex items-center gap-3">
                                ${isWeighted ? `
                                    <div class="flex flex-col items-center gap-1">
                                        <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-xl border border-gray-200">
                                            <input type="number" step="0.01" value="${item.cantidad}" 
                                                   class="w-24 bg-transparent border-none text-center font-bold text-xl text-gray-900 focus:ring-0 p-0"
                                                   onchange="updateExactQty(${item.id}, this.value)">
                                            <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2 py-1 rounded-lg uppercase">${item.unidad_medida}</span>
                                        </div>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Ingrese cantidad</p>
                                    </div>
                                ` : `
                                    <button class="qty-btn w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-700 shadow-sm" onclick="updateQty(${item.id}, -1)">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="font-bold text-xl text-gray-900 w-8 text-center">${item.cantidad}</span>
                                    <button class="qty-btn w-10 h-10 bg-primary-100 hover:bg-primary-200 rounded-full flex items-center justify-center text-primary-600 shadow-sm" onclick="updateQty(${item.id}, 1)">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                `}
                            </div>
                            <div class="text-right min-w-[120px]">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Subtotal</p>
                                <p class="text-2xl font-bold text-gray-900">Bs ${item.subtotal.toFixed(2)}</p>
                            </div>
                            <button class="w-10 h-10 bg-red-50 hover:bg-red-100 rounded-full flex items-center justify-center text-red-600 transition-colors shadow-sm" onclick="eliminarItem(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            $('#carrito-items').html(html);
            $('#cart-total').text('Bs ' + total.toFixed(2));
        }
        
        if (metodo_pago === 'qr') {
            $('#monto_recibido').val(getCartTotal().toFixed(2));
        }
        
        calcularVuelto();
    }

    $('.payment-method-btn').on('click', function() {
        const selectedMethod = $(this).data('method');
        metodo_pago = selectedMethod;
        
        // Reset all buttons
        $('.payment-method-btn').find('> div').removeClass('border-primary-500 bg-gradient-to-br from-primary-50 to-primary-100').addClass('border-gray-200 bg-white');
        $('.payment-method-btn').find('i').removeClass('text-primary-600').addClass('text-gray-400');
        $('.payment-method-btn').find('p').removeClass('text-primary-700').addClass('text-gray-600');
        
        // Highlight active
        $(this).find('> div').removeClass('border-gray-200 bg-white').addClass('border-primary-500 bg-gradient-to-br from-primary-50 to-primary-100');
        $(this).find('i').removeClass('text-gray-400').addClass('text-primary-600');
        $(this).find('p').removeClass('text-gray-600').addClass('text-primary-700');
        
        if (metodo_pago === 'qr') {
            $('#monto_recibido').val(getCartTotal().toFixed(2)).prop('readonly', true);
        } else {
            $('#monto_recibido').val('').prop('readonly', false).focus();
        }
        
        calcularVuelto();
    });

    $('#monto_recibido').on('input', function() {
        calcularVuelto();
    });

    function getCartTotal() {
        return carrito.reduce((sum, item) => sum + item.subtotal, 0);
    }

    function calcularVuelto() {
        const total = getCartTotal();
        const recibido = parseFloat($('#monto_recibido').val()) || 0;
        const vuelto = recibido - total;

        if (total === 0) {
            $('#vuelto').text('Bs 0.00');
            $('#btn-procesar').prop('disabled', true);
            return;
        }

        if (metodo_pago === 'efectivo') {
            if (recibido < total) {
                $('#vuelto').text('Bs 0.00').removeClass('text-accent-600').addClass('text-gray-400');
                $('#pago-status').html('<span class="text-red-600 font-bold text-sm"><i class="fas fa-exclamation-circle mr-1"></i>PAGO INSUFICIENTE</span>');
                $('#btn-procesar').prop('disabled', true);
            } else {
                $('#vuelto').text('Bs ' + vuelto.toFixed(2)).removeClass('text-gray-400').addClass('text-accent-600');
                $('#pago-status').html('');
                $('#btn-procesar').prop('disabled', false);
            }
        } else {
            $('#vuelto').text('Bs 0.00').removeClass('text-accent-600').addClass('text-gray-400');
            $('#pago-status').html('');
            $('#btn-procesar').prop('disabled', recibido < total);
        }
    }

    // Modal, Limpiar, Procesar, Generar Recibo (sin cambios mayores en la lógica de negocio)
    window.showModal = function({ title, message, type = 'info', confirmText = 'Aceptar', cancelText = null, onConfirm = null }) {
        const modal = $('#modal-container');
        const content = $('#modal-content');
        const icon = $('#modal-icon');
        const titleEl = $('#modal-title');
        const messageEl = $('#modal-message');
        const actions = $('#modal-actions');

        icon.removeClass('bg-primary-100 text-primary-600 bg-accent-100 text-accent-600 bg-red-100 text-red-600');
        
        if (type === 'confirm') {
            icon.addClass('bg-primary-100 text-primary-600').html('<i class="fas fa-question text-3xl"></i>');
        } else if (type === 'success') {
            icon.addClass('bg-accent-100 text-accent-600').html('<i class="fas fa-check text-3xl"></i>');
        } else if (type === 'error') {
            icon.addClass('bg-red-100 text-red-600').html('<i class="fas fa-exclamation text-3xl"></i>');
        }

        titleEl.text(title);
        messageEl.text(message);
        
        let buttonsHtml = `<button class="modal-confirm w-full py-4 ${type === 'confirm' ? 'gradient-bg' : 'accent-gradient'} text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">${confirmText}</button>`;
        if (cancelText) {
            buttonsHtml += `<button class="modal-cancel w-full py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">${cancelText}</button>`;
        }
        
        actions.html(buttonsHtml);
        modal.removeClass('hidden').addClass('modal-show');
        setTimeout(() => content.addClass('modal-animate-in'), 10);

        const closeModal = () => {
            content.removeClass('modal-animate-in');
            setTimeout(() => modal.removeClass('modal-show').addClass('hidden'), 300);
        };

        actions.find('.modal-confirm').off('click').on('click', () => {
            closeModal();
            if (onConfirm) onConfirm();
        });

        actions.find('.modal-cancel').off('click').on('click', () => {
            closeModal();
        });
    };

    $('#btn-limpiar').on('click', function() {
        if (carrito.length === 0) return;
        showModal({
            title: '¿Vaciar carrito?',
            message: 'Se eliminarán todos los productos agregados.',
            type: 'confirm',
            confirmText: 'Sí, vaciar',
            cancelText: 'Cancelar',
            onConfirm: () => {
                carrito = [];
                $('#monto_recibido').val('').prop('readonly', false);
                venta_actual_id = null;
                $('#section-recibo').addClass('hidden');
                renderCarrito();
            }
        });
    });

    $('#btn-procesar').on('click', function() {
        const total = getCartTotal();
        const recibido = parseFloat($('#monto_recibido').val()) || 0;
        const vuelto = recibido - total;

        showModal({
            title: '¿Confirmar registro de venta?',
            message: `Se registrará la venta por un total de Bs ${total.toFixed(2)}.`,
            type: 'confirm',
            confirmText: 'Confirmar Venta',
            cancelText: 'Cancelar',
            onConfirm: () => {
                $('#btn-procesar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...');
                $.ajax({
                    url: "{{ route('venta.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        carrito: carrito,
                        metodo_pago: metodo_pago,
                        total: total,
                        monto_recibido: recibido,
                        vuelto: vuelto
                    },
                    success: function(res) {
                        if (res.success) {
                            showModal({
                                title: 'Venta registrada correctamente',
                                message: res.mensaje,
                                type: 'success'
                            });
                            venta_actual_id = res.venta_id;
                            $('#section-recibo').removeClass('hidden');
                            $('#btn-procesar').prop('disabled', true);
                            $('#recibo_ci_nit, #recibo_complemento, #recibo_razon_social').val('');
                        } else {
                            showModal({ title: 'Error', message: res.mensaje, type: 'error' });
                        }
                    },
                    error: function(err) {
                        showModal({ title: 'Error Crítico', message: 'Hubo un problema al procesar la venta.', type: 'error' });
                        console.error(err);
                    },
                    complete: function() {
                        $('#btn-procesar').html('<i class="fas fa-check-circle mr-2"></i>PROCESAR VENTA');
                    }
                });
            }
        });
    });

    $('#recibo_ci_nit').on('input', function() {
        const ci_nit = $(this).val().trim();
        const suggestions = $('#clientes-suggestions');

        if (ci_nit.length >= 4) {
            $.get("{{ route('venta.buscar.cliente') }}", { ci_nit }, function(res) {
                if (res.success && res.clientes.length > 0) {
                    let html = '';
                    res.clientes.forEach(cliente => {
                        html += `
                            <div class="cliente-suggestion-item p-3 hover:bg-primary-50 cursor-pointer border-b last:border-0 border-gray-100 transition-colors"
                                 data-ci="${cliente.ci_nit}"
                                 data-razon="${cliente.razon_social}"
                                 data-tipo="${cliente.tipo_documento}"
                                 data-comp="${cliente.complemento || ''}">
                                <div class="font-bold text-gray-900">${cliente.ci_nit}</div>
                                <div class="text-sm text-gray-600">${cliente.razon_social}</div>
                            </div>
                        `;
                    });
                    suggestions.html(html).removeClass('hidden');
                } else {
                    suggestions.addClass('hidden');
                }
            });
        } else {
            suggestions.addClass('hidden');
        }
    });

    // Evento al hacer clic en una sugerencia
    $(document).on('click', '.cliente-suggestion-item', function() {
        const data = $(this).data();
        $('#recibo_ci_nit').val(data.ci);
        $('#recibo_razon_social').val(data.razon);
        $('#recibo_tipo_doc').val(data.tipo);
        $('#recibo_complemento').val(data.comp);
        
        $('#clientes-suggestions').addClass('hidden');
        $('#recibo_razon_social').trigger('input');
    });

    // Cerrar sugerencias al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.relative').find('#recibo_ci_nit').length) {
            $('#clientes-suggestions').addClass('hidden');
        }
    });

    $('#recibo_ci_nit, #recibo_razon_social, #recibo_tipo_doc').on('input change', function() {
        const ci = $('#recibo_ci_nit').val().trim();
        const razon = $('#recibo_razon_social').val().trim();
        if (ci !== '' && razon !== '' && venta_actual_id !== null) {
            $('#btn-generar-recibo').prop('disabled', false);
        } else {
            $('#btn-generar-recibo').prop('disabled', true);
        }
    });

    $('#btn-generar-recibo').on('click', function() {
        if (!venta_actual_id) return;
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Generando...');
        $.ajax({
            url: "{{ route('venta.generar.recibo') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                venta_id: venta_actual_id,
                ci_nit: $('#recibo_ci_nit').val(),
                complemento: $('#recibo_complemento').val(),
                tipo_documento: $('#recibo_tipo_doc').val(),
                razon_social: $('#recibo_razon_social').val()
            },
            success: function(res) {
                if (res.success) {
                    const byteCharacters = atob(res.pdf);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const file = new Blob([byteArray], { type: 'application/pdf' });
                    const fileURL = URL.createObjectURL(file);
                    window.open(fileURL, '_blank');
                    
                    showModal({ title: 'Recibo generado', message: 'El recibo se ha abierto en una nueva pestaña.', type: 'success' });
                    
                    carrito = [];
                    $('#monto_recibido').val('').prop('readonly', false);
                    $('#section-recibo').addClass('hidden');
                    venta_actual_id = null;
                    renderCarrito();
                } else {
                    showModal({ title: 'Error', message: res.mensaje, type: 'error' });
                }
            },
            error: function(err) {
                showModal({ title: 'Error', message: 'No se pudo generar el recibo.', type: 'error' });
                console.error(err);
            },
            complete: function() {
                $('#btn-generar-recibo').html('<i class="fas fa-file-invoice mr-2"></i>GENERAR RECIBO');
            }
        });
    });
});
</script>

</body>
</html>