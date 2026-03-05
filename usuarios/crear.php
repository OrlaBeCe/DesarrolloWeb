<?php
session_start();

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("../lib/conexion.php");
    // Validar y procesar los datos
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $es_admin = isset($_POST['es_admin']) ? 1 : 0;
    
    $errores = [];
    
    if (empty($nombre)) $errores[] = 'El nombre es requerido';
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email inválido';
    if (empty($password) || strlen($password) < 8) $errores[] = 'La contraseña debe tener mínimo 8 caracteres';
    if ($password !== $password_confirm) $errores[] = 'Las contraseñas no coinciden';
    
    if (empty($errores)) {
        //insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password, es_admin) VALUES (?, ?, ?, ?)");
        $password_hash = md5($password);
        $stmt->bind_param("sssi", $nombre, $correo, $password_hash, $es_admin);
        if ($stmt->execute()) {
            $_SESSION['exito'] = 'Usuario registrado correctamente';
        } else {
            $_SESSION['error'] = 'Error al registrar el usuario';
        }
        $stmt->close();
    }

    //redireccionar a la pagina con el mensaje de exito o error
    header("Location: nuevo.php");
    exit(); // Asegurar que no se ejecuten más líneas después de la redirección
}
?>