<?php


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Meximotix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* HEADER */
        header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            border-bottom: 4px solid #ff6b35;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ff6b35;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .page-title {
            font-size: 20px;
            color: #e8e8e8;
            border-left: 3px solid #ffd60a;
            padding-left: 15px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
            font-size: 14px;
        }

        /* CONTENEDOR PRINCIPAL */
        .container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* SIDEBAR */
        aside {
            width: 280px;
            background: linear-gradient(180deg, #2d2d2d 0%, #1a1a1a 100%);
            padding: 30px 0;
            overflow-y: auto;
            border-right: 4px solid #ff6b35;
            box-shadow: 4px 0 8px rgba(0,0,0,0.2);
        }

        .menu-section {
            margin-bottom: 30px;
        }

        .menu-title {
            color: #ffd60a;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 0 20px 15px;
            letter-spacing: 1px;
            border-bottom: 2px solid #ff6b35;
            margin: 0 15px 15px;
        }

        .menu-item {
            padding: 12px 25px;
            color: #d0d0d0;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 4px solid transparent;
            margin: 5px 0;
        }

        .menu-item:hover {
            background: rgba(255, 107, 53, 0.2);
            color: #ff6b35;
            border-left-color: #ff6b35;
            padding-left: 35px;
        }

        .menu-item.active {
            background: rgba(255, 107, 53, 0.3);
            color: #ffd60a;
            border-left-color: #ffd60a;
        }

        /* CONTENIDO CENTRAL */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-area {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f5f5f5 0%, #efefef 100%);
        }

        .welcome-section {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            border-left: 6px solid #ff6b35;
            margin-bottom: 30px;
        }

        .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .welcome-header h2 {
            color: #1a1a1a;
            font-size: 32px;
        }

        .welcome-header .badge {
            background: linear-gradient(135deg, #ff6b35 0%, #ffd60a 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }

        .company-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
        }

        .info-text h3 {
            color: #ff6b35;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .info-text p {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .features {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .feature-tag {
            background: #ffd60a;
            color: #1a1a1a;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
        }

        .company-image {
            background: linear-gradient(135deg, #ff6b35 0%, #d94e1f 100%);
            border-radius: 12px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 64px;
            box-shadow: 0 8px 16px rgba(255, 107, 53, 0.3);
        }

        /* FOOTER */
        footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #d0d0d0;
            padding: 25px 40px;
            text-align: center;
            border-top: 4px solid #ff6b35;
            font-size: 13px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            display: flex;
            gap: 20px;
        }

        .footer-link {
            color: #ff6b35;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: #ffd60a;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            aside {
                width: 100%;
                border-right: none;
                border-bottom: 4px solid #ff6b35;
            }

            .company-info {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="header-left">
            <div class="logo">🏢 MEXIMOTIX</div>
            <div class="page-title">Dashboard</div>
        </div>
        <div class="header-right">
            <div class="user-info">
                <p><strong>Usuario:</strong> Admin</p>
                <p style="font-size: 12px; color: #999;">Conectado</p>
            </div>
        </div>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container">
        <!-- SIDEBAR -->
        <aside>
            <div class="menu-section">
                <div class="menu-title">Principal</div>
                <a href="#inicio" class="menu-item active">📊 Inicio</a>
                <a href="#dashboard" class="menu-item">📈 Dashboard</a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Gestión</div>
                <a href="#productos" class="menu-item">📦 Productos</a>
                <a href="#pedidos" class="menu-item">🛒 Pedidos</a>
                <a href="#clientes" class="menu-item">👥 Clientes</a>
                <a href="#inventario" class="menu-item">📋 Inventario</a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Reportes</div>
                <a href="#reportes" class="menu-item">📄 Reportes</a>
                <a href="#estadisticas" class="menu-item">📉 Estadísticas</a>
                <a href="#analisis" class="menu-item">🔍 Análisis</a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Configuración</div>
                <a href="#perfil" class="menu-item">⚙️ Configuración</a>
                <a href="#usuarios" class="menu-item">👤 Usuarios</a>
                <a href="#salir" class="menu-item">🚪 Cerrar Sesión</a>
            </div>
        </aside>

        <!-- CONTENIDO CENTRAL -->
        <div class="content">
            <div class="main-area">
                <div class="welcome-section">
                    <div class="welcome-header">
                        <h2>Bienvenido a Meximotix</h2>
                        <span class="badge">VERSIÓN PRO</span>
                    </div>

                    <div class="company-info">
                        <div class="info-text">
                            <h3>Sobre Meximotix</h3>
                            <p>
                                Somos una empresa líder en soluciones tecnológicas y servicios automotrices, 
                                comprometida con la excelencia y la innovación.
                            </p>
                            <p>
                                Nuestro equipo profesional está dedicado a brindar las mejores soluciones 
                                para tu negocio, con tecnología de punta y atención al cliente sin igual.
                            </p>
                            <div class="features">
                                <span class="feature-tag">✓ Innovación</span>
                                <span class="feature-tag">✓ Calidad</span>
                                <span class="feature-tag">✓ Confiabilidad</span>
                                <span class="feature-tag">✓ Soporte 24/7</span>
                            </div>
                        </div>
                        <div class="company-image">
                            🚗
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div class="footer-left">
                <p>&copy; 2024 <strong>Meximotix</strong> | Todos los derechos reservados</p>
                <p style="font-size: 11px; margin-top: 5px;">Soluciones Tecnológicas y Automotrices</p>
            </div>
            <div class="footer-right">
                <a href="#" class="footer-link">Privacidad</a>
                <a href="#" class="footer-link">Términos de Servicio</a>
                <a href="#" class="footer-link">Contacto</a>
            </div>
        </div>
    </footer>
</body>
</html>