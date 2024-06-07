<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas por año</title>
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
        <?php echo "<h2>Año estreno</h2>"; ?>
        <form action="" method="post">
            <label for="anyo">Buscar por año de producción:</label>
            <input type="number" name="anyo" id="anyo" required><br>
            <button type="submit">Buscar</button>
        </form>


        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        if (isset($dbcon)) {
            if (isset($_POST['anyo'])) {
                $anyo = $_POST['anyo'];
                $sql = "SELECT titulo, anyo_prod, nacionalidad, imagen FROM pelicula WHERE anyo_prod LIKE :anyo";
                $stmt = $dbcon->prepare($sql);
                $anyo_like = '%' . $anyo . '%';
                $stmt->bindParam(':anyo', $anyo_like);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<div class='director-section'>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='director-info'>";
                        echo "<div class='director-details'>";
                        echo "<h3>{$row['titulo']}</h3>";
                        echo "<p><strong>Año de producción:</strong> {$row['anyo_prod']}</p>";
                        echo "<p><strong>Nacionalidad:</strong> {$row['nacionalidad']}</p>";
                        echo "</div>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Imagen del película' class='pelicula-image'>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "No se encontraron películas para el año '$anyo'.";
                }
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