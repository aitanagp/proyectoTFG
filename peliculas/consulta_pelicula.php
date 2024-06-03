<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <header>
        <span class="material-symbols-outlined">
            <a href="../index.php" class="home-link">home</a>
        </span>

        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
        <br>
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
    </header>
    <main>
        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        $sql = "SELECT p.titulo, p.anyo_prod, p.nacionalidad AS peli_nacionalidad, d.nombre AS director_nombre, p.imagen AS pelicula_imagen, d.imagen AS director_imagen
                FROM pelicula p
                JOIN dirige di ON di.idpelicula = p.idpelicula
                JOIN director d ON di.iddirector = d.iddirector
                ORDER BY d.nombre, p.titulo";

        $stmt = $dbcon->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $directores = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $directorNombre = $row['director_nombre'];
                if (!isset($directores[$directorNombre])) {
                    $directores[$directorNombre] = [
                        'nombre' => $directorNombre,
                        'imagen' => $row['director_imagen'],
                        'peliculas' => []
                    ];
                }
                $directores[$directorNombre]['peliculas'][] = [
                    'titulo' => $row['titulo'],
                    'anyo_prod' => $row['anyo_prod'],
                    'nacionalidad' => $row['peli_nacionalidad'],
                    'imagen' => $row['pelicula_imagen']
                ];
            }

            foreach ($directores as $director) {
                echo "<div class='director-section'>";
                echo "<div class='director-info'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($director['imagen']) . "' alt='Imagen del director'>";
                echo "<div class='director-details'>";
                echo "<h2>{$director['nombre']}</h2>";
                echo "</div>";
                echo "</div>";
                echo "<div>";
                echo "<h3>Películas:</h3>";
                if (!empty($director['peliculas'])) {
                    echo "<ul class='peliculas-list'>";
                    foreach ($director['peliculas'] as $pelicula) {
                        echo "<li>";
                        echo "<strong>{$pelicula['titulo']}</strong><br>";
                        echo "<span><strong>Año:</strong> {$pelicula['anyo_prod']}</span><br>";
                        echo "<span><strong>Nacionalidad:</strong> {$pelicula['nacionalidad']}</span><br>";
                        if ($pelicula['imagen']) {
                            echo "<img src='data:image/jpeg;base64," . base64_encode($pelicula['imagen']) . "' alt='Imagen de la película'><br>";
                        }
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No tiene películas registradas.</p>";
                }
                echo "</div>";
                echo "</div>";
            }

            $dbcon = null;
        } else {
            echo "Error: No se encontraron directores en la base de datos.";
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