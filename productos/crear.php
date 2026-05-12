<?php
session_start();

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("../lib/conexion.php");
    // Validar y procesar los datos
    $codigo = trim($_POST['codigo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $cantidad = $_POST['cantidad'] ?? '';
    $precio = $_POST['precio'] ?? '';
    
    $errores = [];
    
    if (empty($codigo)) $errores[] = 'El código es requerido';
    if (empty($descripcion)) $errores[] = 'La descripción es requerida';
    if ($cantidad === '') $errores[] = 'La cantidad es requerida';
    if ($precio === '') $errores[] = 'El precio es requerido';
    
    if (empty($errores)) {
        //insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO productos (Codigo, Descripcion, Cantidad, Precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $codigo, $descripcion, $cantidad, $precio);
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = 'Producto registrado correctamente';
            $stmt->close();
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = 'Error al registrar el producto';
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = implode('<br>', $errores);
    }

    //redireccionar a la pagina con el mensaje de error
    header("Location: nuevo.php");
    exit(); // Asegurar que no se ejecuten más líneas después de la redirección
}
?>
