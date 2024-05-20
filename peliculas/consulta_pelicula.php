<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Base de Datos de Películas</h1>
        </div>
    </header>
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
    <main>

        <?php
        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        $sql = "SELECT p.titulo, p.anyo_prod, p.nacionalidad AS peli_nacionalidad, d.nombre AS director_nombre, p.imagen AS pelicula_imagen, d.imagen AS director_imagen
                FROM pelicula p
                JOIN dirige di ON di.idpelicula = p.idpelicula
                JOIN director d ON di.iddirector = d.iddirector";

        $stmt = $dbcon->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<h2>Peliculas</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Título</th>
                        <th>Año de producción</th>
                        <th>Nacionalidad</th>
                        <th>Imagen de Película</th>
                        <th>Director</th>
                        <th>Imagen de Director</th>
                        
                    </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . $row["titulo"] . "</td>
                        <td>" . $row["anyo_prod"] . "</td>
                        <td>" . $row["peli_nacionalidad"] . "</td>
                        <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Movie Image' width='100'></td>
                        <td>" . $row["director_nombre"] . "</td>
                        <td><img src='data:image/jpeg;base64," . base64_encode($row["director_imagen"]) . "' alt='Director Image' width='100'></td>
                        
                    </tr>";
            }
            echo "</table>";
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