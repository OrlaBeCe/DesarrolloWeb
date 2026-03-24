<?php


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Meximotix</title>
    <style>
        :root {
            --primary-color: #ff6b35;
            --primary-hover: #e55a2b;
            --text-main: #1a1a1a;
            --text-muted: #666666;
            --input-bg: #f8f9fa;
            --input-border: #e2e8f0;
        }

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
.form-group {
            margin-bottom: 22px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--input-bg);
            border: 2px solid var(--input-border);
            border-radius: 8px;
            font-size: 15px;
            color: var(--text-main);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input::placeholder {
            color: #a0aec0;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary-color);
            border-radius: 4px;
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
            padding: 40px;
            overflow-y: auto;
            background: #fdfdfd;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .card {
            background: white;
            width: 100%;
            
            padding: 50px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 6px solid var(--primary-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .header {
            margin-bottom: 35px;
            text-align: center;
        }

        .header-icon {
            background: #edf2f7;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            color: var(--primary-color);
        }

        .header h1 {
            font-size: 26px;
            color: var(--text-main);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .header p {
            color: var(--text-muted);
            font-size: 15px;
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 35px;
        }

        .form-buttons button {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .btn-guardar {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-guardar:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-cancelar {
            background-color: #edf2f7;
            color: #4a5568;
        }

        .btn-cancelar:hover {
            background-color: #e2e8f0;
            transform: translateY(-2px);
        }

        .mensaje-error {
            background: #fff5f5;
            color: #c53030;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #f56565;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
        }
label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
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
   <?php include '../templates/header.php'; ?>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container">
        <!-- SIDEBAR -->
        
        <?php include '../templates/sidebar.php'; ?>
        <!-- CONTENIDO CENTRAL -->
        <div class="content">
            <div class="card">
                <div class="header">
                    <div class="header-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h1>Registro de clientes</h1>
                    <p>Información del cliente</p>
                </div>
                        
    <?php if (isset($_SESSION['exito'])): ?>
                    <div class="exito" style="background: #f0fff4; color: #2f855a; padding: 12px; border-radius: 8px; border-left: 4px solid #48bb78; margin-bottom: 25px; text-align: center; font-weight: bold;">
                        <?php echo $_SESSION['exito'];
    unset($_SESSION['exito']); ?>
                    </div>
                <?php
endif; ?>
                
                <?php if (!empty($errores)): ?>
                    <div class="mensaje-error" style="background: #fff5f5; color: #c53030; padding: 12px; border-radius: 8px; border-left: 4px solid #f56565; margin-bottom: 25px; text-align: center; font-weight: bold;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php
    endforeach; ?>
                        </ul>
                    </div>
                <?php
endif; ?>

                <?php if (isset($_GET['mensaje'])): ?>
                    <div class="mensaje-error" style="background: #fff5f5; color: #c53030; padding: 12px; border-radius: 8px; border-left: 4px solid #f56565; margin-bottom: 25px; text-align: center; font-weight: bold;">
                        <?php echo htmlspecialchars($_GET['mensaje']); ?>
                    </div>
                <?php
endif; ?>

    <form action="guardar.php" method="POST"> 
        <div class="info-grid">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre" required>
            </div>
            <div class="form-group">
                <label for="domicilio">Domicilio</label>
                <input type="text" name="domicilio" id="domicilio" placeholder="Ingrese el domicilio" required>
            </div>
            <div class="form-group">
                <label for="giro">Giro</label>
                <input type="text" name="giro" id="giro" placeholder="Ingrese el giro" required>
            </div>
            <div class="form-group">
                <label for="razonsocial">Razón Social</label>
                <input type="text" name="razonsocial" id="razonsocial" placeholder="Ingrese la razón social" required>
            </div>
        </div>
        
        <div class="form-buttons">
            <button type="button" class="btn-cancelar" onclick="window.location.href='index.php'">
                Cancelar
            </button>
            <button type="submit" class="btn-guardar">
                Crear Cliente
            </button>
        </div>
    </form>
</div>
</div>
    </div>

    <!-- FOOTER -->
    <?php include '../templates/footer.php'; ?>
</body>
</html>