<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../loginClientes.php");
    exit();
}
include("../lib/conexion.php");

// Módulo B: Todo se maneja por Fetch API
$conexion->close();

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
.table-responsive {
            overflow-x: auto;
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
            border-top: 6px solid #ff6b35;
        }

        .header {
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 25px;
        }

        .header-icon {
            background: #edf2f7;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff6b35;
        }

        .header-text h1 {
            font-size: 24px;
            color: #1a1a1a;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .header-text p {
            color: #666666;
            font-size: 14px;
            margin: 0;
        }

        /* Estilos Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f8f9fa;
            color: #666666;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 16px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #1a1a1a;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover td {
            background-color: #f8f9fa;
        }

        /* Botones Acción */
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
            background: #edf2f7;
            color: #4a5568;
        }
        .btn-ver:hover {
            background: #e2e8f0;
        }

        .btn-editar {
            background: #ebf8ff;
            color: #3182ce;
        }
        .btn-editar:hover {
            background: #bee3f8;
        }

        .btn-eliminar {
            background: #fff5f5;
            color: #c53030;
        }
        .btn-eliminar:hover {
            background: #fed7d7;
        }

        .sin-datos {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .mensaje-exito {
            background: #f0fff4;
            color: #2f855a;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #48bb78;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
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
        /* MODAL STYLES */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .modal-box h2 { margin-bottom: 20px; color: #1a1a1a; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #666; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancelar { background: #e2e8f0; color: #4a5568; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; }
        .btn-guardar { background: #ff6b35; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; }
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
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div class="header-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="header-text">
                            <h1>Gestión de Clientes</h1>
                            <p>Lista general de clientes registrados en el sistema</p>
                        </div>
                    </div>
                    <button onclick="abrirModal('crear')" class="btn-nuevo">+ Nuevo Cliente</button>
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

                <div class="table-responsive">
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
                        <tbody id="tabla-body">
                            <!-- Filas generadas por JS -->
                        </tbody>
                    </table>
                    <div id="no-datos" class="sin-datos" style="display: none;">
                        <div style="font-size: 48px; color: #cbd5e0; margin-bottom: 20px;">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="19" y1="8" x2="19" y2="14"></line>
                                <line x1="22" y1="11" x2="16" y2="11"></line>
                            </svg>
                        </div>
                        <h3>No hay clientes registrados</h3>
                        <p style="margin-top: 8px;">Haz clic en "Nuevo Cliente" para comenzar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER -->
    <?php include '../templates/footer.php'; ?>

    <!-- MODAL -->
    <div class="modal-overlay" id="clienteModal">
        <div class="modal-box">
            <h2 id="modalTitle">Nuevo Cliente</h2>
            <form id="clienteForm">
                <input type="hidden" id="clienteId">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" id="nombre" required>
                </div>
                <div class="form-group">
                    <label>Domicilio:</label>
                    <input type="text" id="domicilio" required>
                </div>
                <div class="form-group">
                    <label>Giro:</label>
                    <input type="text" id="giro" required>
                </div>
                <div class="form-group">
                    <label>Razón Social:</label>
                    <input type="text" id="razonSocial" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", cargarClientes);

        function cargarClientes() {
            fetch('api.php')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('tabla-body');
                    const tabla = document.getElementById('tablaClientes');
                    const noDatos = document.getElementById('no-datos');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tabla.style.display = 'none';
                        noDatos.style.display = 'block';
                    } else {
                        tabla.style.display = 'table';
                        noDatos.style.display = 'none';
                        data.forEach(c => {
                            const id = c.Id || c.ID || c.id;
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td><strong>${id}</strong></td>
                                <td>${c.Nombre || ''}</td>
                                <td>${c.Domicilio || ''}</td>
                                <td><span style="background: rgba(255, 214, 10, 0.2); padding: 4px 8px; border-radius: 4px; font-size: 12px; color: #1a1a1a; font-weight: bold; text-transform: uppercase;">${c.Giro || ''}</span></td>
                                <td>${c.RazonSocial || ''}</td>
                                <td>
                                    <div class="acciones" style="display: flex; gap: 8px;">
                                        <button onclick="verCliente(${id})" class="btn-accion btn-ver" title="Ver detalle">Ver</button>
                                        <button onclick="abrirModal('editar', ${id})" class="btn-accion btn-editar" title="Editar">Editar</button>
                                        <button onclick="eliminarCliente(${id})" class="btn-accion btn-eliminar" title="Eliminar">Eliminar</button>
                                    </div>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    }
                })
                .catch(err => console.error("Error cargando clientes:", err));
        }

        function abrirModal(modo, id = null) {
            document.getElementById('clienteModal').classList.add('active');
            const form = document.getElementById('clienteForm');
            form.reset();

            const inputs = form.querySelectorAll('input:not([type="hidden"])');
            const btnGuardar = form.querySelector('.btn-guardar');

            if (modo === 'ver') {
                document.getElementById('modalTitle').innerText = 'Detalles del Cliente';
                btnGuardar.style.display = 'none';
                inputs.forEach(input => input.disabled = true);
                
                fetch(`api.php?id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('clienteId').value = data.Id || data.ID || data.id;
                        document.getElementById('nombre').value = data.Nombre || '';
                        document.getElementById('domicilio').value = data.Domicilio || '';
                        document.getElementById('giro').value = data.Giro || '';
                        document.getElementById('razonSocial').value = data.RazonSocial || '';
                    });
            } else if (modo === 'editar') {
                document.getElementById('modalTitle').innerText = 'Editar Cliente';
                btnGuardar.style.display = 'block';
                inputs.forEach(input => input.disabled = false);

                fetch(`api.php?id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('clienteId').value = data.Id || data.ID || data.id;
                        document.getElementById('nombre').value = data.Nombre || '';
                        document.getElementById('domicilio').value = data.Domicilio || '';
                        document.getElementById('giro').value = data.Giro || '';
                        document.getElementById('razonSocial').value = data.RazonSocial || '';
                    });
            } else {
                document.getElementById('modalTitle').innerText = 'Nuevo Cliente';
                document.getElementById('clienteId').value = '';
                btnGuardar.style.display = 'block';
                inputs.forEach(input => input.disabled = false);
            }
        }

        function cerrarModal() {
            document.getElementById('clienteModal').classList.remove('active');
        }

        document.getElementById('clienteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('clienteId').value;
            const data = {
                nombre: document.getElementById('nombre').value,
                domicilio: document.getElementById('domicilio').value,
                giro: document.getElementById('giro').value,
                razon_social: document.getElementById('razonSocial').value
            };

            if (id) {
                // Editar
                data.id = id;
                fetch('api.php', {
                    method: 'PUT',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                }).then(() => {
                    cerrarModal();
                    cargarClientes();
                });
            } else {
                // Crear
                fetch('api.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                }).then(() => {
                    cerrarModal();
                    cargarClientes();
                });
            }
        });

        function eliminarCliente(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
                fetch('api.php', {
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({id: id})
                }).then(() => cargarClientes());
            }
        }

        function verCliente(id) {
            abrirModal('ver', id);
        }
    </script>
</body>
</html>