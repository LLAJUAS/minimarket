{{-- resources/views/administrador/usuarios/roles.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Roles') 

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

        .role-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .role-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px -10px rgba(242, 135, 5, 0.2);
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
            <a href="{{ route('usuarios.index') }}" class="text-gray-500 hover:text-primary-600 transition-colors">
                Usuarios
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-medium">Roles</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 accent-gradient rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-shield text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Gestión de Roles</h1>
                        <p class="text-gray-500 text-sm">Administra los roles y permisos del sistema</p>
                    </div>
                </div>
                <button onclick="openAddRoleModal()" class="gradient-bg text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-plus"></i>
                    <span class="font-bold">Nuevo Rol</span>
                </button>
            </div>
        </div>

        {{-- Role Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($roles as $role)
            <div class="glass-effect role-card-hover rounded-2xl p-6 shadow-lg border border-primary-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-tag text-primary-600 text-2xl"></i>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEditRoleModal({{ $role->id }}, '{{ $role->nombre_rol }}', {{ $role->permissions->pluck('id') }})" class="w-9 h-9 flex items-center justify-center bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition-colors" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="confirmDeleteRole({{ $role->id }}, '{{ $role->nombre_rol }}')" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $role->nombre_rol }}</h3>
                <p class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-users mr-1 text-primary-500"></i>
                    {{ $role->users->count() }} usuarios asignados
                </p>
                <div class="space-y-2 mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Permisos Asignados:</p>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse($role->permissions as $perm)
                            <span class="px-2 py-1 bg-primary-50 text-primary-700 text-[10px] font-bold rounded-md border border-primary-100 uppercase">
                                {{ $perm->nombre_permiso }}
                            </span>
                        @empty
                            <span class="text-[10px] text-gray-400 italic">Sin permisos específicos</span>
                        @endforelse
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($roles->isEmpty())
        <div class="glass-effect rounded-2xl p-12 text-center shadow-lg">
            <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tag text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No hay roles registrados</h3>
            <p class="text-gray-500 mb-4">Comienza agregando un nuevo rol al sistema</p>
            <button onclick="openAddRoleModal()" class="gradient-bg text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Crear Primer Rol
            </button>
        </div>
        @endif
    </div>
</div>

{{-- Modal: Add/Edit Role --}}
<div id="modal-role" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl sm:w-full sm:max-w-md border-t-4 border-primary-500">
            <div class="gradient-bg px-6 py-4 flex justify-between items-center">
                <h3 id="role-modal-title" class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-user-tag mr-2"></i>
                    Nuevo Rol
                </h3>
                <button onclick="closeRoleModal()" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="px-6 py-6">
                <form id="role-form" action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="role-method" value="POST">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Rol: <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre_rol" id="role-nombre" required class="w-full rounded-lg border-gray-300 border p-3 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all" placeholder="Ej. Supervisor">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3 uppercase tracking-wider text-gray-500">Permisos de Acceso:</label>
                        <div class="grid grid-cols-1 gap-3 max-h-60 overflow-y-auto p-2 bg-gray-50 rounded-xl border border-gray-100">
                            @foreach($allPermissions as $permiso)
                            <label class="flex items-center p-3 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-primary-300 hover:bg-primary-50 transition-all group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permiso->id }}" 
                                           class="permission-checkbox h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition-all">
                                </div>
                                <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-primary-700">{{ $permiso->nombre_permiso }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeRoleModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-4 rounded-xl transition-all">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 gradient-bg text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openAddRoleModal() {
        document.getElementById('role-modal-title').innerHTML = '<i class="fas fa-user-tag mr-2"></i>Nuevo Rol';
        document.getElementById('role-form').action = "{{ route('roles.store') }}";
        document.getElementById('role-method').value = 'POST';
        document.getElementById('role-nombre').value = '';
        
        // Limpiar checkboxes
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        
        document.getElementById('modal-role').classList.remove('hidden');
    }

    function openEditRoleModal(id, nombre, permissionIds) {
        document.getElementById('role-modal-title').innerHTML = '<i class="fas fa-edit mr-2"></i>Editar Rol';
        document.getElementById('role-form').action = `/roles/${id}`;
        document.getElementById('role-method').value = 'PUT';
        document.getElementById('role-nombre').value = nombre;

        // Limpiar y marcar checkboxes
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.checked = permissionIds.includes(parseInt(cb.value));
        });

        document.getElementById('modal-role').classList.remove('hidden');
    }

    function closeRoleModal() {
        document.getElementById('modal-role').classList.add('hidden');
    }

    function confirmDeleteRole(id, nombre) {
        Swal.fire({
            title: '¿Eliminar rol?',
            text: `¿Estás seguro de eliminar el rol "${nombre}"? No podrás eliminarlo si tiene usuarios asignados.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.action = `/roles/${id}`;
                form.method = 'POST';
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
