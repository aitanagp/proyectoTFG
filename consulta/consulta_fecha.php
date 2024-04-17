<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas</title>
</head>
<body>
    <h1>Consulta de Películas</h1>
    <form action="consulta_fecha.php" method="get">
        <label for="anyo">Buscar por año de producción:</label>
        <input type="number" name="anyo" id="anyo" required><br>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>

<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta."conectaDB.php";

$dbname="peliculas";
$dbcon = conectaDB($dbname);

if(isset($dbcon)) {
    $anyo = isset($_GET['anyo']) ? $_GET['anyo'] : '';

    $sql = "SELECT * FROM pelicula WHERE anyo_produccion = :anyo";

    $stmt = $dbcon->prepare($sql);

    $stmt->bindParam(':anyo', $anyo);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Año de producción</th>
                    <th>Nacionalidad</th>
                    <th>ID Remake</th>
                    <th>ID Director</th>
                    <th>ID Guion</th>
                    <th>Imagen</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["idpelicula"] . "</td>
                    <td>" . $row["titulo"] . "</td>
                    <td>" . $row["anyo_produccion"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td>" . $row["idremake"] . "</td>
                    <td>" . $row["iddirector"] . "</td>
                    <td>" . $row["idguion"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No seencontraron películas con el año de producción '$anyo'.";
    }

    $dbcon = null;
} else {
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
<ul>
    <li><a href="../index.php">Volver al menú</a></li>
</ul>