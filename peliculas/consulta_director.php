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
        <?php echo "<h2>Añadir Directores</h2>"; ?>
        <form action="" method="post">
            <select id="nombre_director" name="nombre_director" onclick="mostrarDirectores()" required>
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
            if (isset($_POST['nombre_director'])) {
                $nombre_director = $_POST['nombre_director'];

                $sql = "SELECT d.nombre, d.imagen as director_imagen, titulo, p.imagen as pelicula_imagen, anyo_prod 
        FROM director d
        JOIN pelicula p on p.iddirector=d.iddirector
        WHERE d.nombre like :nombre_director";

                $stmt = $dbcon->prepare($sql);
                $nombre_director_like = '%' . $nombre_director . '%';

                $stmt->bindParam(':nombre_director', $nombre_director_like);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<table border='1'>
            <tr>
                <th>Director</th>
                <th>Director Imagen</th>
                <th>Título</th>
                <th>Película Imagen</th>
                <th>Año de Producción</th>
            </tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                <td>" . $row["nombre"] . "</td>
                <td><img src='data:image/jpeg;base64," . base64_encode($row["director_imagen"]) . "' alt='Director Imagen' width='100'></td>
                <td>" . $row["titulo"] . "</td>
                <td><img src='data:image/jpeg;base64," . base64_encode($row["pelicula_imagen"]) . "' alt='Película Imagen' width='100'></td>
                <td>" . $row["anyo_prod"] . "</td>
              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se encontraron películas con el ID de director '$nombre_director'.";
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