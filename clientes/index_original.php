<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../loginClientes.php");
    exit();
}
include("../lib/conexion.php");

// Consultar los clientes
$resultado = $conexion->query('SELECT * FROM clientes');
$clientes = [];
if ($resultado) {
    $clientes = $resultado->fetch_all(MYSQLI_ASSOC);
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Meximotix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #efefef 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-left: 6px solid #ff6b35; /* Acorde al dashboard */
        }

        .header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #ff6b35;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #ff6b35; /* Elementos naranjas */
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .header h1 i {
            color: #ffd60a; /* Elementos dorados */
        }

        .btn-nuevo {
            background: linear-gradient(135deg, #ff6b35 0%, #ffd60a 100%);
            color: #1a1a1a;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .btn-nuevo:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 107, 53, 0.4);
            color: #000;
        }

        .content {
            padding: 30px;
            background: #ffffff;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2d2d2d;
            color: #e8e8e8;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #ff6b35;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            font-size: 14px;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: rgba(255, 107, 53, 0.05); /* Efecto hover tenue del color de marca */
        }

        .acciones {
            display: flex;
            gap: 8px;
        }

        .btn-accion {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Botón Ver: Estilo oscuro/dorado */
        .btn-ver {
            background: #1a1a1a;
            color: #ffd60a;
            border: 1px solid #2d2d2d;
        }

        .btn-ver:hover {
            background: #2d2d2d;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        /* Botón Editar: Estilo Naranja */
        .btn-editar {
            background: #ff6b35;
            color: #fff;
        }

        .btn-editar:hover {
            background: #d94e1f;
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
        }

        /* Botón Eliminar: Estilo Rojo para peligro */
        .btn-eliminar {
            background: #dc2626;
            color: #fff;
        }

        .btn-eliminar:hover {
            background: #b91c1c;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .sin-datos {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .mensaje-exito {
            background-color: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #10b981;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .acciones {
                flex-direction: column;
            }

            .btn-accion {
                width: 100%;
                justify-content: center;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 12px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Icono opcional y título con diseño inspirado en Dashboard -->
            <h1><i class="fas fa-users"></i> Gestión de Clientes</h1>
            <a href="nuevo.php" class="btn-nuevo">+ Nuevo Cliente</a>
        </div>
        
        <?php if (isset($_GET["mensaje"])): ?>
            <div class="mensaje-exito">
                <?php echo htmlspecialchars($_GET["mensaje"]); ?>
            </div>
        <?php
endif; ?>

        <?php if (isset($_SESSION["mensaje"])): ?>
            <div class="mensaje-exito">
                <?php
    echo $_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
?>
            </div>
        <?php
endif; ?>

        <div class="content">
            <div class="table-responsive">
                <?php if (count($clientes) > 0): ?>
                    <table id="tablaClientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Domicilio</th>
                                <th>Giro</th>
                                <th>Razón Social</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente):
        // Extraer el ID seguro (asumiendo posibles nombres de columna)
        $id_key = 'id';
        if (isset($cliente['Id']))
            $id_key = 'Id';
        if (isset($cliente['ID']))
            $id_key = 'ID';
        if (isset($cliente['id_cliente']))
            $id_key = 'id_cliente';
        if (isset($cliente['IdCliente']))
            $id_key = 'IdCliente';
        $id_val = isset($cliente[$id_key]) ? $cliente[$id_key] : '';
?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($id_val); ?></strong></td>
                                    <td><?php echo isset($cliente['Nombre']) ? htmlspecialchars($cliente['Nombre']) : ''; ?></td>
                                    <td><?php echo isset($cliente['Domicilio']) ? htmlspecialchars($cliente['Domicilio']) : ''; ?></td>
                                    <td><span style="background: rgba(255, 214, 10, 0.2); padding: 4px 8px; border-radius: 4px; font-size: 12px; color: #1a1a1a; font-weight: bold;"><?php echo isset($cliente['Giro']) ? htmlspecialchars($cliente['Giro']) : ''; ?></span></td>
                                    <td><?php echo isset($cliente['RazonSocial']) ? htmlspecialchars($cliente['RazonSocial']) : ''; ?></td>
                                    <td>
                                        <div class="acciones">
                                            <a href="ver.php?id=<?php echo urlencode($id_val); ?>" class="btn-accion btn-ver">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <a href="editar.php?id=<?php echo urlencode($id_val); ?>" class="btn-accion btn-editar">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form method="POST" action="eliminar.php" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">                                           
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_val); ?>">
                                                <button type="submit" class="btn-accion btn-eliminar">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php
    endforeach; ?>
                        </tbody>
                    </table>
                <?php
else: ?>
                    <div class="sin-datos">
                        <h3>No hay clientes registrados</h3>
                        <p>Haz clic en "+ Nuevo Cliente" para comenzar</p>
                    </div>
                <?php
endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
