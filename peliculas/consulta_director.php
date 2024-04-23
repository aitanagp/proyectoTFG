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
        <label for="nombre_director">Buscar por nombre de Director:</label>
        <input type="text" name="nombre_director" id="nombre_director" required><br>
        <button type="submit">Buscar</button>
    </form>

<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta."conectaDB.php";

$dbname="mydb";
$dbcon = conectaDB($dbname);

if(isset($dbcon)) {
    if(isset($_POST['nombre_director'])){
        $nombre_director = $_POST['nombre_director'];

        $sql = "SELECT d.nombre, d.imagen as director_imagen, titulo, p.imagen as pelicula_imagen, anyo_prod 
        FROM director d
        JOIN pelicula p on p.iddirector=d.iddirector
        WHERE d.nombre like :nombre_director";

        $stmt = $dbcon->prepare($sql);
        $nombre_director_like = '%' . $nombre_director . '%';

        $stmt->bindParam(':nombre_director', $nombre_director_like);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>
            <tr>
                <th>Director</th>
                <th>Director Imagen</th>
                <th>Título</th>
                <th>Película Imagen</th>
                <th>Año de Producción</th>
            </tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . $row["nombre"] . "</td>
                <td><img src='data:image/jpeg;base64," . base64_encode($row["director_imagen"]) . "' alt='Director Imagen' width='100'></td>
                <td>" . $row["titulo"] . "</td>
                <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Película Imagen' width='100'></td>
                <td>" . $row["anyo_prod"] . "</td>
              </tr>";
    }
    echo "</table>";
        } else {
            echo "No se encontraron películas con el ID de director '$nombre_director'.";
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
