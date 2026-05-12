<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login2.php");
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

        /* ROLE BADGES */
        .rol-badge {
            display: inline-flex;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

        .content {
            padding: 30px;
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

        .header2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .header2 h1 {
            font-size: 26px;
            color: var(--text-main);
            font-weight: 700;
        }

        .header2 p {
            color: var(--text-muted);
            font-size: 15px;
            margin-top: 5px;
        }

        .btn-nuevo {
            background: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.2);
        }

        .btn-nuevo:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
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

        /* tr hover moved to premium table styles block */

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
            padding: 20px;
            overflow-y: auto;
            background: #fdfdfd;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .card {
            background: white;
            width: 100%;
            min-height: 100%;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-top: 6px solid var(--primary-color);
        }

        .welcome-section {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
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

        /* .acciones movido arriba con los botones */

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


        .help-text {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 6px;
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
        }

        @media (max-width: 768px) {
            .header2 {
                flex-direction: column;
                gap: 15px;
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
                <div class="header2">
                    <div>
                        <h1><i class="fas fa-box" style="color: var(--primary-color); margin-right: 10px;"></i>
                            Gestión de Productos</h1>
                        <p>Administra el inventario de productos del sistema</p>
                    </div>
                    <button onclick="abrirModal('crear')" class="btn-nuevo"><i class="fas fa-plus"></i> Nuevo Producto</button>
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

                <div class="filtros">
                    <input type="text" id="filtroCodigo" placeholder="Buscar por código...">
                    <input type="text" id="filtroDescripcion" placeholder="Buscar por descripción...">
                </div>

                <div class="table-responsive">
                    <table id="tablaProductos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <!-- Filas dinámicas generadas por JS -->
                        </tbody>
                    </table>
                    <div id="no-datos" class="sin-datos" style="display: none;">
                        <h3>No hay productos registrados</h3>
                        <p>Comienza creando un nuevo producto</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-overlay" id="productoModal">
        <div class="modal-box">
            <h2 id="modalTitle">Nuevo Producto</h2>
            <form id="productoForm">
                <input type="hidden" id="productoId">
                <div class="form-group">
                    <label>Código:</label>
                    <input type="text" id="codigo" required>
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <input type="text" id="descripcion" required>
                </div>
                <div class="form-group">
                    <label>Cantidad:</label>
                    <input type="number" id="cantidad" step="any" required>
                </div>
                <div class="form-group">
                    <label>Precio:</label>
                    <input type="number" id="precio" step="0.01" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", cargarProductos);

        function cargarProductos() {
            fetch('api.php')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('tabla-body');
                    const tabla = document.getElementById('tablaProductos');
                    const noDatos = document.getElementById('no-datos');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tabla.style.display = 'none';
                        noDatos.style.display = 'block';
                    } else {
                        tabla.style.display = 'table';
                        noDatos.style.display = 'none';
                        data.forEach(p => {
                            const id = p.Id || p.ID || p.id;
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td><span style="color: #9ca3af; font-weight: 600;">#${id}</span></td>
                                <td style="font-weight: 600; color: #111827;">${p.Codigo || ''}</td>
                                <td style="color: #6b7280;">${p.Descripcion || ''}</td>
                                <td style="color: #6b7280;">${p.Cantidad || ''}</td>
                                <td style="font-weight: 600; color: #10b981;">$${parseFloat(p.Precio).toFixed(2) || '0.00'}</td>
                                <td>
                                    <div class="acciones">
                                        <button onclick="verProducto(${id})" class="btn-accion btn-ver" title="Ver detalle">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button onclick="abrirModal('editar', ${id})" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button onclick="eliminarProducto(${id})" class="btn-accion btn-eliminar" title="Eliminar">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                        filtrar();
                    }
                })
                .catch(err => console.error("Error cargando productos:", err));
        }

        function abrirModal(modo, id = null) {
            document.getElementById('productoModal').classList.add('active');
            const form = document.getElementById('productoForm');
            form.reset();

            const inputs = form.querySelectorAll('input:not([type="hidden"])');
            const btnGuardar = form.querySelector('.btn-guardar');

            if (modo === 'ver') {
                document.getElementById('modalTitle').innerText = 'Detalles del Producto';
                btnGuardar.style.display = 'none';
                inputs.forEach(input => input.disabled = true);
                
                fetch(`api.php?id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('productoId').value = data.Id || data.ID || data.id;
                        document.getElementById('codigo').value = data.Codigo || '';
                        document.getElementById('descripcion').value = data.Descripcion || '';
                        document.getElementById('cantidad').value = data.Cantidad || '';
                        document.getElementById('precio').value = data.Precio || '';
                    });
            } else if (modo === 'editar') {
                document.getElementById('modalTitle').innerText = 'Editar Producto';
                btnGuardar.style.display = 'block';
                inputs.forEach(input => input.disabled = false);

                fetch(`api.php?id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('productoId').value = data.Id || data.ID || data.id;
                        document.getElementById('codigo').value = data.Codigo || '';
                        document.getElementById('descripcion').value = data.Descripcion || '';
                        document.getElementById('cantidad').value = data.Cantidad || '';
                        document.getElementById('precio').value = data.Precio || '';
                    });
            } else {
                document.getElementById('modalTitle').innerText = 'Nuevo Producto';
                document.getElementById('productoId').value = '';
                btnGuardar.style.display = 'block';
                inputs.forEach(input => input.disabled = false);
            }
        }

        function cerrarModal() {
            document.getElementById('productoModal').classList.remove('active');
        }

        document.getElementById('productoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('productoId').value;
            const data = {
                codigo: document.getElementById('codigo').value,
                descripcion: document.getElementById('descripcion').value,
                cantidad: document.getElementById('cantidad').value,
                precio: document.getElementById('precio').value
            };

            if (id) {
                data.id = id;
                fetch('api.php', {
                    method: 'PUT',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                }).then(() => {
                    cerrarModal();
                    cargarProductos();
                });
            } else {
                fetch('api.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                }).then(() => {
                    cerrarModal();
                    cargarProductos();
                });
            }
        });

        function eliminarProducto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                fetch('api.php', {
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({id: id})
                }).then(() => cargarProductos());
            }
        }

        function verProducto(id) {
            abrirModal('ver', id);
        }

        // Filtros en tiempo real
        document.getElementById('filtroCodigo').addEventListener('keyup', filtrar);
        document.getElementById('filtroDescripcion').addEventListener('keyup', filtrar);

        function filtrar() {
            const codigo = document.getElementById('filtroCodigo').value.toLowerCase();
            const descripcion = document.getElementById('filtroDescripcion').value.toLowerCase();
            const filas = document.querySelectorAll('#tablaProductos tbody tr');

            filas.forEach(fila => {
                if (fila.cells.length > 2) {
                    const coincide =
                        fila.cells[1].textContent.toLowerCase().includes(codigo) &&
                        fila.cells[2].textContent.toLowerCase().includes(descripcion);

                    fila.style.display = coincide ? '' : 'none';
                }
            });
        }
    </script>
    <!-- FOOTER -->
    <?php include '../templates/footer.php'; ?>
</body>

</html>