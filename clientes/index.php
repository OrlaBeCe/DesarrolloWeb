<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registro de clientes</h1>
    <form action="guardar.php" method="post"> 
        <table>
            <tr>
                <td>Nombre</td>
                <td><input type="text" name="nombre" id="nombre"></td>
            </tr>
            <tr>
                <td>Domicilio</td>
                <td><input type="text" name="domicilio" id="domicilio"></td>
            </tr>
            <tr>
                <td>Giro</td>
                <td><input type="text" name="giro" id="giro"></td>
            </tr>
            <tr>
                <td>Razon Social</td>
                <td><input type="text" name="razonsocial" id="razonsocial"></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" value="Enviar">
                </td>
            </tr>
        </table> 
    </form>
    <?php
    if(isset($_GET['mensaje'])){
        echo "<p>" . htmlspecialchars($_GET['mensaje']) . "<p>";
    }
    ?>
</body>
</html>