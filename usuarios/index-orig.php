<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login2.php");
    exit();


}
include("../lib/conexion.php");

$resultado = $conexion->query('SELECT * FROM usuarios ORDER BY id ASC');
$usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        .btn-nuevo {
            background: #10b981;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-nuevo:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .content {
            padding: 30px;
        }

        /* PREMIUM TABLE STYLES */
        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            background: white;
            margin-top: 20px;
            border: 1px solid #f0f0f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            color: #333;
        }

        thead {
            background: linear-gradient(135deg, #f8f9fa 0%, #eef2f5 100%);
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 700;
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            color: #4b5563;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr {
            transition: all 0.25s ease;
            background-color: white;
        }

        tbody tr:hover {
            background-color: #f8fafc;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transform: translateY(-2px);
            z-index: 10;
            position: relative;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .estado {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .estado.activo {
            background: #d1fae5;
            color: #065f46;
        }

        .estado.inactivo {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .acciones {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-accion {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .btn-ver {
            background: #eff6ff;
            color: #3b82f6;
            border: 1px solid #bfdbfe;
        }

        .btn-ver:hover {
            background: #3b82f6;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-editar {
            background: #fefce8;
            color: #eab308;
            border: 1px solid #fef08a;
        }

        .btn-editar:hover {
            background: #eab308;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(234, 179, 8, 0.3);
        }

        .btn-eliminar {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .btn-eliminar:hover {
            background: #ef4444;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3);
        }
        
        /* ROLE BADGES */
        .rol-badge {
            display: inline-flex;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .rol-admin {
            background-color: #fefce8;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .rol-usuario {
            background-color: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }

        .sin-datos {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
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
        }
        .sin-datos svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .filtros {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .filtros input,
        .filtros select {
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .filtros input:focus,
        .filtros select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
            <h1>👥 Gestión de Usuarios</h1>
            <a href="../usuarios/nuevo.php" class="btn-nuevo">+ Nuevo Usuario</a>
        </div>
        
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
            <div class="filtros">
                <input type="text" id="filtroNombre" placeholder="Buscar por nombre...">
                <input type="text" id="filtroEmail" placeholder="Buscar por email...">
                <select id="filtroEstado">
                    <option value="">Todos los estados</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>

            <div class="table-responsive">
                <?php if (count($usuarios) > 0): ?>
                    <table id="tablaUsuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><span style="color: #9ca3af; font-weight: 600;">#<?php echo htmlspecialchars($usuario['id']); ?></span></td>
                                    <td style="font-weight: 600; color: #111827;"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td style="color: #6b7280;"><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                    <td>
                                        <span class="rol-badge <?php echo $usuario['es_admin'] ? 'rol-admin' : 'rol-usuario'; ?>">
                                            <?php echo $usuario['es_admin'] ? 'Admin' : 'Usuario'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="acciones">
                                        <a href="ver.php?id=<?php echo $usuario['id']; ?>" class="btn-accion btn-ver">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="btn-accion btn-editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form method="POST" action="eliminar.php" style="display: inline;" onsubmit="return confirm('¿Eliminar este usuario?');">                                           
                                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
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
                        <h3>No hay usuarios registrados</h3>
                        <p>Comienza creando un nuevo usuario</p>
                    </div>
                <?php
endif; ?>
            </div>
        </div>
    </div>

    <script>
        function eliminarUsuario(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                fetch(`/api/usuarios/eliminar.php?id=${id}`, { method: 'DELETE' })
                    .then(() => location.reload())
                    .catch(err => alert('Error al eliminar'));
            }
        }

        // Filtros en tiempo real
        document.getElementById('filtroNombre').addEventListener('keyup', filtrar);
        document.getElementById('filtroEmail').addEventListener('keyup', filtrar);
        document.getElementById('filtroEstado').addEventListener('change', filtrar);

        
        function filtrar() {
            const nombre = document.getElementById('filtroNombre').value.toLowerCase();
            const email = document.getElementById('filtroEmail').value.toLowerCase();
            const estado = document.getElementById('filtroEstado').value.toLowerCase();
            const filas = document.querySelectorAll('#tablaUsuarios tbody tr');

            filas.forEach(fila => {
                const coincide = 
                    fila.cells[1].textContent.toLowerCase().includes(nombre) &&
                    fila.cells[2].textContent.toLowerCase().includes(email) &&
                    (estado === '' || fila.cells[4].textContent.toLowerCase().includes(estado));
                
                fila.style.display = coincide ? '' : 'none';
            });
        }
    </script>
</body>
</html>