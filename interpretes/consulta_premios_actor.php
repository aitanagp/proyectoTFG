<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por actor</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <header>
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
                <li><a href="../alta/alta_interpretes.php">Alta</a></li>
                <li><a href="../eliminar/elimina_interpretes.php">Eliminación</a></li>
                <li><a href="../interpretes/consulta_interpretes.php">Consulta</a></li>
                <li><a href="../interpretes/consulta_nacionalidad_actor.php">Por nacionalidad</a></li>
                <li><a href="../interpretes/consulta_nacimineto_actor.php">Por nacimiento</a></li>
                <li><a href="../interpretes/consulta_peliculas_actor.php">Por películas</a></li>
                <li><a href="../interpretes/consulta_premios_actor.php">Por premios</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo "<h2>Premios por actor</h2>"; ?>
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
                        AND p.idpelicula=o.idpelicula
                        WHERE i.nombre_inter LIKE :nombre_actor";


                $stmt = $dbcon->prepare($sql);
                $nombre_actor_like = '%' . $nombre_actor . '%';
                $stmt->bindParam(':nombre_actor', $nombre_actor_like);
                $stmt->execute();

                // Mostrar los premios ganados por el actor
                if ($stmt->rowCount() > 0) {
                    echo "<div class='container'>";
                    echo "<div class='awards-section'>";
                    echo "<h2>Premios individuales ganados por los actores</h2>";
                    echo "<div class='awards-cards'>";

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='award-card'>";
                        echo "<div class='actor-card-content'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['actor_imagen']) . "' alt='" . $row['actor'] . "' class='award-image'>";
                        echo "<div class='award-details'>";
                        echo "<p><strong>Edición:</strong> " . $row['edicion'] . "</p>";
                        echo "<p><strong>Premio:</strong> " . $row['actor'] . "</p>";
                        echo "<p><strong>Película:</strong> " . $row['pelicula'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }

                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<p>No se encontraron premios para el actor '$nombre_actor'.</p>";
                }
            }
        }
        ?>
    </main>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>