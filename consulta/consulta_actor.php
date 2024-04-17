<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar película por ID de actor</title>
</head>
<body>
    <h1>Buscar película por ID de actor</h1>
    <form action="" method="get">
        <label for="idactor">ID de actor:</label>
        <input type="number" name="idactor" id="idactor" required><br>
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
    $idactor = $_GET['idactor'];

    // SQL query
    $sql = "SELECT p.titulo, p.imagen, i.nombre, p.anyo_produccion, p.nacionalidad
            FROM pelicula p
            JOIN actua a ON p.idpelicula = a.idpelicula
            JOIN interpretes i ON a.idactor = i.idactor
            WHERE a.idactor = :idactor";

    // Prepare statement
    $stmt = $dbcon->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':idactor', $idactor);

    // Execute statement
    $stmt->execute();

    // Check if there are results
    if ($stmt->rowCount() > 0) {
        // Display results in table
        echo "<table border='1'>
                <tr>
                    <th>Actor</th>
                    <th>Imagen</th>
                    <th>Película</th>
                    <th>Año de producción</th>
                    <th>Nacionalidad</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["nombre"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'></td>
                    <td>" . $row["titulo"] . "</td>
                    <td>" . $row["anyo_produccion"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        // No results found
        echo "No se encontró ninguna película con el ID de actor '$idactor'.";
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