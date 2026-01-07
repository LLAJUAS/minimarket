@extends('layouts.app')

@section('title', 'Dashboard Administrativo')

@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px -10px rgba(242, 135, 5, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #3B7312 0%, #6fb82f 100%);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Fix for sidebar dropdown on dashboard */
        .sidebar {
            z-index: 9999 !important;
        }
        .dropdown-content {
            z-index: 10000 !important;
            overflow: visible !important;
        }

        .flex-1 {
            overflow: visible !important;
        }
    </style>

<div class="flex min-h-screen">
    @include('componentes.sidebaradmin')

    <div class="flex-1 p-4 md:p-8 overflow-visible relative">
        <div class="max-w-7xl mx-auto space-y-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fadeInUp">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                        Bienvenido, <span class="text-primary-600">{{ Auth::user()->nombre }}</span>
                    </h1>
                    <p class="text-gray-500 font-medium">Aquí tienes el resumen de tu Mini Market para hoy.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block text-orange-950">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ now()->locale('es')->translatedFormat('l') }}</p>
                        <p class="text-sm font-bold text-gray-900">{{ now()->locale('es')->translatedFormat('d F, Y') }}</p>
                    </div>
                    <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg transform rotate-3">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 animate-fadeInUp" style="animation-delay: 0.1s">
                {{-- Usuarios --}}
                <div class="card-hover glass-effect rounded-3xl p-6 border-b-4 border-blue-500">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Usuarios</p>
                            <h4 class="text-2xl font-black text-gray-900">{{ number_format($stats['usuarios']) }}</h4>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-blue-600 uppercase">
                        <i class="fas fa-arrow-up mr-1"></i> Personal activo
                    </div>
                </div>

                {{-- Productos --}}
                <div class="card-hover glass-effect rounded-3xl p-6 border-b-4 border-primary-500">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-box text-primary-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Productos</p>
                            <h4 class="text-2xl font-black text-gray-900">{{ number_format($stats['productos']) }}</h4>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-primary-600 uppercase">
                        <i class="fas fa-layer-group mr-1"></i> En inventario
                    </div>
                </div>

                {{-- Proveedores --}}
                <div class="card-hover glass-effect rounded-3xl p-6 border-b-4 border-accent-500">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-accent-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-truck text-accent-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Proveedores</p>
                            <h4 class="text-2xl font-black text-gray-900">{{ number_format($stats['proveedores']) }}</h4>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-accent-600 uppercase">
                        <i class="fas fa-handshake mr-1"></i> Socios comerciales
                    </div>
                </div>

                
            </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 animate-fadeInUp" style="animation-delay: 0.1s">

            {{-- Ventas Mes --}}
                <div class="card-hover glass-effect rounded-3xl p-6 border-b-4 border-orange-500">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-orange-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Ventas Mes</p>
                            <h4 class="text-2xl font-black text-gray-900">Bs {{ number_format($stats['ventas_mes'], 2) }}</h4>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-orange-600 uppercase">
                        <i class="fas fa-shopping-basket mr-1"></i> Mes actual
                    </div>
                </div>

                {{-- Ganancias Mes --}}
                <div class="card-hover glass-effect rounded-3xl p-6 border-b-4 border-purple-500">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Ganancias Mes</p>
                            <h4 class="text-2xl font-black text-gray-900">Bs {{ number_format($stats['ganancia_mes'], 2) }}</h4>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-purple-600 uppercase">
                        <i class="fas fa-coins mr-1"></i> Margen de ganancia
                    </div>
                </div>
            </div>
            {{-- Middle Section: Charts & Shortcuts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fadeInUp" style="animation-delay: 0.2s">
                
                {{-- Tendencia de Ventas (Main Chart) --}}
                <div class="lg:col-span-2 glass-effect rounded-3xl p-8 shadow-xl card-hover">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Tendencia de Ventas</h3>
                            <p class="text-sm text-gray-500 font-medium">Ingresos generados por mes</p>
                        </div>
                        <form id="yearForm" action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                            <label class="text-xs font-bold text-gray-400 uppercase">Año:</label>
                            <select name="year" onchange="this.form.submit()" 
                                    class="bg-gray-100 border-none rounded-xl px-4 py-2 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-primary-200 outline-none cursor-pointer">
                                @foreach($añosDisponibles as $anio)
                                    <option value="{{ $anio }}" {{ $selectedYear == $anio ? 'selected' : '' }}>{{ $anio }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="h-[350px]">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                {{-- Shortcuts & Top Products --}}
                <div class="space-y-8">
                    {{-- Quick Actions --}}
                    <div class="glass-effect rounded-3xl p-6 shadow-xl card-hover">
                        <h3 class="text-lg font-black text-gray-900 mb-6">Accesos Directos</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('productos.create') }}" 
                               class="flex flex-col items-center justify-center p-4 rounded-2xl bg-primary-50 border border-primary-100 text-primary-600 hover:bg-primary-600 hover:text-white transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center mb-3 shadow-sm group-hover:scale-110 transition-transform">
                                    <i class="fas fa-plus group-hover:text-primary-600"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-tighter text-center">Registrar Producto</span>
                            </a>
                            <a href="{{ route('proveedores.create') }}" 
                               class="flex flex-col items-center justify-center p-4 rounded-2xl bg-accent-50 border border-accent-100 text-accent-600 hover:bg-accent-600 hover:text-white transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center mb-3 shadow-sm group-hover:scale-110 transition-transform">
                                    <i class="fas fa-truck group-hover:text-accent-600"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-tighter text-center">Registrar Proveedor</span>
                            </a>
                        </div>
                    </div>

                    {{-- Top Products Chart --}}
                    <div class="glass-effect rounded-3xl p-6 shadow-xl border-t-8 border-primary-500 card-hover">
                        <h3 class="text-lg font-black text-gray-900 mb-6">Top 5 productos más vendidos</h3>
                        <div class="h-[250px]">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bottom Section: Payment Methods & Daily Sales --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fadeInUp" style="animation-delay: 0.3s">
                
                {{-- Payment Methods Pie Chart --}}
                <div class="glass-effect rounded-3xl p-8 shadow-xl card-hover">
                    <div class="mb-6">
                        <h3 class="text-xl font-black text-gray-900">Métodos de Pago</h3>
                        <p class="text-sm text-gray-500 font-medium">Distribución de pagos este mes</p>
                    </div>
                    <div class="h-[300px] flex items-center justify-center">
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>

                {{-- Daily Sales Chart --}}
                <div class="glass-effect rounded-3xl p-8 shadow-xl card-hover">
                    <div class="mb-6">
                        <h3 class="text-xl font-black text-gray-900">Ventas Diarias</h3>
                        <p class="text-sm text-gray-500 font-medium">Evolución de ventas en {{ now()->locale('es')->translatedFormat('F Y') }}</p>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    // Configuración Global de Chart.js
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#94a3b8';

    // 1. Chart de Tendencia de Ventas (Línea)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const salesGradient = ctxSales.createLinearGradient(0, 0, 0, 400);
    salesGradient.addColorStop(0, 'rgba(242, 135, 5, 0.2)');
    salesGradient.addColorStop(1, 'rgba(242, 135, 5, 0)');

    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Ventas (Bs)',
                data: [
                    @foreach($chartData as $total)
                        {{ $total }},
                    @endforeach
                ],
                borderColor: '#F28705',
                borderWidth: 4,
                pointBackgroundColor: '#F2A922',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8,
                fill: true,
                backgroundColor: salesGradient,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Bs ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#e2e8f0' },
                    ticks: {
                        callback: function(value) { return 'Bs ' + value; }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Chart de Top Productos (Barras Horizontales)
    const ctxTop = document.getElementById('topProductsChart').getContext('2d');
    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: [
                @foreach($topProductos as $tp)
                    '{{ Str::limit($tp->producto->nombre, 15) }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($topProductos as $tp)
                        {{ $tp->total_vendido }},
                    @endforeach
                ],
                backgroundColor: [
                    '#F28705', '#F2A922', '#3B7312', '#6fb82f', '#2563eb'
                ],
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { display: false }
                },
                y: {
                    grid: { display: false },
                }
            }
        }
    });

    // 3. Chart de Métodos de Pago (Pie/Donut)
    const ctxPayment = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctxPayment, {
        type: 'doughnut',
        data: {
            labels: ['Efectivo', 'QR'],
            datasets: [{
                data: [{{ $pagoEfectivo }}, {{ $pagoQR }}],
                backgroundColor: [
                    '#3B7312',
                    '#F28705'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: { size: 14, weight: 'bold' },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.parsed;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // 4. Chart de Ventas Diarias (Línea)
    const ctxDaily = document.getElementById('dailySalesChart').getContext('2d');
    const dailyGradient = ctxDaily.createLinearGradient(0, 0, 0, 300);
    dailyGradient.addColorStop(0, 'rgba(59, 115, 18, 0.2)');
    dailyGradient.addColorStop(1, 'rgba(59, 115, 18, 0)');

    new Chart(ctxDaily, {
        type: 'line',
        data: {
            labels: Array.from({length: {{ count($ventasDiariasData) }}}, (_, i) => i + 1),
            datasets: [{
                label: 'Ventas (Bs)',
                data: [
                    @foreach($ventasDiariasData as $total)
                        {{ $total }},
                    @endforeach
                ],
                borderColor: '#3B7312',
                borderWidth: 3,
                pointBackgroundColor: '#6fb82f',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                backgroundColor: dailyGradient,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Día ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Bs ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#e2e8f0' },
                    ticks: {
                        callback: function(value) { return 'Bs ' + value; }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });
</script>

@endsection