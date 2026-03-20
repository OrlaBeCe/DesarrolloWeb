<?php
session_start();
//verifica que la solicitud venga por post
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: ../index.php');
    exit();
}

//tomamos los datos por metodo post usando los nombres del formulario
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$domicilio = $_POST["domicilio"];
$giro = $_POST["giro"];
$razonsocial = $_POST["razonsocial"];

//validamos que los campos no esten vacios
if (empty($nombre) || empty($domicilio) || empty($giro) || empty($razonsocial)) {
    header('Location: editar.php?id=' . urlencode($id) . '&error=campos_vacios');
    exit();
}

include '../lib/conexion.php';

//actualizamos el cliente en la base de datos con prepared statements para evitar inyeccion sql
$stmt = $conexion->prepare("UPDATE clientes SET Nombre = ?, Domicilio = ?, Giro = ?, RazonSocial = ? WHERE id = ?");
$stmt->bind_param("ssssi", $nombre, $domicilio, $giro, $razonsocial, $id);

if ($stmt->execute()) {
    $_SESSION["mensaje"] = "Cliente actualizado exitosamente.";
    header('Location: index.php');
} else {
    header('Location: editar.php?id=' . urlencode($id) . '&error=error_actualizando');
}
exit();
?>