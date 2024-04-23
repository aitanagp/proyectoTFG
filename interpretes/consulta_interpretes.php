<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta."conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

$sql = "SELECT * FROM interprete";
$stmt = $dbcon->prepare($sql);
$stmt->execute();

if($stmt->rowCount() > 0) {
    echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Año de nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Imagen</th>
                </tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["idinterprete"] . "</td>
                    <td>" . $row["nombre_inter"] . "</td>
                    <td>" . $row["anyo_nacimiento"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'></td>
                  </tr>";
        }
        echo "</table>";
        $dbcon = null;
    } else {
        echo "Error: No se pudo establecer la conexión con la base de datos.";
    }

?>
<ul>
    <li><a href="../index.php">Volver al menú</a></li>
</ul>