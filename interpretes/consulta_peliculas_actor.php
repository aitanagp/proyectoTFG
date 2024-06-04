<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por película</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <header>
        <span class="material-symbols-outlined">
            <a href="logout.php" class="logout">logout</a>
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

        <?php
        echo "<h2>Peliculas por actor</h2>";
        ?>
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

                $sql = "SELECT i.nombre_inter as nombre, i.imagen as imagen, anyo_nacimiento as anyo, titulo
                        FROM interprete i
                        JOIN actua a ON i.idinterprete = a.idinterprete
                        JOIN pelicula p ON a.idpelicula = p.idpelicula
                        WHERE p.titulo LIKE :titulo_pelicula";

                $stmt = $dbcon->prepare($sql);

                $titulo_pelicula_like = '%' . $titulo_pelicula . '%';

                $stmt->bindParam(':titulo_pelicula', $titulo_pelicula_like);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<div class='actor-results-section'>";
                    echo "<table class='actor-results-table'>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='actor-section'>";
                        echo "<td class='actor-name'>" . $row["nombre"] . "</td>";
                        echo "<td class='actor-birth'>" . $row["anyo"] . "</td>";
                        echo "<td>" . $row["titulo"] . "</td>";
                        echo "<td class='actor-image'><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Imagen actor' width='100'></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "No se encontraron actores para la película con el título '$titulo_pelicula'.";
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