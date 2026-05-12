<?php
session_start();
//verifica que la soicitud venga por post
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: index.php');
    exit();
}
//tomamos los datos por metodo post
$id = $_POST["id"];
$codigo = trim($_POST["codigo"] ?? '');
$descripcion = trim($_POST["descripcion"] ?? '');
$cantidad = $_POST["cantidad"] ?? '';
$precio = $_POST["precio"] ?? '';

//validamos que los campos no esten vacios
if (empty($codigo) || empty($descripcion) || $cantidad === '' || $precio === '') {
    header('Location: editar.php?id=' . $id . '&error=campos_vacios');
    exit();
}

include '../lib/conexion.php';

//actualizamos el producto en la base de datos con prepared statements
$stmt = $conexion->prepare("UPDATE productos SET Codigo = ?, Descripcion = ?, Cantidad = ?, Precio = ? WHERE Id = ?");
$stmt->bind_param("ssidi", $codigo, $descripcion, $cantidad, $precio, $id);
if ($stmt->execute()) {
    $_SESSION["mensaje"] = "Producto actualizado exitosamente.";
    header('Location: index.php');
} else {
    header('Location: editar.php?id=' . $id . '&error=bd');
}
$stmt->close();
exit();
?>
