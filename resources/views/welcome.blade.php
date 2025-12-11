<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don Javier - Mini Market</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .hero-section {
            display: flex;
            height: 85vh;
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        /* -------------------------
           LADO IZQUIERDO
        --------------------------*/
        .hero-left {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 60px 80px;
            background-color: #fff;
            position: relative;
        }

        .hero-left::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 100%;
            background-color: #098644;
        }

        .hero-left::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 150px;
            background-color: #FF9F66;
        }

        .hero-content {
            max-width: 550px;
            margin-left: 40px;
        }

        .brand-name {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
            padding-left: 15px;
            border-left: 4px solid #098644;
            font-weight: 600;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 700;
            color: #098644;
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .hero-subtitle {
            font-size: 56px;
            font-weight: 700;
            color: #FF9F66;
            line-height: 1.1;
            margin-bottom: 30px;
        }

        .hero-description {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #098644;
            color: white;
            padding: 16px 32px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #076a35;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(9, 134, 68, 0.3);
        }

        .cta-button::after {
            content: '→';
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .cta-button:hover::after {
            transform: translateX(5px);
        }

        /* -------------------------
           LADO DERECHO (SOLO IMAGEN)
        --------------------------*/
        .hero-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #FF9F66;
            padding: 0;
        }

        .products-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* -------------------------
           RESPONSIVE (OCULTAR IMAGEN)
        --------------------------*/
        @media (max-width: 968px) {
            .hero-right {
                display: none !important;
            }

            .hero-section {
                height: auto;
            }

            .hero-title, .hero-subtitle {
                font-size: 40px;
            }
        }

        @media (max-width: 576px) {
            .hero-title, .hero-subtitle {
                font-size: 32px;
            }

            .hero-description {
                font-size: 14px;
            }
        }
        /* CARRUSEL SOLO RESPONSIVE */
.carousel-responsive {
    display: none;
    margin-top: 25px;
    width: 100%;
    overflow: hidden;
}

.carousel-track {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding-bottom: 10px;
}

.carousel-track img {
    width: 80%;
    flex-shrink: 0;
    border-radius: 15px;
    scroll-snap-align: center;
    object-fit: cover;
}

/* Mostrar el carrusel solo en pantallas pequeñas */
@media (max-width: 968px) {
    .carousel-responsive {
        display: block;
    }
}
/* CARRUSEL SOLO RESPONSIVE */
.carousel-responsive {
    display: none;
    margin: 30px 0;
    width: 100%;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 30px 0;
}

.carousel-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 0 20px;
}

.carousel-title {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    color: #098644;
    margin-bottom: 25px;
}

.carousel-track {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding: 20px 10px 30px 10px;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

.carousel-track::-webkit-scrollbar {
    height: 8px;
}

.carousel-track::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
    border-radius: 10px;
}

.carousel-track::-webkit-scrollbar-thumb {
    background: #098644;
    border-radius: 10px;
}

.carousel-track::-webkit-scrollbar-thumb:hover {
    background: #076a35;
}

.carousel-item {
    flex: 0 0 85%;
    scroll-snap-align: center;
    position: relative;
}

.carousel-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.carousel-item:hover img {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.carousel-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: rgba(9, 134, 68, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
}

.dot.active {
    background-color: #098644;
    width: 30px;
    border-radius: 5px;
}

/* Mostrar el carrusel solo en pantallas pequeñas */
@media (max-width: 968px) {
    .carousel-responsive {
        display: block;
    }
}

@media (max-width: 576px) {
    .carousel-title {
        font-size: 24px;
    }
    
    .carousel-item {
        flex: 0 0 90%;
    }
    
    .carousel-item img {
        height: 220px;
    }
}

    </style>
</head>
<body>

@include('componentes.navbar')

<section class="hero-section">

    <div class="hero-left">
    <div class="hero-content">
        <div class="brand-name">Don Javier</div>
        <h1 class="hero-title">El Mini Market de</h1>
        <h1 class="hero-subtitle">Tu Barrio</h1>
        <p class="hero-description">
            Productos frescos, precios accesibles y todo lo que necesitas en un solo lugar. Compra rápido, fácil y sin complicaciones.
        </p>
        <a href="{{ route('login') }}" class="cta-button">INICIAR SESIÓN</a>

       

    </div>
</div>



    <div class="hero-right">
        <img src="{{ asset('recursos/landing2.png') }}" alt="Mini Market" class="products-image">
    </div>

</section>
 <!-- CARRUSEL SOLO RESPONSIVE -->
<div class="carousel-responsive">
    <div class="carousel-container">
        <h2 class="carousel-title">Nuestros Productos</h2>
        <div class="carousel-track">
            <div class="carousel-item">
                <img src="{{ asset('recursos/card1.jpg') }}" alt="Productos Frescos">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('recursos/card2.jpg') }}" alt="Variedad de Productos">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('recursos/card3.jpg') }}" alt="Ofertas Especiales">
            </div>
        </div>
        <div class="carousel-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
</div>

<!-- ========================================= -->
<!-- JAVASCRIPT PARA EL CARRUSEL AUTOMÁTICO  -->
<!-- ========================================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselTrack = document.querySelector('.carousel-track');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const dots = document.querySelectorAll('.dot');
    
    // Verificar si los elementos del carrusel existen antes de continuar
    if (!carouselTrack || carouselItems.length === 0 || dots.length === 0) {
        return;
    }

    let currentSlide = 0;
    let slideInterval;
    const intervalTime = 4000; // 4 segundos

    // Función para ir a una diapositiva específica
    function goToSlide(slideIndex) {
        // Asegurarse de que slideIndex esté dentro de los límites
        if (slideIndex >= carouselItems.length) {
            currentSlide = 0;
        } else if (slideIndex < 0) {
            currentSlide = carouselItems.length - 1;
        } else {
            currentSlide = slideIndex;
        }

        // Desplazarse suavemente al elemento activo
        carouselItems[currentSlide].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });

        // Actualizar el punto activo
        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentSlide].classList.add('active');
    }

    // Función para la siguiente diapositiva
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    // Función para iniciar el desplazamiento automático
    function startSlideShow() {
        // Limpiar cualquier intervalo existente
        if (slideInterval) {
            clearInterval(slideInterval);
        }
        // Establecer un nuevo intervalo
        slideInterval = setInterval(nextSlide, intervalTime);
    }

    // Función para detener el desplazamiento automático
    function stopSlideShow() {
        clearInterval(slideInterval);
    }

    // Añadir listeners de clic a los puntos
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            // Reiniciar la presentación después de la interacción del usuario
            startSlideShow();
        });
    });

    // Manejar la visibilidad según el tamaño de la pantalla
    function handleCarouselVisibility() {
        const isSmallScreen = window.matchMedia('(max-width: 968px)').matches;

        if (isSmallScreen) {
            // Iniciar la presentación si es una pantalla pequeña
            startSlideShow();
        } else {
            // Detener la presentación si es una pantalla grande
            stopSlideShow();
        }
    }
    
    // Verificación inicial
    handleCarouselVisibility();

    // Escuchar eventos de cambio de tamaño de ventana
    window.addEventListener('resize', handleCarouselVisibility);

    // Opcional: Pausar al pasar el mouse
    const carouselContainer = document.querySelector('.carousel-container');
    if (carouselContainer) {
        carouselContainer.addEventListener('mouseenter', stopSlideShow);
        carouselContainer.addEventListener('mouseleave', startSlideShow);
    }
});
</script>

</body>
</html>