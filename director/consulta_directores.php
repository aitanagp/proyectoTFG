<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Consulta de Películas por Director</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li>
                <a href="../peliculas/consulta_director.php">Buscar por nombre</a>
                <a href="consulta_nacimiento_director.php">Fecha nacimiento</a>
                <a href="consulta_nacionalidad_diretor.php">Fecha nacimiento</a>
                <a href="consulta_premios_director.php">Fecha nacimiento</a>
            </li>
        </ul>
    </nav>
    <?php
    require_once "../funciones.php";
    $ruta = obtenerdirseg();
    require_once $ruta . "conectaDB.php";

    $dbname = "mydb";
    $dbcon = conectaDB($dbname);

    $sql = "SELECT * FROM director";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Nacionalidad</th>
                        <th>Año de nacimiento</th>
                        <th>ID Película</th>
                        <th>Imagen</th>
                    </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["iddirector"] . "</td>
                    <td>" . $row["nombre"] . "</td>
                    <td>" . $row["nacionalidad"] . "</td>
                    <td>" . $row["anyo_nacimiento"] . "</td>
                    <td>" . $row["idpelicula"] . "</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Imagen del director' width='100'></td>
                  </tr>";
        }
        echo "</table>";
        $dbcon = null;
    } else {
        echo "Error: No se encontraron directores en la base de datos.";
    }
    ?>
    <br><br>
    <footer>
        <li><a href="../index.php">Volver al menú</a></li>
        <p>© 2024 AGarcía. Todos los derechos reservados.</p>
    </footer>
</body>

</html>