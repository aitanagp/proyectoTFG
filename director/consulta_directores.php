<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
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
            <li><a href="../alta/alta_directores.php">Alta</a></li>
            <li><a href="../eliminar/elimina_director.php">Eliminación</a></li>
            <li><a href="../director/consulta_directores.php">Consulta</a></li>
            <li><a href="../director/consulta_nacionalidad_director.php">Por nacionalidad</a></li>
            <li><a href="../director/consulta_nacimiento_director.php">Por fecha de nacimiento</a></li>
            <li><a href="../director/consulta_premios_director.php">Por premios</a></li>
        </ul>
    </nav>
    <main>
        <?php
        echo "<h2>Directores</h2>";

        require_once "../funciones.php";
        $ruta = obtenerdirseg();
        require_once $ruta . "conectaDB.php";

        $dbname = "mydb";
        $dbcon = conectaDB($dbname);

        // Consultar directores y sus películas
        $sql = "SELECT d.*, p.titulo AS pelicula
        FROM director d
        LEFT JOIN pelicula p ON d.iddirector = p.iddirector
        ORDER BY d.nombre, p.titulo";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $directores = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $iddirector = $row['iddirector'];
                if (!isset($directores[$iddirector])) {
                    $directores[$iddirector] = [
                        'nombre' => $row['nombre'],
                        'nacionalidad' => $row['nacionalidad'],
                        'anyo_nacimiento' => $row['anyo_nacimiento'],
                        'imagen' => $row['imagen'],
                        'peliculas' => []
                    ];
                }
                if ($row['pelicula']) {
                    $directores[$iddirector]['peliculas'][] = $row['pelicula'];
                }
            }

            foreach ($directores as $director) {
                echo "<table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Nacionalidad</th>
                    <th>Año de nacimiento</th>
                    <th>Imagen</th>
                    <th>Películas</th>
                </tr>";
                echo "<tr>
                <td>{$director['nombre']}</td>
                <td>{$director['nacionalidad']}</td>
                <td>{$director['anyo_nacimiento']}</td>
                <td><img src='data:image/jpeg;base64," . base64_encode($director['imagen']) . "' alt='Imagen del director' width='100'></td>
                <td>";
                if (!empty($director['peliculas'])) {
                    echo "<ul>";
                    foreach ($director['peliculas'] as $pelicula) {
                        echo "<li>{$pelicula}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "No tiene películas registradas.";
                }
                echo "</td></tr>";
                echo "</table><br>";
            }

            $dbcon = null;
        } else {
            echo "Error: No se encontraron directores en la base de datos.";
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