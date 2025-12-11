

<div class="sidebar">
    <!-- Header con Logo -->
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">
                {{-- Asegúrate de tener este logo en public/recursos/ --}}
                <img src="{{ asset('recursos/logo.png') }}" alt="Don Javier Logo" class="logo-img">
            </div>
        </a>
    </div>

    <!-- Menú de navegación -->
    <div class="sidebar-menu">
        <div class="menu-label">MENU</div>
        
        {{-- PESTAÑA DE PROVEEDORES --}}
        <div class="menu-item">
            <a href="{{ route('proveedores') }}" class="menu-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
                <span class="menu-text">Proveedores</span>
            </a>
        </div>

        {{-- PESTAÑA DE PRODUCTOS --}}
        <div class="menu-item">
            <a href="#" class="menu-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                <span class="menu-text">Productos</span>
            </a>
        </div>
    </div>

    <!-- Sección de usuario mejorada -->
    <div class="user-section">
        <div class="user-dropdown">
            <button class="user-button" onclick="toggleUserMenu()">
                <div class="user-avatar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="user-details">
                    {{-- CORREGIDO: Usando 'nombre' y 'apellido' --}}
                    <div class="user-name">{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</div>
                    <div class="user-status">En línea</div>
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>
            
            <div class="dropdown-content" id="userDropdownMenu">
                <div class="dropdown-header">
                    <div class="dropdown-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                     <div class="dropdown-user-info">
                        <span class="dropdown-user-name">{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</span>
                        <span class="dropdown-user-email">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                
                <div class="dropdown-divider"></div>
                
                <a href="#" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Mi Perfil</span>
                </a>
                
                <div class="dropdown-divider"></div>
                
                <div class="dropdown-item">
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="submit" class="logout-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f1f5f9;
        margin-left: 280px;
        transition: margin-left 0.3s ease;
    }

    /* Sidebar Principal */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        /* Gradiente semitransparente sobre la imagen */
        background: 
            linear-gradient(135deg, rgba(241, 117, 0, 0.95) 0%, rgba(69, 174, 104, 0.83) 100%),
            url('{{ asset('recursos/12.jpg') }}'); 
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1000;
        overflow-y: auto;
        transition: all 0.3s ease;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    /* Logo */
    .sidebar-header {
        padding: 24px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        justify-content: center;
        display: flex;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        text-decoration: none;
    }

    .logo-icon img {
        width: 160px;
        height: auto;
    }

    /* Menú */
    .sidebar-menu {
        padding: 20px 0;
        flex: 1;
    }

    .menu-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 0 20px 12px 20px;
        margin-top: 20px;
    }

    .menu-label:first-child {
        margin-top: 0;
    }

    .menu-item {
        margin: 2px 12px;
    }

    .menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        font-size: 14px;
        font-weight: 500;
    }

    .menu-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(4px);
    }

    .menu-link.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .menu-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    .menu-text {
        flex: 1;
    }

    /* Sección de usuario mejorada */
    .user-section {
        position: relative;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.1);
    }

    .user-dropdown {
        position: relative;
    }

    .user-button {
        display: flex;
        align-items: center;
        width: 100%;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        cursor: pointer;
        padding: 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .user-button:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .user-details {
        flex: 1;
        text-align: left;
    }

    .user-name {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .user-status {
        color: #10b981;
        font-size: 12px;
    }

    /* Dropdown Menu */
    .dropdown-content {
        position: absolute;
        bottom: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        margin-bottom: 8px;
        overflow: hidden;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        pointer-events: none;
    }

    .dropdown-content.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .dropdown-header {
        display: flex;
        padding: 20px;
        align-items: center;
        background: linear-gradient(135deg, #098644 0%, #FF9F66 100%);
        color: white;
    }

    .dropdown-avatar {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .dropdown-user-info {
        display: flex;
        flex-direction: column;
    }

    .dropdown-user-name {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .dropdown-user-email {
        font-size: 13px;
        opacity: 0.8;
    }

    .dropdown-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: #f3f4f6;
        color: #1f2937;
    }

    .dropdown-item svg {
        margin-right: 15px;
        color: #6b7280;
    }

    .dropdown-item:hover svg {
        color: #374151;
    }

    .logout-button {
        display: flex;
        align-items: center;
        background: none;
        border: none;
        color: inherit;
        font: inherit;
        cursor: pointer;
        width: 100%;
        padding: 0;
        text-align: left;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        body {
            margin-left: 0;
        }
    }

    /* Scrollbar personalizada */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userDropdownMenu');
    menu.classList.toggle('show');
}

// Cerrar el menú al hacer clic fuera
document.addEventListener('click', function(event) {
    const userDropdown = document.querySelector('.user-dropdown');
    if (!userDropdown.contains(event.target)) {
        document.getElementById('userDropdownMenu').classList.remove('show');
    }
});
</script>