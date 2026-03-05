<?php

//valida que el formulario se envio por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //tomar los datos tipo POST
    $email = $_POST["email"];
    $password = $_POST["password"];
    
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
        //usuario encontrado, iniciar sesión
        session_start();
        $_SESSION["usuario"] = $result->fetch_assoc()["nombre"]; //guardar el nombre de usuario en la sesión
        header("Location: usuarios/index.php"); //redireccionar al dashboard
    } else {
        //usuario no encontrado, mostrar mensaje de error
        echo "Error: Credenciales inválidas. Por favor, inténtalo de nuevo.";
    }
}
?>