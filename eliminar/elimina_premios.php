<?php
//seguridad de session
session_start();
if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] != 'Administrador') {
    header("Location:../error.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminación de Premios</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
            // Consulta para obtener los premios ganados por la película
            $sql_premios_pelicula = "SELECT o.edicion, p.titulo AS titulo, p.imagen AS pelicula_imagen, p.idpelicula as id
                    FROM o_pelicula o
                    JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_pelicula = $dbcon->prepare($sql_premios_pelicula);
            $stmt_premios_pelicula->execute();

            // Consulta para obtener los premios ganados por los actores en la película
            $sql_premios_actores = "SELECT o.edicion, i.nombre_inter AS interprete, p.titulo as titulo, i.imagen AS actor_imagen, i.idinterprete as id
                    FROM o_interprete o
                    JOIN interprete i ON o.idinterprete = i.idinterprete
                    JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_actores = $dbcon->prepare($sql_premios_actores);
            $stmt_premios_actores->execute();

            // Consulta para obtener los premios ganados por el guion de la película
            $sql_premios_guion = "SELECT o.edicion, g.nombre_guion AS guion, p.titulo as titulo, p.imagen as pelicula_imagen, o.idguion as id
                    FROM o_guion o
                    JOIN guion g ON o.idguion = g.idguion
                    JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_guion = $dbcon->prepare($sql_premios_guion);
            $stmt_premios_guion->execute();

            // Consulta para obtener los premios ganados por el director de la película
            $sql_premios_director = "SELECT o.edicion, d.nombre AS director, p.titulo as titulo, d.imagen AS director_imagen, o.iddirector as id
                    FROM o_director o
                    JOIN director d ON o.iddirector = d.iddirector
                    JOIN pelicula p ON o.idpelicula = p.idpelicula";

            $stmt_premios_director = $dbcon->prepare($sql_premios_director);
            $stmt_premios_director->execute();

            function displayCards($title, $stmt, $fields, $imageField = null, $idField = "id", $tipo = "tipo")
            {
                if ($stmt->rowCount() > 0) {
                    echo "<h2>$title</h2>";
                    echo "<div class='awards-cards'>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='award-card'>";
                        echo "<div class='award-card-content'>";
                        if ($imageField) {
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row[$imageField]) . "' alt='$title' class='award-image'>";
                        }
                        echo "<div class='award-details'>";
                        foreach ($fields as $field => $label) {
                            echo "<p><strong>$label:</strong> " . $row[$field] . "</p>";
                        }
                        echo "</div>";

                        echo "<span class='material-symbols-outlined'>
                        <a href='eliminar_premio.php?id={$row[$idField]}&tipo=$tipo' class='no-link-style'>delete</a>
                        </span>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "No se encontraron premios para $title.";
                }
            }

            echo "<div class='container'>";
            displayCards("Premios de películas", $stmt_premios_pelicula, ["edicion" => "Edición", "titulo" => "Título"], "pelicula_imagen", "id", "pelicula");
            displayCards("Premios de actores", $stmt_premios_actores, ["edicion" => "Edición", "interprete" => "Nombre del actor", "titulo" => "Película"], "actor_imagen", "id", "actor");
            displayCards("Premios de guion", $stmt_premios_guion, ["edicion" => "Edición", "guion" => "Guion", "titulo" => "Película"], "pelicula_imagen", "id", "guion");
            displayCards("Premios de directores", $stmt_premios_director, ["edicion" => "Edición", "director" => "Nombre del director", "titulo" => "Película"], "director_imagen", "id", "director");
            echo "</div>";

            $dbcon = null;
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