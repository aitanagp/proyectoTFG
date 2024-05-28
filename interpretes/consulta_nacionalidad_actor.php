<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por nacionalidad</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <a href="../index.php" class="home-link">&#8962;</a>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Buscar por nacionalidad</h1>
        </div>
    </header>
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
    <main>
        <div class="nationality-search-section">
            <h2>Buscar por nacionalidad</h2>
            <form class="nationality-search-form" action="" method="post">
                <label for="nacionalidad">Nacionalidad de actor:</label>
                <input type="text" name="nacionalidad" id="nacionalidad" required>
                <button type="submit">Buscar</button>
            </form>

            <?php
            require_once "../funciones.php";
            $ruta = obtenerdirseg();
            require_once $ruta . "conectaDB.php";

            $dbname = "mydb";
            $dbcon = conectaDB($dbname);

            if (isset($dbcon)) {
                if (isset($_POST['nacionalidad'])) {
                    $nacionalidad = $_POST['nacionalidad'];

                    $sql = "SELECT nombre_inter, nacionalidad, imagen
                FROM interprete 
                WHERE nacionalidad LIKE :nacionalidad";

                    $stmt = $dbcon->prepare($sql);

                    // Agregar % al principio y al final para hacer una búsqueda parcial
                    $nacionalidad_like = '%' . $nacionalidad . '%';

                    $stmt->bindParam(':nacionalidad', $nacionalidad_like);

                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        echo "<div class='nationality-results-section'>";
                        echo "<table class='nationality-results-table'>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr class='actor-section'>";
                            echo "<td class='actor-info'>";
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row['imagen']) . "' alt='Imagen del actor' class='actor-img'>";
                            echo "<div class='actor-details'>";
                            echo "<h3>{$row['nombre_inter']}</h3>";
                            echo "<p><strong>Nacionalidad:</strong> {$row['nacionalidad']}</p>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "No se encontraron actores con la nacionalidad '$nacionalidad'.";
                    }

                    $dbcon = null;
                }
            } else {
                echo "Error: No se pudo establecer la conexión con la base de datos.";
            }
            ?>

        </div>
    </main>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>