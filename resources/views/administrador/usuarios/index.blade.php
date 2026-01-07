{{-- resources/views/administrador/usuarios/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        
        .gradient-bg {
            background: linear-gradient(135deg, #F28705 0%, #F2A922 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #3B7312 0%, #6fb82f 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 min-h-screen">

<div class="min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary-600 transition-colors">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-medium">Usuarios</span>
        </nav>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="glass-effect rounded-2xl p-4 mb-6 border-l-4 border-accent-500 bg-accent-50">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-accent-600 text-xl"></i>
                    <p class="text-accent-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="glass-effect rounded-2xl p-4 mb-6 border-l-4 border-red-500 bg-red-50">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Gestión de Usuarios</h1>
                        <p class="text-gray-500 text-sm">Administra los usuarios del sistema</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('roles.index') }}" class="glass-effect px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-lg hover:shadow-xl transition-all border border-accent-100 group">
                        <i class="fas fa-user-shield text-accent-600 group-hover:scale-110 transition-transform"></i>
                        <span class="font-bold text-accent-600">Gestión de Roles</span>
                    </a>
                    <button onclick="openAddUserModal()" class="gradient-bg text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-user-plus"></i>
                        <span class="font-bold">Agregar Usuario</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Users --}}
            <div class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-primary-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Total Usuarios</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $totalUsuarios }}</h4>
                    </div>
                </div>
            </div>

            {{-- Active --}}
            <div class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-accent-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-accent-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Activos</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $usuariosActivos }}</h4>
                    </div>
                </div>
            </div>

            {{-- Blocked --}}
            <div class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-ban text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Bloqueados</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $usuariosBloqueados }}</h4>
                    </div>
                </div>
            </div>

            {{-- Admins --}}
            <div class="glass-effect rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-shield text-yellow-600 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Administradores</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $totalAdmins }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <form action="{{ route('usuarios.index') }}" method="GET">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-filter mr-2"></i>Filtros de Búsqueda
                    </h3>
                    @if(request('search') || request('role_id') || request('status'))
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-accent-50 text-accent-700 font-bold rounded-full border-2 border-accent-300">
                            <i class="fas fa-check-circle"></i>
                            Filtros aplicados
                        </span>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div class="md:col-span-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-primary-500"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') ?? '' }}"
                               placeholder="Buscar por nombre, usuario, email..." 
                               class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                    </div>

                    {{-- Role --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-primary-500"></i>
                        </div>
                        <select name="role_id" 
                                class="w-full pl-12 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                            <option value="">Todos los Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nombre_rol }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-toggle-on text-primary-500"></i>
                        </div>
                        <select name="status" 
                                class="w-full pl-12 pr-10 py-3 appearance-none rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all outline-none">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('status') == 'activo' ? 'selected' : '' }}>Activos</option>
                            <option value="bloqueado" {{ request('status') == 'bloqueado' ? 'selected' : '' }}>Bloqueados</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-6">
                    <a href="{{ route('usuarios.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold transition-all flex items-center gap-2">
                        <i class="fas fa-eraser"></i>
                        Limpiar
                    </a>
                    <button type="submit" class="gradient-bg text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="glass-effect rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-primary-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Correo</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary-700 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-primary-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($usuarios as $user)
                        <tr class="hover:bg-primary-50/30 transition-all duration-200 group">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full gradient-bg text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($user->nombre, 0, 1)) }}{{ strtoupper(substr($user->apellido, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->nombre }} {{ $user->apellido }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->usuario }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" {{ $user->trashed() ? '' : 'checked' }} onchange="toggleUserStatus({{ $user->id }}, '{{ $user->nombre }}')" />
                                        <div class="group peer bg-white rounded-full duration-300 w-16 h-8 ring-2 ring-red-500 after:duration-300 after:bg-red-500 peer-checked:after:bg-accent-500 peer-checked:ring-accent-500 after:rounded-full after:absolute after:h-6 after:w-6 after:top-1 after:left-1 after:flex after:justify-center after:items-center peer-checked:after:translate-x-8 peer-hover:after:scale-95"></div>
                                    </label>
                                    <span class="status-text text-sm font-medium {{ $user->trashed() ? 'text-red-700' : 'text-accent-700' }}">
                                        {{ $user->trashed() ? 'Bloqueado' : 'Activo' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="relative">
                                    <select onchange="updateUserRole(this, {{ $user->id }}, '{{ $user->nombre }}')" class="appearance-none w-full px-3 py-1.5 text-xs font-bold rounded-full border-2 cursor-pointer transition-colors pr-8 {{ $user->roles->first()?->nombre_rol == 'Administrador' ? 'text-primary-800 border-primary-500 hover:border-primary-600' : 'text-accent-800 border-accent-500 hover:border-accent-600' }}">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->nombre_rol }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center text-sm">
                                <div class="flex justify-center items-center gap-2">
                                    <button onclick="confirmDelete({{ $user->id }}, '{{ $user->nombre }}')" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200 shadow-sm" title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal: Add User --}}
<div id="modal-add-user" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl sm:w-full sm:max-w-lg border-t-4 border-primary-500">
            <div class="gradient-bg px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Agregar nuevo usuario
                </h3>
                <button onclick="closeAddUserModal()" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="px-6 py-6">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    
                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm font-bold text-red-800 mb-2">Por favor corrige los siguientes errores:</p>
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre: <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all" placeholder="Juan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellido: <span class="text-red-500">*</span></label>
                            <input type="text" name="apellido" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all" placeholder="Pérez">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Usuario: <span class="text-red-500">*</span></label>
                            <input type="text" name="usuario" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all" placeholder="jperez">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Celular:</label>
                            <input type="text" name="celular" class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all" placeholder="70000000">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email: <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all" placeholder="juan.perez@example.com">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rol: <span class="text-red-500">*</span></label>
                        <select name="role_id" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nombre_rol }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña: <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña: <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 border p-2.5 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all">
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="closeAddUserModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-4 rounded-xl transition-all">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 gradient-bg text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openAddUserModal() {
        document.getElementById('modal-add-user').classList.remove('hidden');
    }

    function closeAddUserModal() {
        document.getElementById('modal-add-user').classList.add('hidden');
    }

    // Auto-open modal if there are validation errors
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openAddUserModal();
        });
    @endif

    function toggleUserStatus(userId, userName) {
        Swal.fire({
            title: '¿Cambiar estado?',
            text: `¿Estás seguro de cambiar el estado de acceso de ${userName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F28705',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(`/usuarios/${userId}/toggle-status`, {
                    _token: '{{ csrf_token() }}'
                }, function(res) {
                    if (res.success) {
                        Swal.fire('¡Éxito!', res.mensaje, 'success').then(() => {
                            location.reload();
                        });
                    }
                });
            } else {
                location.reload(); // Revert checkbox
            }
        });
    }

    function updateUserRole(select, userId, userName) {
        const roleId = select.value;
        Swal.fire({
            title: '¿Cambiar rol?',
            text: `¿Seguro que deseas cambiar el rol de ${userName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#F28705',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(`/usuarios/${userId}/update-role`, {
                    _token: '{{ csrf_token() }}',
                    role_id: roleId
                }, function(res) {
                    if (res.success) {
                        Swal.fire('¡Actualizado!', res.mensaje, 'success').then(() => {
                            location.reload();
                        });
                    }
                });
            } else {
                location.reload();
            }
        });
    }

    function confirmDelete(userId, userName) {
        Swal.fire({
            title: '¿Eliminar usuario?',
            text: `¿Estás seguro de eliminar permanentemente a ${userName}? Esta acción no se puede deshacer si el usuario ya está bloqueado.`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/usuarios/${userId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('¡Eliminado!', res.mensaje, 'success').then(() => {
                                location.reload();
                            });
                        }
                    }
                });
            }
        });
    }
</script>
@endsection
