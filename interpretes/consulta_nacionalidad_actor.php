<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por actor</title>
    <link rel="stylesheet" type="text/css" href="../peliculas/style.css">
</head>

<body>
    <header>
        <img src="../imagenes/logo.jpg" alt="Logo" class="logo">
        <div class="title">
            <h1>Buscar por nacionalidad</h1>
        </div>
    </header>
    <form action="" method="post">
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
                echo "<table border='1'>
                        <tr>
                            <th>Actor</th>
                            <th>Nacionalidad</th>
                            <th>Imagen</th>
                        </tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . $row["nombre_inter"] . "</td>
                            <td>" . $row["nacionalidad"] . "</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt='Image' width='100'></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontró ninguna película con el nombre de actor '$nacionalidad'.";
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