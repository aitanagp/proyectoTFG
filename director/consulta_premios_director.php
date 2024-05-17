<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por director y sus premios</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="../alta/alta_directores.php">Alta</a></li>
            <li><a href="../eliminar/elimina_director.php">Eliminación</a></li>
            <li><a href="../director/consulta_directores.php">Consulta</a></li>
            <li><a href="../director/consulta_nacionalidad_director.php">Por nacionalidad</a></li>
            <li><a href="../director/consulta_nacimiento_director.php">Por fecha de nacimiento</a></li>
            <li><a href="../director/consulta_premios_director.php">Por premios</a></li>
        </ul>
    </nav>
    <main>
        <?php echo "<h2>Por Premios de Director</h2>"; ?>

        <form action="" method="post">
            <label for="nombre_director">Nombre del director:</label>
            <input type="text" name="nombre_director" id="nombre_director" required><br>
            <button type="submit">Buscar</button>
        </form>

        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        if (isset($_POST['nombre_director'])) {
            $nombre_director = $_POST['nombre_director'];
            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            $sql = "SELECT o.edicion AS edicion_premio, d.nombre AS nombre_director, d.imagen AS imagen_director, p.titulo AS titulo_pelicula, p.anyo_prod AS anyo_pelicula, p.nacionalidad AS nacionalidad_pelicula, p.imagen AS imagen_pelicula
                FROM o_director o
                JOIN director d ON o.iddirector = d.iddirector
                JOIN pelicula p ON d.idpelicula = p.idpelicula
                WHERE d.nombre LIKE :nombre_director";

            $stmt = $dbcon->prepare($sql);
            $nombre_director_like = '%' . $nombre_director . '%';
            $stmt->bindParam(':nombre_director', $nombre_director_like);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<h2>Premios ganados por películas dirigidas por $nombre_director</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Edición del premio</th>
                            <th>Nombre del director</th>
                            <th>Imagen del director</th>
                            <th>Título de la película</th>
                            <th>Año de producción de la película</th>
                            <th>Nacionalidad de la película</th>
                            <th>Imagen de la película</th>
                        </tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>" . $row["edicion_premio"] . "</td>
                        <td>" . $row["nombre_director"] . "</td>
                        <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen_director"]) . "' alt='Imagen del director' width='100'></td>
                        <td>" . $row["titulo_pelicula"] . "</td>
                        <td>" . $row["anyo_pelicula"] . "</td>
                        <td>" . $row["nacionalidad_pelicula"] . "</td>
                        <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen_pelicula"]) . "' alt='Imagen de la película' width='100'></td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron premios ganados por películas dirigidas por $nombre_director.";
            }

            $dbcon = null;
        }
        ?>
    </main>
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>