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
        // LEER (Obtener un cliente o todos)
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conexion->prepare("SELECT * FROM clientes WHERE Id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
        } else {
            $resultado = $conexion->query('SELECT * FROM clientes ORDER BY Id DESC');
            $clientes = $resultado->fetch_all(MYSQLI_ASSOC);
            echo json_encode($clientes);
        }
        break;

    case 'POST':
        // CREAR
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $stmt = $conexion->prepare("INSERT INTO clientes (Nombre, Domicilio, Giro, RazonSocial) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $data['nombre'], $data['domicilio'], $data['giro'], $data['razon_social']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Cliente creado correctamente.", "id" => $conexion->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al crear cliente"]);
            }
        }
        break;

    case 'PUT':
        // ACTUALIZAR
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data && isset($data['id'])) {
            $stmt = $conexion->prepare("UPDATE clientes SET Nombre = ?, Domicilio = ?, Giro = ?, RazonSocial = ? WHERE Id = ?");
            $stmt->bind_param("ssssi", $data['nombre'], $data['domicilio'], $data['giro'], $data['razon_social'], $data['id']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Cliente actualizado correctamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al actualizar cliente"]);
            }
        }
        break;

    case 'DELETE':
        // ELIMINAR
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data && isset($data['id'])) {
            $stmt = $conexion->prepare("DELETE FROM clientes WHERE Id = ?");
            $stmt->bind_param("i", $data['id']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Cliente eliminado correctamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al eliminar cliente"]);
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
