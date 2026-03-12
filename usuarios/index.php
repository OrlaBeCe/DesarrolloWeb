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

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
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
            background-color: #f9fafb;
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

        .btn-ver {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-ver:hover {
            background: #bfdbfe;
        }

        .btn-editar {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-editar:hover {
            background: #fde68a;
        }

        .btn-eliminar {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-eliminar:hover {
            background: #fecaca;
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
        <?php endif; ?>

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
                                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                    <td><?php echo $usuario['es_admin'] ? 'Admin' : 'Usuario'; ?></td>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="sin-datos">
                        <h3>No hay usuarios registrados</h3>
                        <p>Comienza creando un nuevo usuario</p>
                    </div>
                <?php endif; ?>
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