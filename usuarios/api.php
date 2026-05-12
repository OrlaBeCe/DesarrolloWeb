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
            $stmt = $conexion->prepare("SELECT id, nombre, correo, es_admin FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
        } else {
            $resultado = $conexion->query('SELECT id, nombre, correo, es_admin FROM usuarios ORDER BY id DESC');
            $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, contrasena, es_admin) VALUES (?, ?, ?, ?)");
            $hash = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            $es_admin = intval($data['es_admin']);
            $stmt->bind_param("sssi", $data['nombre'], $data['correo'], $hash, $es_admin);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Usuario creado correctamente.", "id" => $conexion->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al crear usuario"]);
            }
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data && isset($data['id'])) {
            $es_admin = intval($data['es_admin']);
            if (!empty($data['contrasena'])) {
                $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, contrasena = ?, es_admin = ? WHERE id = ?");
                $hash = password_hash($data['contrasena'], PASSWORD_DEFAULT);
                $stmt->bind_param("sssii", $data['nombre'], $data['correo'], $hash, $es_admin, $data['id']);
            } else {
                $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, es_admin = ? WHERE id = ?");
                $stmt->bind_param("ssii", $data['nombre'], $data['correo'], $es_admin, $data['id']);
            }
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Usuario actualizado correctamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al actualizar usuario"]);
            }
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data && isset($data['id'])) {
            $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $data['id']);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "mensaje" => "Usuario eliminado correctamente."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error al eliminar usuario"]);
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
