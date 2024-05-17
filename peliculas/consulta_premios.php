<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por película</title>
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
            <li><a href="../alta/alta_peliculas.php">Alta</a></li>
            <li><a href="../eliminar/elimina_peliculas.php">Eliminación</a></li>
            <li><a href="../peliculas/consulta_pelicula.php">Consulta</a></li>
            <li><a href="../peliculas/consulta_fecha.php">Por Fecha</a></li>
            <li><a href="../peliculas/consulta_director.php">Por director</a></li>
            <li><a href="../peliculas/consulta_titulo.php">Por título</a></li>
            <li><a href="../peliculas/consulta_actor.php">Por Actor</a></li>
            <li><a href="../peliculas/consulta_premios.php">Por premios</a></li>
        </ul>
    </nav>
    <main>
        <?php echo "<h2>Añadir Directores</h2>"; ?>

        <form action="" method="post">
            <label for="titulo_pelicula">Título de la película:</label>
            <input type="text" name="titulo_pelicula" id="titulo_pelicula" required><br>
            <button type="submit">Buscar</button>
        </form>

        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        if (isset($dbcon)) {
            if (isset($_POST['titulo_pelicula'])) {
                $titulo_pelicula = $_POST['titulo_pelicula'];

                // Consulta para obtener los premios ganados por la película
                $sql_premios_pelicula = "SELECT o.edicion, p.titulo AS premio, 'Mejor Película' AS tipo_premio, p.imagen AS pelicula_imagen
                                     FROM o_pelicula o
                                     JOIN pelicula p ON o.idpelicula = p.idpelicula
                                     WHERE p.titulo LIKE :titulo_pelicula";

                $stmt_premios_pelicula = $dbcon->prepare($sql_premios_pelicula);
                $titulo_pelicula_like = '%' . $titulo_pelicula . '%';
                $stmt_premios_pelicula->bindParam(':titulo_pelicula', $titulo_pelicula_like);
                $stmt_premios_pelicula->execute();

                // Consulta para obtener los premios ganados por los actores en la película
                $sql_premios_actores = "SELECT o.edicion, i.nombre_inter AS premio, 'Mejor Actor' AS tipo_premio, i.imagen AS actor_imagen
                                    FROM o_interprete o
                                    JOIN interprete i ON o.idinterprete = i.idinterprete
                                    JOIN pelicula p ON o.idpelicula = p.idpelicula
                                    WHERE p.titulo LIKE :titulo_pelicula";

                $stmt_premios_actores = $dbcon->prepare($sql_premios_actores);
                $stmt_premios_actores->bindParam(':titulo_pelicula', $titulo_pelicula_like);
                $stmt_premios_actores->execute();

                // Consulta para obtener los premios ganados por el guion de la película
                $sql_premios_guion = "SELECT o.edicion, g.nombre_guion AS premio, 'Mejor Guion' AS tipo_premio
                                  FROM o_guion o
                                  JOIN guion g ON o.idguion = g.idguion
                                  JOIN pelicula p ON o.idpelicula = p.idpelicula
                                  WHERE p.titulo LIKE :titulo_pelicula";

                $stmt_premios_guion = $dbcon->prepare($sql_premios_guion);
                $stmt_premios_guion->bindParam(':titulo_pelicula', $titulo_pelicula_like);
                $stmt_premios_guion->execute();

                // Consulta para obtener los premios ganados por el director de la película
                $sql_premios_director = "SELECT o.edicion, d.nombre AS premio, 'Mejor Director' AS tipo_premio, d.imagen AS director_imagen
                                     FROM o_director o
                                     JOIN director d ON o.iddirector = d.iddirector
                                     JOIN pelicula p ON o.idpelicula = p.idpelicula
                                     WHERE p.titulo LIKE :titulo_pelicula";

                $stmt_premios_director = $dbcon->prepare($sql_premios_director);
                $stmt_premios_director->bindParam(':titulo_pelicula', $titulo_pelicula_like);
                $stmt_premios_director->execute();

                if ($stmt_premios_pelicula->rowCount() > 0) {
                    echo "<h2>Premios de la película '$titulo_pelicula'</h2>";
                    echo "<table border='1'>
                        <tr>
                            <th>Edición</th>
                            <th>Premio</th>
                            <th>Tipo de Premio</th>
                            <th>Imagen de la Película</th>
                        </tr>";
                    while ($row = $stmt_premios_pelicula->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>" . $row["edicion"] . "</td>
                            <td>" . $row["premio"] . "</td>
                            <td>" . $row["tipo_premio"] . "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Imagen de la película' width='100'></td>
                          </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se encontraron premios para la película con el título '$titulo_pelicula'.";
                }

                if ($stmt_premios_actores->rowCount() > 0) {
                    echo "<h2>Premios individuales ganados por los actores</h2>";
                    echo "<table border='1'>
                        <tr>
                            <th>Edición</th>
                            <th>Nombre del actor</th>
                            <th>Tipo de Premio</th>
                            <th>Imagen del Actor</th>
                        </tr>";
                    while ($row = $stmt_premios_actores->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>" . $row["edicion"] . "</td>
                            <td>" . $row["premio"] . "</td>
                            <td>" . $row["tipo_premio"] . "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["actor_imagen"]) . "' alt='Imagen del Actor' width='100'></td>
                          </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Ningún actor de la película '$titulo_pelicula' ha ganado premios individuales.";
                }

                if ($stmt_premios_guion->rowCount() > 0) {
                    echo "<h2>Premios relacionados con el guion</h2>";
                    echo "<table border='1'>
                        <tr>
                            <th>Edición</th>
                            <th>Guion</th>
                            <th>Tipo de Premio</th>
                        </tr>";
                    while ($row = $stmt_premios_guion->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>" . $row["edicion"] . "</td>
                            <td>" . $row["premio"] . "</td>
                            <td>" . $row["tipo_premio"] . "</td>
                          </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se encontraron premios relacionados con el guion para la película '$titulo_pelicula'.";
                }

                if ($stmt_premios_director->rowCount() > 0) {
                    echo "<h2>Premios relacionados con el director</h2>";
                    echo "<table border='1'>
                        <tr>
                            <th>Edición</th>
                            <th>Nombre del director</th>
                            <th>Tipo de Premio</th>
                            <th>Imagen del Director</th>
                        </tr>";
                    while ($row = $stmt_premios_director->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                            <td>" . $row["edicion"] . "</td>
                            <td>" . $row["premio"] . "</td>
                            <td>" . $row["tipo_premio"] . "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["director_imagen"]) . "' alt='Imagen del Director' width='100'></td>
                          </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se encontraron premios relacionados con el director para la película '$titulo_pelicula'.";
                }

                $dbcon = null;
            }
        } else {
            echo "Error: No se pudo establecer la conexión con la base de datos.";
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