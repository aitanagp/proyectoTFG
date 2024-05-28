<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premios por Categorías</title>
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
                <li><a href="../premios/premios.php">Premios</a></li>
                <li><a href="../alta/alta_premios.php">Alta</a></li>
                <li><a href="../eliminar/elimina_premios.php">Eliminación</a></li>
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

        if (isset($dbcon)) {
            $sql_premios_pelicula = "SELECT o.edicion, p.titulo AS premio, 'Mejor Película' AS tipo_premio, p.imagen AS pelicula_imagen
                            FROM o_pelicula o
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_pelicula = $dbcon->prepare($sql_premios_pelicula);
            $stmt_premios_pelicula->execute();

            $sql_premios_actores = "SELECT o.edicion, i.nombre_inter AS premio, 'Mejor Actor' AS tipo_premio, i.imagen AS actor_imagen, p.titulo AS pelicula_titulo
                            FROM o_interprete o
                            JOIN interprete i ON o.idinterprete = i.idinterprete
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_actores = $dbcon->prepare($sql_premios_actores);
            $stmt_premios_actores->execute();

            $sql_premios_guion = "SELECT o.edicion, g.nombre_guion AS premio, 'Mejor Guion' AS tipo_premio, p.imagen AS pelicula_imagen
                        FROM o_guion o
                        JOIN guion g ON o.idguion = g.idguion
                        JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_guion = $dbcon->prepare($sql_premios_guion);
            $stmt_premios_guion->execute();


            $sql_premios_director = "SELECT o.edicion, d.nombre AS premio, 'Mejor Director' AS tipo_premio, d.imagen AS director_imagen
                            FROM o_director o
                            JOIN director d ON o.iddirector = d.iddirector
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_director = $dbcon->prepare($sql_premios_director);
            $stmt_premios_director->execute();
            function displayCards($title, $stmt, $fields, $imageField = null, $additionalInfo = null)
            {
                if ($stmt->rowCount() > 0) {
                    echo "<div class='awards-section'>";
                    echo "<h2>$title</h2>";
                    echo "<div class='awards-cards'>";

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='award-card'>";
                        echo "<div class='actor-card-content'>";
                        if ($imageField) {
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row[$imageField]) . "' alt='$title' class='award-image'>";
                        }
                        echo "<div class='award-details'>";
                        foreach ($fields as $field => $label) {
                            echo "<p><strong>$label:</strong> " . $row[$field] . "</p>";
                        }
                        if ($additionalInfo) {
                            echo "<div class='actor-info'>";
                            foreach ($additionalInfo as $field => $label) {
                                echo "<p><strong>$label:</strong> " . $row[$field] . "</p>";
                            }
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }

                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div class='no-awards'>No se encontraron premios para la categoría '$title'.</div>";
                }
            }

            echo "<div class='container'>";
            displayCards("Premios de Películas", $stmt_premios_pelicula, ["edicion" => "Edición", "premio" => "Premio", "tipo_premio" => "Tipo de Premio"], "pelicula_imagen");
            displayCards("Premios de Actores", $stmt_premios_actores, ["edicion" => "Edición", "premio" => "Nombre del actor", "tipo_premio" => "Tipo de Premio"], "actor_imagen", ["pelicula_titulo" => "Película"]);
            displayCards("Premios de Guion", $stmt_premios_guion, ["edicion" => "Edición", "premio" => "Guion", "tipo_premio" => "Tipo de Premio"], "pelicula_imagen");
            displayCards("Premios de Directores", $stmt_premios_director, ["edicion" => "Edición", "premio" => "Nombre del director", "tipo_premio" => "Tipo de Premio"], "director_imagen");
            echo "</div>";

            $dbcon = null;
        } else {
            echo "Error: No se pudo establecer la conexión con la base de datos.";
        }
        ?>


    </main>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>