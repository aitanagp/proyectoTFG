<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por actor</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Buscar por actor</h1>
        </div>
    </header>
    <form action="" method="post">
        <label for="nombre_actor">Nombre de actor:</label>
        <input type="text" name="nombre_actor" id="nombre_actor" required><br>
        <button type="submit">Buscar</button>
    </form>

    <?php
    require_once "../funciones.php";
    $ruta = obtenerdirseg();
    require_once $ruta . "conectaDB.php";

    $dbname = "mydb";
    $dbcon = conectaDB($dbname);

    if (isset($dbcon)) {
        if (isset($_POST['nombre_actor'])) {
            $nombre_actor = $_POST['nombre_actor'];

            // Consulta para obtener los premios ganados por el actor y los detalles de la película
            $sql = "SELECT o.edicion, i.nombre_inter AS actor, i.imagen AS actor_imagen, p.titulo AS pelicula, p.imagen AS pelicula_imagen
                    FROM o_interprete o
                    JOIN interprete i ON o.idinterprete = i.idinterprete
                    JOIN actua a ON i.idinterprete = a.idinterprete
                    JOIN pelicula p ON a.idpelicula = p.idpelicula
                    WHERE i.nombre_inter LIKE :nombre_actor";

            $stmt = $dbcon->prepare($sql);
            $nombre_actor_like = '%' . $nombre_actor . '%';
            $stmt->bindParam(':nombre_actor', $nombre_actor_like);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<h2>Premios ganados por el actor '$nombre_actor'</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Edición</th>
                            <th>Actor</th>
                            <th>Imagen del Actor</th>
                            <th>Título de la Película</th>
                            <th>Imagen de la Película</th>
                        </tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . $row["edicion"] . "</td>
                            <td>" . $row["actor"] . "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["actor_imagen"]) . "' alt='Imagen del Actor' width='100'></td>
                            <td>" . $row["pelicula"] . "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Imagen de la Película' width='100'></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron premios para el actor '$nombre_actor'.";
            }

            $dbcon = null;
        }
    } else {
        echo "Error: No se pudo establecer la conexión con la base de datos.";
    }
    ?>
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>