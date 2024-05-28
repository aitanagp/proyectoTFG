<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Películas por Director</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <a href="../index.php" class="home-link">&#8962;</a>
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
        <?php echo "<h2>Directores</h2>"; ?>
        <form action="" method="post">
            <select id="nombre" name="nombre" onclick="mostrarDirectores()" required>
                <?php
                require_once "../funciones.php";
                $ruta = obtenerdirseg();
                require_once $ruta . "conectaDB.php";

                $dbname = "mydb";
                $dbcon = conectaDB($dbname);
                if (isset($dbcon)) {
                    $sql = "SELECT nombre FROM director";
                    $stmt = $dbcon->prepare($sql);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row["nombre"] . "'>" . $row["nombre"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay directores</option>";
                    }

                    $dbcon = null;
                }
                ?>
            </select>
            <button type="submit">Buscar</button>
        </form>
        <br><br>
        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        if (isset($dbcon)) {
            if (isset($_POST['nombre'])) {
                $nombre = $_POST['nombre'];

                $sql = "SELECT d.nombre, d.imagen as director_imagen, titulo, p.imagen as pelicula_imagen, anyo_prod 
                FROM dirige di
                JOIN pelicula p ON p.idpelicula=di.idpelicula
                JOIN director d ON d.iddirector=di.iddirector
                WHERE d.nombre LIKE :nombre";

                $stmt = $dbcon->prepare($sql);
                $nombre_like = '%' . $nombre . '%';

                $stmt->bindParam(':nombre', $nombre_like);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<div class='director-section'>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='director-info'>";
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row["director_imagen"]) . "' alt='Director Imagen' class='actor-image'>";
                        echo "<div class='director-details'>";
                        echo "<h3>{$row['nombre']}</h3>";
                        echo "<p><strong>Título:</strong> {$row['titulo']}</p>";
                        echo "<p><strong>Año de producción:</strong> {$row['anyo_prod']}</p>";
                        echo "</div>"; // Cierre de director-details
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Película Imagen' class='pelicula-image'>";
                        echo "</div>"; // Cierre de director-info
                    }
                    echo "</div>"; // Cierre de director-section
                } else {
                    echo "No se encontraron películas con el nombre de director '$nombre'.";
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