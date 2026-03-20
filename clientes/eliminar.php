<?php
session_start();
//verificar que se recibe con metodo post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //verificar que se recibe el id
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        //validar que id no sea vacio
        if (empty($id)) {
            header("Location: index.php?error=id_vacio");
            exit();
        }
        //conexión a la base de datos
        include("../lib/conexion.php");
        //eliminar el usuario
        $stmt = $conexion->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION["mensaje"] = "Cliente eliminado exitosamente.";
            header("Location: index.php");
            exit();
        }
        else {
            header("Location: index.php?error=error_al_eliminar");
            exit();
        }
    }
    else {
        header("Location: index.php?error=id_no_proporcionado");
        exit();
    }
}
else {
    header("Location: index.php?error=metodo_no_permitido");
    exit();
}
?>