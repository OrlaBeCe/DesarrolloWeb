<?php
session_start();
// Redirige si no existe una sesión activa
if (!isset($_SESSION["usuario"])) {
    header("Location: ../loginClientes.php");
    exit();
}

// Conexión a la base de datos
include("../lib/conexion.php");

//consultar el usuario a editar
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    }
    else {
        header('Location: index.php?error=cliente_no_encontrado');
        exit();
    }
}
else {
    header('Location: index.php?error=id_no_proporcionado');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Cliente</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #36373aff 10%, #4c3663ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        h1 {
            color: #ff6b35;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f5f3ff;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #667eea;
        }
        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
        }
        .errores {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .errores ul {
            margin-left: 20px;
            margin-top: 5px;
        }
        .exito {
            background: #efe;
            color: #3c3;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ff6b35 0%, #ffd60aff 100%);
            color: #1a1a1a;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Datos de cliente</h1>
     <?php if (isset($_SESSION['exito'])): ?>
            <div class="exito"><?php echo $_SESSION['exito'];
    unset($_SESSION['exito']); ?></div>
        <?php
endif; ?>
        
        <?php if (!empty($errores)): ?>
            <div class="errores">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php
    endforeach; ?>
                </ul>
            </div>
        <?php
endif; ?>
    <div class="datos-cliente"> 
        <div class="form-group">
            <label for="nombre" >Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente['Nombre']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="domicilio">Domicilio:</label>
            <input type="text" id="domicilio" name="domicilio" value="<?php echo htmlspecialchars($cliente['Domicilio']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="giro">Giro:</label>
            <input type="text" id="giro" name="giro" value="<?php echo htmlspecialchars($cliente['Giro']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="razonsocial">Razon Social:</label>
            <input type="text" id="razonsocial" name="razonsocial" value="<?php echo htmlspecialchars($cliente['RazonSocial']); ?>" readonly>
        </div>
        <div class="form-buttons" style="display: flex; justify-content: center; margin-top: 20px;">
            <button type="button" class="btn-cancelar" onclick="window.location.href='index.php'">Regresar</button>
        </div>
    </div>
    <?php
if (isset($_GET['mensaje'])) {
    echo "<p>" . htmlspecialchars($_GET['mensaje']) . "<p>";
}
?>
</div>
</body>
</html>