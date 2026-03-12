<?php
session_start();
// Redirige si no existe una sesión activa
if (!isset($_SESSION["usuario"])) {
        header("Location: ../login2.php");
        exit();
}

// Conexión a la base de datos
include("../lib/conexion.php");

// Consultar el usuario a visualizar
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        header('Location: index.php?error=usuario_no_encontrado');
        exit();
    }
} else {
    header('Location: index.php?error=id_no_proporcionado');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Usuario</title>
    <style>
        :root {
            --primary-color: #667eea;
            --primary-hover: #5a6fd6;
            --bg-gradient-1: #667eea;
            --bg-gradient-2: #764ba2;
            --text-main: #2d3748;
            --text-muted: #718096;
            --input-bg: #f7fafc;
            --input-border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            max-width: 480px;
            width: 100%;
            padding: 40px;
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

        .info-group {
            margin-bottom: 22px;
        }

        .info-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-value {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 16px;
            color: var(--text-main);
            font-weight: 500;
        }

        .badge-admin {
            display: inline-block;
            padding: 6px 12px;
            background-color: #ebf4ff;
            color: #3182ce;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-user {
            display: inline-block;
            padding: 6px 12px;
            background-color: #edf2f7;
            color: #4a5568;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 35px;
        }

        button {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalles del Usuario</h1>
            <p>Información registrada en el sistema</p>
        </div>
        
        <div class="info-group">
            <span class="info-label">ID de Usuario</span>
            <div class="data-value"><?php echo htmlspecialchars($usuario['id']); ?></div>
        </div>

        <div class="info-group">
            <span class="info-label">Nombre Completo</span>
            <div class="data-value"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
        </div>
        
        <div class="info-group">
            <span class="info-label">Correo Electrónico</span>
            <div class="data-value"><?php echo htmlspecialchars($usuario['correo']); ?></div>
        </div>
        
        <div class="info-group">
            <span class="info-label">Rol en el sistema</span>
            <div style="margin-top: 8px;">
                <?php if ($usuario['es_admin'] == 1): ?>
                    <span class="badge-admin">Administrador</span>
                <?php else: ?>
                    <span class="badge-user">Usuario</span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="button" class="btn-primary" onclick="window.location.href='index.php'">Volver a la lista</button>
        </div>
    </div>
</body>
</html>