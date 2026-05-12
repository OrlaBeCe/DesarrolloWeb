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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
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
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.2);
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-top: 6px solid #ff6b35;
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
            color: #ff6b35;
        }

        .header h1 {
            font-size: 26px;
            color: #1a1a1a;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .header p {
            color: #666666;
            font-size: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #666666;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 14px 16px;
            background-color: #f8f9fa;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            color: #1a1a1a;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #ff6b35;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            grid-column: 1 / -1;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #ff6b35;
            border-radius: 4px;
        }

        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
            text-transform: none;
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
            background-color: #ff6b35;
            color: white;
        }

        .btn-guardar:hover {
            background-color: #e55a2b;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
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

        .exito {
            background: #f0fff4;
            color: #2f855a;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #48bb78;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
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
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h1>Registro de Productos</h1>
                    <p>Información del nuevo producto para el inventario</p>
                </div>

                <?php if (isset($_SESSION['exito'])): ?>
                    <div class="exito">
                        <?php echo $_SESSION['exito'];
                        unset($_SESSION['exito']); ?>
                    </div>
                    <?php
                endif; ?>

                <?php if (!empty($errores)): ?>
                    <div class="mensaje-error">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <?php foreach ($errores as $error): ?>
                                <li>
                                    <?php echo htmlspecialchars($error); ?>
                                </li>
                                <?php
                            endforeach; ?>
                        </ul>
                    </div>
                    <?php
                endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="mensaje-error">
                        <?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                    <?php
                endif; ?>

                <form method="POST" action="crear.php">
                    <div class="info-grid">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Ingrese el código del producto"
                                required value="<?php echo htmlspecialchars($_POST['codigo'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" placeholder="Ingrese la descripción"
                                required value="<?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad en stock"
                                required value="<?php echo htmlspecialchars($_POST['cantidad'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" id="precio" name="precio"
                                placeholder="Precio unitario" required value="<?php echo htmlspecialchars($_POST['precio'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="btn-cancelar" onclick="window.location.href='index.php'">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-guardar">
                            Crear Producto
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