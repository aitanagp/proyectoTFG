<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas por Director</title>
</head>
<body>
    <h1>Consulta de Películas por Director</h1>
    <form action="" method="get">
        <label for="iddirector">Buscar por ID de Director:</label>
        <input type="number" name="iddirector" id="iddirector" required><br>
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
    // Get search query from URL
    $iddirector = $_GET['iddirector'];

    // SQL query
    $sql = "SELECT * FROM pelicula WHERE iddirector = :iddirector";

    // Prepare statement
    $stmt = $dbcon->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':iddirector', $iddirector);

    // Execute statement
    $stmt->execute();

    // Check if there are results
    if ($stmt->rowCount() > 0) {
        // Display results in table
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
        // No results found
        echo "No se encontraron películas con el ID de director '$iddirector'.";
    }

    // Close connection
    $dbcon = null;
} else {
    // Display error message
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
<ul>
    <li><a href="../index.php">Volver al menú</a></li>
</ul>