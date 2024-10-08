<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por director y sus premios</title>
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
                JOIN dirige di ON di.iddirector = d.iddirector
                JOIN pelicula p ON di.idpelicula = p.idpelicula
                WHERE d.nombre LIKE :nombre_director";

            $stmt = $dbcon->prepare($sql);
            $nombre_director_like = '%' . $nombre_director . '%';
            $stmt->bindParam(':nombre_director', $nombre_director_like);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<div class='container'>";
                echo "<div class='awards-section'>";
                echo "<h2>Premios Individuales ganados por directores</h2>";
                echo "<div class='awards-cards'>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='award-card'>";
                    echo "<div class='actor-card-content'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($row['imagen_director']) . "' alt='" . $row['nombre_director'] . "' class='award-image'>";
                    echo "<div class='award-details'>";
                    echo "<p><strong>Edición:</strong> " . $row['edicion_premio'] . "</p>";
                    echo "<p><strong>Premio:</strong> " . $row['nombre_director'] . "</p>";
                    echo "<p><strong>Película:</strong> " . $row['titulo_pelicula'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "<p>No se encontraron premios para el director '$nombre_director'.</p>";
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