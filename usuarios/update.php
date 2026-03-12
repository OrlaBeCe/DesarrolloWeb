<?php
session_start();
//verifica que la soicitudvenga por post
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: ../index.php');
    exit();
}
//tomamos los datos por metodo post
$id = $_POST["id"];
$usuario = $_POST["nombre"];
$email = $_POST["correo"];
$contrasena = $_POST["password"];
$es_admin = isset($_POST["es_admin"]) ? 1 : 0;


//validamos que los campos no esten vacios
if (empty($usuario) || empty($email) || empty($contrasena)) {
    header('Location: editar.php?id=' . $id . '&error=campos_vacios');
    exit();
}

include '../lib/conexion.php';

if(empty($password)){
    //si la contraseña esta vacia, no la actualizamos
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, es_admin = ? WHERE id = ?");
    $stmt->bind_param("ssii", $usuario, $email, $es_admin, $id);
    if ($stmt->execute()) {
        header('Location: index.php?success=usuario_actualizado');
    } else {
        header('Location: editar.php?id=' . $id . '&error=error_actualizando');
    }
    exit();
}
else {
    //actualizamos el usuario en la base de datos con prepared statements para evitar inyeccion sql con cifrado de contraseña md5
    $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, contrasena = ?, es_admin = ? WHERE id = ?");
    $hashed_password = md5($contrasena);
    $stmt->bind_param("sssii", $usuario, $email, $hashed_password, $es_admin, $id);
    if ($stmt->execute()) {
        header('Location: index.php?success=usuario_actualizado');
    } else {
        header('Location: editar.php?id=' . $id . '&error=error_actualizando');
    }
    exit();
}

if($stmt->execute()) {
    header('Location: index.php?success=usuario_actualizado');
    exit();
} else {
    header('Location: editar.php?id=' . $id . '&error=error_actualizando');
}
?>