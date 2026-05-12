<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    http_response_code(401);
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

include("../lib/conexion.php");
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conexion->prepare("SELECT * FROM productos WHERE Id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
        } else {
            $resultado = $conexion->query('SELECT * FROM productos ORDER BY Id DESC');
            $productos = $resultado->fetch_all(MYSQLI_ASSOC);
            echo json_encode($productos);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $stmt = $conexion->prepare("INSERT INTO productos (Codigo, Descripcion, Cantidad, Precio) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssd", $data['codigo'], $data['descripcion'], $data['cantidad'], $data['precio']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Producto creado correctamente.", "id" => $conexion->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al crear producto"]);
            }
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data && isset($data['id'])) {
            $stmt = $conexion->prepare("UPDATE productos SET Codigo = ?, Descripcion = ?, Cantidad = ?, Precio = ? WHERE Id = ?");
            $stmt->bind_param("sssdi", $data['codigo'], $data['descripcion'], $data['cantidad'], $data['precio'], $data['id']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Producto actualizado correctamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al actualizar producto"]);
            }
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data && isset($data['id'])) {
            $stmt = $conexion->prepare("DELETE FROM productos WHERE Id = ?");
            $stmt->bind_param("i", $data['id']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Producto eliminado correctamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al eliminar producto"]);
            }
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

$conexion->close();
?>
