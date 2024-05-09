<?php
require_once "../funciones.php";
$ruta = obtenerdirseg();
require_once $ruta . "conectaDB.php";

$dbname = "mydb";
$dbcon = conectaDB($dbname);

if (isset($dbcon)) {
    // Consulta para obtener los premios ganados por la película
    $sql_premios_pelicula = "SELECT o.edicion, p.titulo AS premio, 'Mejor Película' AS tipo_premio, p.imagen AS pelicula_imagen
                            FROM o_pelicula o
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

    $stmt_premios_pelicula = $dbcon->prepare($sql_premios_pelicula);
    $stmt_premios_pelicula->execute();

    // Consulta para obtener los premios ganados por los actores en la película
    $sql_premios_actores = "SELECT o.edicion, i.nombre_inter AS premio, 'Mejor Actor' AS tipo_premio, i.imagen AS actor_imagen
                            FROM o_interprete o
                            JOIN interprete i ON o.idinterprete = i.idinterprete
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

    $stmt_premios_actores = $dbcon->prepare($sql_premios_actores);
    $stmt_premios_actores->execute();

    // Consulta para obtener los premios ganados por el guion de la película
    $sql_premios_guion = "SELECT o.edicion, g.nombre_guion AS premio, 'Mejor Guion' AS tipo_premio
                            FROM o_guion o
                            JOIN guion g ON o.idguion = g.idguion
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

    $stmt_premios_guion = $dbcon->prepare($sql_premios_guion);
    $stmt_premios_guion->execute();

    // Consulta para obtener los premios ganados por el director de la película
    $sql_premios_director = "SELECT o.edicion, d.nombre AS premio, 'Mejor Director' AS tipo_premio, d.imagen AS director_imagen
                            FROM o_director o
                            JOIN director d ON o.iddirector = d.iddirector
                            JOIN pelicula p ON o.idpelicula = p.idpelicula";

    $stmt_premios_director = $dbcon->prepare($sql_premios_director);
    $stmt_premios_director->execute();

    // Mostrar los premios de la película
    if ($stmt_premios_pelicula->rowCount() > 0) {
        echo "<h2>Premios de películas</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Edición</th>
                    <th>Premio</th>
                    <th>Tipo de Premio</th>
                    <th>Imagen de la Película</th>
                </tr>";
        while ($row = $stmt_premios_pelicula->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["edicion"] . "</td>
                    <td>" . $row["premio"] . "</td>
                    <td>" . $row["tipo_premio"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Imagen de la película' width='100'></td>
                    <td><a href='eliminar_premio.php?premio={$row["premio"]}&tipo=1'>Eliminar</a></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron premios para ninguna película.";
    }

    // Mostrar los premios de los actores
    if ($stmt_premios_actores->rowCount() > 0) {
        echo "<h2>Premios de actores</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Edición</th>
                    <th>Nombre del actor</th>
                    <th>Tipo de Premio</th>
                    <th>Imagen del Actor</th>
                </tr>";
        while ($row = $stmt_premios_actores->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["edicion"] . "</td>
                    <td>" . $row["premio"] . "</td>
                    <td>" . $row["tipo_premio"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["actor_imagen"]) . "' alt='Imagen del Actor' width='100'></td>
                    <td><a href='eliminar_premio.php?premio={$row["premio"]}&tipo=1'>Eliminar</a></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Ningún actor ha ganado premios individuales.";
    }

    // Mostrar los premios relacionados con el guion
    if ($stmt_premios_guion->rowCount() > 0) {
        echo "<h2>Premios relacionados con el guion</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Edición</th>
                    <th>Guion</th>
                    <th>Tipo de Premio</th>
                </tr>";
        while ($row = $stmt_premios_guion->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["edicion"] . "</td>
                    <td>" . $row["premio"] . "</td>
                    <td>" . $row["tipo_premio"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron premios relacionados con el guion.";
    }

    // Mostrar los premios relacionados con el director
    if ($stmt_premios_director->rowCount() > 0) {
        echo "<h2>Premios relacionados con el director</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Edición</th>
                    <th>Nombre del director</th>
                    <th>Tipo de Premio</th>
                    <th>Imagen del Director</th>
                </tr>";
        while ($row = $stmt_premios_director->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["edicion"] . "</td>
                    <td>" . $row["premio"] . "</td>
                    <td>" . $row["tipo_premio"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["director_imagen"]) . "' alt='Imagen del Director' width='100'></td>
                    <td><a href='eliminar_premio.php?premio={$row["premio"]}&tipo=1'>Eliminar</a></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron premios relacionados con el director.";
    }

    $dbcon = null;
} else {
    echo "Error: No se pudo establecer la conexión con la base de datos.";
}
?>
<br><br>
<footer>
    <li><a href="../index.php">Volver al menú</a></li>
    <p>© 2024 AGarcía. Todos los derechos reservados.</p>
</footer>
</body>
</html>
