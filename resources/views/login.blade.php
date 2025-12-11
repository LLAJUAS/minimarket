<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #098644 0%, #0ab352 100%);
            display: flex;
            justify-content: space-between; /* Cambiado para distribuir los elementos */
            align-items: center;
            min-height: 100vh;
            
            overflow: hidden; /* Evita que las imágenes laterales generen scroll */
        }

        /* Estilos para las imágenes laterales */
        .side-image {
            height: 100vh;
            width: auto;
            object-fit: cover;
            opacity: 0.8; /* Hacemos las imágenes semi-transparentes */
            user-select: none; /* Evita que se puedan seleccionar */
            transition: opacity 0.3s ease;
        }

        .side-image:hover {
            opacity: 0.7;
        }
        
        /* Ocultar las imágenes en pantallas pequeñas para no recargar el diseño */
        @media (max-width: 1200px) {
            .side-image {
                display: none;
            }
            /* En pantallas pequeñas, volvemos a centrar el login */
            body {
                justify-content: center;
            }
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 420px;
            position: relative;
            animation: fadeIn 0.5s ease;
            /* Añadido para asegurar que no se vea afectado por el space-between en pantallas grandes */
            flex-shrink: 0; 
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: #fff;
            font-size: 20px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
            margin-top: 20px;
        }

        .logo {
            width: 180px;
            height: auto;
            margin: 0 auto 20px;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .login-header h1 {
            color: #fff;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-top: 5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: #fff;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group input:focus {
            border-color: rgba(255, 255, 255, 0.6);
            outline: none;
            background-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: rgba(255, 255, 255, 0.9);
            color: #098644;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 1);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 10px;
            color: #fff;
            background-color: rgba(220, 53, 69, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .alert li {
            padding: 5px 0;
            font-size: 14px;
        }

        .alert li:before {
            content: "⚠ ";
            margin-right: 5px;
        }

        @media (max-width: 480px) {
            body{
                padding: 20px;
            }
            .login-container {
                padding: 30px 25px;
            }

            .login-header h1 {
                font-size: 28px;
            }

            .logo {
                width: 150px;
                height: auto;
            }
        }
    </style>
</head>
<body>

<!-- Imagen Izquierda -->
<img src="{{ asset('recursos/izquierda.png') }}" alt="Imagen decorativa izquierda" class="side-image">

<div class="login-container">
    <a href="javascript:history.back()" class="back-button" title="Volver">
        ←
    </a>

    <div class="login-header">
        <img src="{{ asset('recursos/logo.png') }}" alt="Logo Don Javier" class="logo">
       
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="login">Usuario o Correo Electrónico</label>
            <div class="input-wrapper">
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autocomplete="username" autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>
        </div>

        <button type="submit" class="login-button">
            Iniciar Sesión
        </button>
    </form>
</div>

<!-- Imagen Derecha -->
<img src="{{ asset('recursos/derecha.png') }}" alt="Imagen decorativa derecha" class="side-image">

</body>
</html>