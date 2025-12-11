{{-- resources/views/componentes/navbar.blade.php --}}

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo-link">
        <img src="{{ asset('recursos/logo.png') }}" alt="Logo don javier">
    </a>
    
    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
        <li><a href="#" class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">Nosotros</a></li>
        <li><a href="#" class="{{ request()->routeIs('contacto') ? 'active' : '' }}">Contacto</a></li>

        {{-- Solo en móvil: Iniciar Sesión --}}
        <li class="mobile-login">
            <a href="{{ route('login') }}" class="mobile-login-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Iniciar Sesión
            </a>
        </li>
    </ul>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="login-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Iniciar Sesión
        </a>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<style>
/* Importar tipografías alegres para supermercado */
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&family=Fredoka:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* --- Estilos Base del Navbar --- */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 60px;
    background: linear-gradient(135deg, #ff914d 0%, #ff7b2e 100%);
    box-shadow: 0 4px 20px rgba(255, 145, 77, 0.3);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.logo-link {
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.logo-link:hover {
    transform: scale(1.05);
}

.navbar img {
    width: 160px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

/* --- Menú de Navegación --- */
.nav-links {
    display: flex;
    list-style: none;
    gap: 40px;
    align-items: center;
    font-family: "Fredoka", "Quicksand", sans-serif;
}

.nav-links li {
    position: relative;
}

.nav-links a {
    text-decoration: none;
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    padding: 8px 12px;
    border-radius: 8px;
}

.nav-links a:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.nav-links a.active {
    background-color: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

.nav-links a.active::after { 
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 70%;
    height: 3px;
    background: #ffffff;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.5);
}

/* --- Botón de Login (Escritorio) --- */
.nav-right {
    display: flex;
    align-items: center;
    gap: 25px;
}

.login-btn {
    position: relative;
    background: linear-gradient(135deg, #00ab6fff 0%, #008037 100%);
    color: white;
    padding: 12px 28px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    font-family: "Poppins", sans-serif;
    display: flex;
    align-items: center;
    gap: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.login-btn svg {
    transition: transform 0.3s ease;
}

.login-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(45, 233, 108, 0.2), transparent);
    transition: left 0.5s ease;
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.login-btn:hover::before {
    left: 100%;
}

.login-btn:hover svg {
    transform: scale(1.1);
}

.login-btn:active {
    transform: translateY(0);
}

/* --- Menú Hamburguesa --- */
.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 5px;
    z-index: 10001;
    position: relative;
    padding: 8px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.hamburger:hover {
    background-color: rgba(255, 255, 255, 0.15);
}

.hamburger span {
    display: block;
    height: 3px;
    width: 28px;
    background: #ffffff;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(7px, 7px);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
    transform: translateX(-20px);
}

.hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

/* Ocultar link de login en escritorio */
.mobile-login {
    display: none;
}

/* --- Estilos Responsive --- */
@media (max-width: 1024px) {
    .navbar {
        padding: 15px 30px;
    }

    .nav-links {
        gap: 25px;
    }

    .nav-links a {
        font-size: 16px;
    }
}

@media (max-width: 768px) {
    .navbar {
        padding: 15px 20px;
    }

    .navbar img {
        width: 130px;
    }

    .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        height: 100vh;
        width: 85%;
        max-width: 400px;
        background: linear-gradient(180deg, #ff914d 0%, #ff7b2e 100%);
        flex-direction: column;
        align-items: flex-start;
        padding: 100px 30px 30px 30px;
        gap: 8px;
        transition: right 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: -5px 0 30px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        overflow-y: auto;
    }

    .nav-links.open {
        right: 0;
    }

    .nav-links li {
        width: 100%;
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.3s ease;
    }

    .nav-links.open li {
        opacity: 1;
        transform: translateX(0);
    }

    .nav-links.open li:nth-child(1) { transition-delay: 0.1s; }
    .nav-links.open li:nth-child(2) { transition-delay: 0.2s; }
    .nav-links.open li:nth-child(3) { transition-delay: 0.3s; }
    .nav-links.open li:nth-child(4) { transition-delay: 0.4s; }

    .hamburger {
        display: flex;
    }

    .nav-links a {
        font-size: 20px;
        padding: 15px 20px;
        display: block;
        width: 100%;
        border-radius: 12px;
        background-color: rgba(255, 255, 255, 0.1);
        margin-bottom: 8px;
    }

    .nav-links a:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateX(5px);
    }

    .nav-links a.active {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .nav-links a.active::after {
        display: none;
    }

    /* Login botón móvil */
    .mobile-login {
        display: block;
        width: 100%;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid rgba(255, 255, 255, 0.2);
    }

    .mobile-login-btn {
        padding: 14px 24px !important;
        color: #ff914d !important;
        text-decoration: none;
        font-weight: 600;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
        background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
        border-radius: 50px !important;
        font-family: "Poppins", sans-serif;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        margin-bottom: 0 !important;
    }

    .mobile-login-btn:hover {
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        transform: translateX(5px) scale(1.02);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    /* Ocultar login del nav-right en móvil */
    .nav-right .login-btn {
        display: none;
    }

    /* Overlay cuando el menú está abierto */
    .nav-links::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: -1;
    }

    .nav-links.open::before {
        opacity: 1;
        visibility: visible;
    }
}

@media (max-width: 480px) {
    .navbar {
        padding: 12px 15px;
    }

    .navbar img {
        width: 110px;
    }

    .nav-links {
        width: 100%;
        padding: 80px 20px 20px 20px;
    }

    .nav-links a {
        font-size: 18px;
        padding: 12px 18px;
    }

    .mobile-login-btn {
        padding: 12px 20px !important;
        font-size: 16px;
    }

    .hamburger span {
        width: 24px;
    }
}

/* Animación suave para transiciones */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>

<script>
// public/js/navbar.js

document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const body = document.body;

    // Toggle del menú móvil
    hamburger.addEventListener('click', function(e) {
        e.stopPropagation();
        navLinks.classList.toggle('open');
        hamburger.classList.toggle('active');
        
        // Prevenir scroll del body cuando el menú está abierto
        if (navLinks.classList.contains('open')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    });

    // Cerrar menú al hacer click en un enlace (móvil)
    const menuLinks = document.querySelectorAll('.nav-links a:not(.mobile-login-btn)');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                navLinks.classList.remove('open');
                hamburger.classList.remove('active');
                body.style.overflow = '';
            }
        });
    });

    // Cerrar menú al hacer click fuera (móvil)
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!navLinks.contains(e.target) && !hamburger.contains(e.target) && navLinks.classList.contains('open')) {
                navLinks.classList.remove('open');
                hamburger.classList.remove('active');
                body.style.overflow = '';
            }
        }
    });

    // Manejar redimensionamiento de ventana
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 768) {
                navLinks.classList.remove('open');
                hamburger.classList.remove('active');
                body.style.overflow = '';
            }
        }, 250);
    });
});
</script>