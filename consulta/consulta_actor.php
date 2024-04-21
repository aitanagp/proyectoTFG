<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar película por ID de actor</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Buscar película por ID de actor</h1>
        </div>
    </header>
    <form action="" method="post">
        <label for="idactor">ID de actor:</label>
        <input type="number" name="idactor" id="idactor" required><br>
        <button type="submit">Buscar</button>
    </form>


<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta."conectaDB.php";

$dbname="peliculas";
$dbcon = conectaDB($dbname);

if(isset($dbcon)) {
    if(isset($_POST['idactor'])) {
    $idactor = $_POST['idactor'];

    $sql = "SELECT p.titulo, p.imagen as pelicula_imagen, i.nombre, p.anyo_produccion, p.nacionalidad, i.imagen as actor_imagen
            FROM pelicula p
            JOIN actua a ON p.idpelicula = a.idpelicula
            JOIN interpretes i ON a.idactor = i.idactor
            WHERE a.idactor = :idactor";

    $stmt = $dbcon->prepare($sql);

    $stmt->bindParam(':idactor', $idactor);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Actor</th>
                    <th>Imagen</th>
                    <th>Película</th>
                    <th>Año de producción</th>
                    <th>Nacionalidad</th>
                    <th>Imagen</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["nombre"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Image' width='100'></td>
                    <td>" . $row["titulo"] . "</td>
                    <td>" . $row["anyo_produccion"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["actor_imagen"]) . "' alt='Image' width='100'></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontró ninguna película con el ID de actor '$idactor'.";
    }

    $dbcon = null;
}
} else {
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
    <ul>
        <li><a href="../index.php">Volver al menú</a></li>
    </ul>
</body>
</html>