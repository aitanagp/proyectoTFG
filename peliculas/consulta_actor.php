<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar película por nombre de actor</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Buscar película por nombre de actor</h1>
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
    require_once $ruta."conectaDB.php";

    $dbname = "mydb";
    $dbcon = conectaDB($dbname);

    if(isset($dbcon)) {
        if(isset($_POST['nombre_actor'])) {
            $nombre_actor = $_POST['nombre_actor'];

            $sql = "SELECT p.titulo, p.imagen as pelicula_imagen, i.nombre_inter as nombre, p.anyo_prod as anyo_produccion, p.nacionalidad, i.imagen as actor_imagen
                    FROM pelicula p
                    JOIN actua a ON p.idpelicula = a.idpelicula
                    JOIN interprete i ON a.idinterprete = i.idinterprete
                    WHERE i.nombre_inter LIKE :nombre_actor";

            $stmt = $dbcon->prepare($sql);

            // Agregar % al principio y al final del nombre_actor para hacer una búsqueda parcial
            $nombre_actor_like = '%' . $nombre_actor . '%';

            $stmt->bindParam(':nombre_actor', $nombre_actor_like);

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
                echo "No se encontró ninguna película con el nombre de actor '$nombre_actor'.";
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

