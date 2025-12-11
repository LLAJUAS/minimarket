<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Don Javier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #098644;
            --secondary-color: #FF9F66;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }
        
        .header .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .main-container {
            display: flex;
            flex: 1;
        }
        
        .dashboard-container {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .welcome-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .welcome-icon {
            background-color: var(--primary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .welcome-title {
            color: var(--primary-color);
            font-size: 28px;
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 15px;
            background-color: var(--light-color);
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .user-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .user-info-item i {
            color: var(--primary-color);
        }
        
        .user-info strong {
            color: var(--secondary-color);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
        
        .stat-icon.primary {
            background-color: var(--primary-color);
        }
        
        .stat-icon.secondary {
            background-color: var(--secondary-color);
        }
        
        .stat-icon.info {
            background-color: var(--info-color);
        }
        
        .stat-icon.success {
            background-color: var(--success-color);
        }
        
        .stat-content h3 {
            font-size: 24px;
            margin-bottom: 5px;
            color: var(--dark-color);
        }
        
        .stat-content p {
            color: #777;
            font-size: 14px;
        }
        
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        
        .action-button {
            flex: 1;
            min-width: 150px;
            padding: 15px;
            border-radius: 10px;
            background: white;
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.3s;
        }
        
        .action-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: var(--light-color);
        }
        
        .action-button i {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .logout-form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        
        .logout-button {
            background-color: var(--danger-color);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
       
        
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 14px;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 15px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .welcome-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-store"></i> Mini Market Don Javier</h1>
        <div class="user-menu">
            <span>{{ $user->nombre }} {{ $user->apellido }}</span>
            <div class="user-avatar">{{ substr($user->nombre, 0, 1) }}{{ substr($user->apellido, 0, 1) }}</div>
        </div>
    </div>
    
    <div class="main-container">
        @include('componentes.sidebaradmin')
        
        <div class="dashboard-container">
            <div class="welcome-card">
                <div class="welcome-header">
                    <div class="welcome-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h1 class="welcome-title">Panel de Administración</h1>
                </div>
                
                <div class="user-info">
                    <div class="user-info-item">
                        <i class="fas fa-user"></i>
                        <span>Has iniciado sesión como: <strong>{{ $user->nombre }} {{ $user->apellido }}</strong></span>
                    </div>
                    <div class="user-info-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Tu rol de usuario es: <strong>{{ $user->roles->first()->nombre_rol }}</strong></span>
                    </div>
                </div>
                
                <p>Aquí podrás gestionar el contenido de tu Mini Market.</p>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-content">
                        <h3>248</h3>
                        <p>Productos</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon secondary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <h3>52</h3>
                        <p>Ventas hoy</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1,245</h3>
                        <p>Clientes</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <h3>$3,456</h3>
                        <p>Ingresos hoy</p>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="#" class="action-button">
                    <i class="fas fa-plus-circle"></i>
                    <span>Agregar Producto</span>
                </a>
                <a href="#" class="action-button">
                    <i class="fas fa-list-alt"></i>
                    <span>Ver Ventas</span>
                </a>
                <a href="#" class="action-button">
                    <i class="fas fa-chart-line"></i>
                    <span>Reportes</span>
                </a>
                <a href="#" class="action-button">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Mini Market Don Javier - Todos los derechos reservados</p>
    </div>
</body>
</html>