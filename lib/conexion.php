<?php
$server = "localhost";
        $user = "root";
        $pass = "";
        $bd = "MiPagina";

        $conexion = new mysqli($server,$user,$pass,$bd);

        if($conexion->connect_error){
            die("conexion fallida: " . $conexion->connect_error);
        }
        else{
            //echo "conexion exitosa";
        }
?>