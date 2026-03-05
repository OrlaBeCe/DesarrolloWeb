<?php
session_start();
// Redirige si no existe una sesión activa
if (!isset($_SESSION["usuario"])) {
    // header("Location: login.php");
    // exit();
}

// Conexión a la base de datos
include("../lib/conexion.php");

//consultar el usuario a editar
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            flex-direction: column;
        }

        .alert-danger {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 4px solid #f56565;
        }

        .alert-success {
            background-color: #f0fff4;
            color: #276749;
            border-left: 4px solid #48bb78;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-main);
            font-weight: 600;
            font-size: 14px;
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

        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
        }

        button {
            flex: 1;
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

        .btn-secondary {
            background-color: #edf2f7;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
            transform: translateY(-2px);
        }

        .help-text {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Usuario</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="mensaje-error">
                <?php 
                    if ($_GET['error'] === 'campos_vacios') {
                        echo 'Por favor completa todos los campos.';
                    } elseif ($_GET['error'] === 'bd') {
                        echo 'Error al actualizar el usuario en la base de datos.';
                    }
                ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="procesar_editar.php">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($usuario['password']); ?>" required>
            </div>
            
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="es_admin" name="es_admin" value="1" <?php echo ($usuario['es_admin'] == 1) ? 'checked' : ''; ?>>
                    <label for="es_admin">Es Administrador</label>
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <button type="button" class="btn-cancelar" onclick="window.location.href='index.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>
</html>