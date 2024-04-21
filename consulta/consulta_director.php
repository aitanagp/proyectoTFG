<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas por Director</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Consulta de Películas por Director</h1>
        </div>
    </header>
    <form action="" method="post">
        <label for="id">Buscar por ID de Director:</label>
        <input type="number" name="id" id="id" required><br>
        <button type="submit">Buscar</button>
    </form>

<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta."conectaDB.php";

$dbname="peliculas";
$dbcon = conectaDB($dbname);

if(isset($dbcon)) {
    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $sql = "SELECT * FROM pelicula WHERE iddirector = :id";

        $stmt = $dbcon->prepare($sql);

        $stmt->bindParam(':id', $id);

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
            echo "No se encontraron películas con el ID de director '$id'.";
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
