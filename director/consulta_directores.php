<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <header>
        <?php if (isset($_SESSION['foto_perfil'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['foto_perfil']); ?>" alt="Foto de Perfil"
                class="perfil-pequeno">
        <?php endif; ?>
        <span class="material-symbols-outlined">
            <a href="../logout.php" class="logout">logout</a>
        </span>
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
                <li><a href="../alta/alta_directores.php">Alta</a></li>
                <li><a href="../eliminar/elimina_director.php">Eliminación</a></li>
                <li><a href="../director/consulta_directores.php">Consulta</a></li>
                <li><a href="../director/consulta_nacionalidad_director.php">Por nacionalidad</a></li>
                <li><a href="../director/consulta_nacimiento_director.php">Por fecha de nacimiento</a></li>
                <li><a href="../director/consulta_premios_director.php">Por premios</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        echo "<h2>Directores</h2>";

        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        // Consulta para obtener los directores y sus películas
        $sql = "SELECT d.*, p.titulo AS pelicula, p.imagen AS pelicula_imagen
                FROM director d
                JOIN dirige di ON di.iddirector = d.iddirector
                LEFT JOIN pelicula p ON di.idpelicula = p.idpelicula
                ORDER BY d.nombre, p.titulo";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $directores = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $iddirector = $row['iddirector'];
                if (!isset($directores[$iddirector])) {
                    $directores[$iddirector] = [
                        'nombre' => $row['nombre'],
                        'nacionalidad' => $row['nacionalidad'],
                        'anyo_nacimiento' => $row['anyo_nacimiento'],
                        'imagen' => $row['imagen'],
                        'peliculas' => []
                    ];
                }
                if ($row['pelicula']) {
                    $directores[$iddirector]['peliculas'][] = [
                        'titulo' => $row['pelicula'],
                        'imagen' => $row['pelicula_imagen']
                    ];
                }
            }

            // Mostrar la información de cada director
            foreach ($directores as $director) {
                echo "<div class='director-section'>";
                echo "<div class='director-info'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($director['imagen']) . "' alt='Imagen del director'>";
                echo "<div class='director-details'>";
                echo "<h2>{$director['nombre']}</h2>";
                echo "<p><strong>Nacionalidad:</strong> {$director['nacionalidad']}</p>";
                echo "<p><strong>Año de nacimiento:</strong> {$director['anyo_nacimiento']}</p>";
                echo "</div>";
                echo "</div>";
                echo "<div>";
                echo "<h3>Películas:</h3>";
                if (!empty($director['peliculas'])) {
                    echo "<ul class='peliculas-list'>";
                    foreach ($director['peliculas'] as $pelicula) {
                        echo "<li>";
                        echo "<strong>{$pelicula['titulo']}</strong><br>";
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