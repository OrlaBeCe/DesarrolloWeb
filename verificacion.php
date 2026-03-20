<?php

//valida que el formulario se envio por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //tomar los datos tipo POST
    $email = $_POST["email"];
    $password = $_POST["password"];
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : "admin";
    
    //validar que el email y password no esten vacios
    if (empty($email) || empty($password)) {
        echo "Error: El email y la contraseña son obligatorios.";
        exit;
    }
    //conexion a la base de datos
    include ("lib/conexion.php");


    $password_hash = md5($password);
        //preparar la consulta SQL para verificar el usuario usando prepared statements para evitar inyecciones SQL
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    //verificar si se encontro un usuario con las credenciales proporcionadas
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        //usuario encontrado, iniciar sesión
        session_start();
        $_SESSION["usuario"] = $usuario["nombre"]; //guardar el nombre de usuario en la sesión
        
        if ($origen === "clientes") {
            header("Location: clientes/index.php"); //redireccionar a la ventana de clientes
        } else {
            header("Location: usuarios/index.php"); //redireccionar al dashboard
        }
        exit();
    } else {
        //usuario no encontrado, mostrar mensaje de error
        if ($origen === "clientes") {
            echo "<script>alert('Error: Credenciales inválidas. Por favor, inténtalo de nuevo.'); window.location.href='loginClientes.php';</script>";
        } else {
            echo "<script>alert('Error: Credenciales inválidas. Por favor, inténtalo de nuevo.'); window.location.href='login2.php';</script>";
        }
    }
}
?>