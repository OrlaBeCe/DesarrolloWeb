<?php
if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $nombre = $_POST['nombre'];
        $domicilio = $_POST['domicilio'];
        $giro = $_POST['giro'];
        $razon_social = $_POST['razonsocial'];

        include("../lib/conexion.php");

        $sql = "INSERT INTO clientes (Nombre, Domicilio, Giro, RazonSocial) VALUES ('".$nombre."','".$domicilio."','".$giro."','".$razon_social."')";
        if($conexion ->query($sql) === TRUE){
            $mensaje = "Nuevo registro creado exitosamente";
        }
        else {
            $mensaje = "Error: " . $sql . "<br>" . $conexion->error;
        }

        $conexion->close();
        echo "<br><br> Si se ejecuto";
        header("Location: index.php?mensaje=" .urlencode($mensaje));
    }
    else
    {
        echo "Error: La pagina solo carga POST";
        exit;
    }
