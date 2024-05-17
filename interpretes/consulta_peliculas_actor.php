<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por película</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Buscar por película</h1>
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
    <br><br>
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

            $sql = "SELECT i.nombre_inter as nombre, i.imagen as imagen, anyo_nacimiento as anyo
                    FROM interprete i
                    JOIN actua a ON i.idinterprete = a.idinterprete
                    JOIN pelicula p ON a.idpelicula = p.idpelicula
                    WHERE p.titulo LIKE :titulo_pelicula";

            $stmt = $dbcon->prepare($sql);

            // Agregar % al principio y al final del título de la película para hacer una búsqueda parcial
            $titulo_pelicula_like = '%' . $titulo_pelicula . '%';

            $stmt->bindParam(':titulo_pelicula', $titulo_pelicula_like);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>Actor</th>
                            <th>Nacimiento</th>
                            <th>Imagen</th>
                        </tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . $row["nombre"] . "</td>
                            <td>" . $row["anyo"]. "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Imagen actor' width='100'></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron actores para la película con el título '$titulo_pelicula'.";
            }

            $dbcon = null;
        }
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